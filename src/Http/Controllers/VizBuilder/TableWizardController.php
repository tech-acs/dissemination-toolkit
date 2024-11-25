<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\VizBuilder;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Visualization;
use Uneca\DisseminationToolkit\Services\QueryBuilder;
use Uneca\DisseminationToolkit\Services\Sorter;
use Illuminate\Support\Facades\Auth;
use Uneca\DisseminationToolkit\Http\Requests\VisualizationRequest;
use Uneca\DisseminationToolkit\Http\Resources\TableDesignerResource;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Table;

class TableWizardController extends Controller
{
    public const DEFAULT_OPTIONS = [
        'defaultColDef' => [
            'width' => 100,
        ],
        'columnTypes' => [
            'rangeColumn' => [
                'width' => 150
            ]
        ],
        'columnDefs' => [],
        'rowData' => [],
        'autoSizeStrategy' => [
            'type' => 'fitGridWidth'
        ],
    ];

    private array $steps = [
        1 => 'Prepare data',
        2 => 'Design table',
        3 => 'Add metadata & save',
    ];
    private string $type = 'table';

    public function step1()
    {
        $step = 1;
        $this->setupResource();
        return view('dissemination::manage.viz-builder.step1')->with(['steps' => $this->steps, 'currentStep' => $step, 'type' => $this->type]);
    }

    public function step2()
    {
        $step = 2;
        if (! $this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.table.step1')
                ->withErrors('You must prepare appropriate data for your visualization before proceeding to the next step');
        }
        $resource = session()->get('viz-wizard-resource');
        $options = $this->makeOptions($resource);
        //dd($options);
        return view('dissemination::manage.viz-builder.table.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    public function step3()
    {
        $step = 3;
        if (! $this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.table.design');
        }
        $resource = session()->get('viz-wizard-resource');
        $visualization = $resource?->vizId ? Visualization::find($resource->vizId) : new Visualization(['livewire_component' => Table::class, 'title' => $resource->indicatorTitle]);
        return view('dissemination::manage.viz-builder.step3')
            ->with([
                'steps' => $this->steps,
                'currentStep' => 3,
                'resource' => $resource,
                'visualization' => $visualization,
                'type' => $this->type
            ]);
    }

    public function store(VisualizationRequest $request)
    {
        $step = 3;
        if (! $this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.table.prepare-data');
        }
        $title = $request->get('title');
        $description = $request->get('description');
        $isFilterable = $request->boolean('filterable');
        $isReviewable = $request->boolean('is_reviewable');
        $isPublished = $request->boolean('published');
        $resource = session()->get('viz-wizard-resource');
        $vizInfo = [
            'title' => $title,
            'slug' => str($title)->slug()->toString(),
            'description' => $description,
            'is_filterable' => $isFilterable,
            'is_reviewable' => $isReviewable,
            'published' => $isPublished,
            'options' => $resource->options,
            //'thumbnail' => $resource?->thumbnail,
        ];

        if ($resource?->vizId) {
            $visualization = Visualization::find($resource->vizId);
            $visualization->update($vizInfo);
        } else {
            $visualization = Auth::user()->visualizations()->create([
                'name' => str($title)->slug()->toString(),
                'data_params' => $resource->dataParams,
                'options' => $resource->options,
                'livewire_component' => Table::class,
                ...$vizInfo
            ]);
        }

        if ($visualization->exists()) {
            $visualization->tags()->sync(Tag::prepareForSync($request->get('tags', ''))->pluck('id'));
            $indicators = $visualization->data_params['indicators'] ?? [];
            $inheritedTopics = Indicator::findMany($indicators)->pluck('topics')->flatten()->pluck('id')->unique();
            $visualization->topics()->sync($inheritedTopics);

            session()->forget('viz-wizard-resource');

            return redirect()->route('manage.visualization.index')->withMessage('Visualization successfully saved');
        }
    }

    public function edit(int $visualizationId)
    {
        $step = 2;
        $visualization = Visualization::find($visualizationId);
        // ToDo: if not found...redirect back to index with error message
        $this->setupResource($visualization);
        if (! $this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.table.step1');
        }
        $resource = session()->get('viz-wizard-resource');
        //$options = $this->makeOptions($resource, $visualization);
        $options = $resource->options;
        //dump('In edit', $resource, $options);
        return view('dissemination::manage.viz-builder.table.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    private function isStepValid($step): bool
    {
        $resource = session()->get('viz-wizard-resource');
        return (! is_null($resource)) && (! empty($resource->dataSources));
    }

    private function makeOptions($resource, $visualization = null)
    {
        $table = new Table();
        $table->vizId = $visualization?->id;
        $table->preparePayload($resource->rawData);
        return $table->options;
    }

    private function setupResource(Visualization $visualization = null)
    {
        if ($visualization) {
            $query = new QueryBuilder($visualization->data_params);
            $rawData = Sorter::sort($query->get())->all();
            $resource = new TableDesignerResource(
                dataSources: toDataFrame(collect($rawData))->toArray(),
                //data: $visualization->data,
                options: $visualization->options,
                vizId: $visualization->id,
                rawData: $rawData,
            );
        } else {
            $resource = new TableDesignerResource(
                options: self::DEFAULT_OPTIONS,
            );
        }
        //dd($resource, $visualization);
        session()->put('viz-wizard-resource', $resource);
    }
}
