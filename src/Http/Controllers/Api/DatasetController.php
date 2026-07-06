<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Uneca\DisseminationToolkit\Actions\BuildDatasetAction;
use Uneca\DisseminationToolkit\Http\Resources\DatasetResource;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Services\DynamicDimensionModel;

class DatasetController
{
    private function abortUnlessPublished(Dataset $dataset): void
    {
        if (! $dataset->published) {
            throw new NotFoundHttpException;
        }
    }

    public function index(Request $request)
    {
        $perPage = (int) ($request->input('page.size', config('dissemination.api.per_page', 20)));

        $datasets = Dataset::published()
            ->with('topics', 'indicators', 'dimensions')
            ->paginate($perPage);

        return DatasetResource::collection($datasets);
    }

    public function show(Dataset $dataset)
    {
        $this->abortUnlessPublished($dataset);

        $dataset->load('topics', 'indicators', 'dimensions');

        return DatasetResource::make($dataset);
    }

    public function observations(Request $request, Dataset $dataset)
    {
        $this->abortUnlessPublished($dataset);

        $request->validate([
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $dataset->load('dimensions');
        $perPage = $request->integer('per_page', config('dissemination.api.per_page', 20));

        $dimensionFKs = $dataset->dimensions->pluck('foreign_key')->toArray();

        $paginator = DB::table($dataset->fact_table)
            ->where('dataset_id', $dataset->id)
            ->select(['indicator_id', 'area_id', ...$dimensionFKs, 'value'])
            ->paginate($perPage);

        $dimensionLookups = $dataset->dimensions->mapWithKeys(
            fn ($dim) => [$dim->foreign_key => (new DynamicDimensionModel($dim->table_name))->all()->keyBy('id')]
        );

        $areaIds = collect($paginator->items())->pluck('area_id')->unique()->values()->all();
        $areaLookups = Area::whereIn('id', $areaIds)->get()->keyBy('id');

        $resolved = collect($paginator->items())->map(function ($obs) use ($dataset, $dimensionLookups, $areaLookups) {
            $area = $areaLookups->get($obs->area_id);
            $row = [
                'indicator_id' => $obs->indicator_id,
                'area_id' => $obs->area_id,
                'area' => $area ? [
                    'code' => $area->code,
                    'name' => $area->getTranslations('name'),
                ] : null,
                'value' => $obs->value,
            ];

            foreach ($dataset->dimensions as $dim) {
                $fk = $dim->foreign_key;
                $value = $dimensionLookups[$fk]->get($obs->$fk);
                $row[$dim->code] = $value ? [
                    'id' => $value->id,
                    'code' => $value->code,
                    'name' => $value->name,
                ] : [
                    'id' => $obs->$fk,
                    'code' => null,
                    'name' => null,
                ];
            }

            return $row;
        });

        $dimensionCodeLists = $dataset->dimensions->mapWithKeys(
            fn ($dim) => [$dim->code => (new DynamicDimensionModel($dim->table_name))->all()]
        );

        return response()->json([
            'meta' => [
                'observations' => $resolved,
                'dimensions' => $dimensionCodeLists,
                'pagination' => [
                    'total' => $paginator->total(),
                    'per_page' => $paginator->perPage(),
                    'current_page' => $paginator->currentPage(),
                    'last_page' => $paginator->lastPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ],
            ],
            'jsonapi' => ['version' => '1.1'],
        ]);
    }

    public function metadata(Request $request, Dataset $dataset)
    {
        $this->abortUnlessPublished($dataset);

        $dataset->load('topics', 'indicators', 'dimensions');

        return response()->json([
            'meta' => [
                'name' => $dataset->getTranslations('name'),
                'description' => $dataset->getTranslations('description'),
                'code' => $dataset->code,
                'provenance' => [
                    'data_source' => $dataset->data_source,
                    'contributor' => $dataset->contributor,
                    'data_date' => $dataset->data_date,
                ],
                'coverage' => [
                    'topics' => $dataset->topics->map(fn ($t) => [
                        'id' => $t->id,
                        'name' => $t->getTranslations('name'),
                        'code' => $t->code,
                    ]),
                    'indicators' => $dataset->indicators->map(fn ($i) => [
                        'id' => $i->id,
                        'name' => $i->getTranslations('name'),
                        'code' => $i->code,
                    ]),
                ],
                'structure' => [
                    'fact_table' => $dataset->fact_table,
                    'max_area_level' => $dataset->max_area_level,
                    'dimensions' => $dataset->dimensions->map(fn ($d) => [
                        'id' => $d->id,
                        'name' => $d->getTranslations('name'),
                        'code' => $d->code,
                        'table_name' => $d->table_name,
                        'values_count' => $d->values_count,
                        'is_complete' => $d->is_complete,
                    ]),
                    'observations_count' => $dataset->observationsCount(),
                ],
            ],
            'jsonapi' => ['version' => '1.1'],
        ]);
    }

    public function download(Request $request, Dataset $dataset)
    {
        $this->abortUnlessPublished($dataset);

        $rows = (new BuildDatasetAction($dataset))->handle();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . ($dataset->code ?? "dataset-{$dataset->id}") . '.csv"',
        ];

        return response()->stream(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            if ($rows->isNotEmpty()) {
                fputcsv($handle, array_keys($rows->first()));
            }

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
