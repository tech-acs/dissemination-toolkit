<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Chart;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Scorecard;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Table;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\Visualization;
use Uneca\DisseminationToolkit\Services\AreaTree;
use Uneca\DisseminationToolkit\Services\Geospatial;
use Uneca\DisseminationToolkit\Services\QueryBuilder;
use Uneca\DisseminationToolkit\Services\Sorter;
use Illuminate\Http\Request;

class VizAjaxController extends Controller
{
    /*public function index()
    {
        return Visualization::orderBy('livewire_component')
            ->published()
            ->get()
            ->map(function (Visualization $visualization) {
                return [
                    'id' => $visualization->id,
                    'name' => $visualization->title,
                ];
            })->all();
    }*/

    private function updateDataParam(array $dataParams, string $path): array
    {
        /*['id' => $id, 'level' => $level] = (new AreaTree)->getArea($path)->toArray();
        $dataParams['geographies'] = [$level => [$id]];*/

        $areaTree = new AreaTree();
        $level = $areaTree->levelFromPath($path);
        $childAreas = $areaTree->areas($path)
            ->map(fn (Area $area) => $area->id)
            ->all();
        $dataParams['geographies'] = [$level + 1 => $childAreas];
        return $dataParams;
    }

    public function show(Visualization $visualization, Request $request)
    {
        if ($visualization->type === 'Chart' || $visualization->type === 'Map') {
            $instance = new Chart();
            $instance->vizId = $visualization->id;
            $instance->mount();
            $path = $request->get('path');
            if ($path) {
                $dataParams = $this->updateDataParam($visualization->data_params, $path);
                //logger('Data params', ['original' => $visualization->data_params['geographies'], 'new' => $dataParams['geographies']]);
                $query = new QueryBuilder($dataParams);
                $rawData = Sorter::sort($query->get())->all();
                $instance->preparePayload($rawData);
                $areaIds = array_merge(...array_values($dataParams['geographies']));
                $geojson = Geospatial::getGeoJsonByAreaId($areaIds ?? []);
                $instance->data[0]['geojson'] = json_decode($geojson);
            }
            if ($visualization->type === 'Map') {
                foreach ($instance->data[0] ?? [] as $key => $value) {
                    if (in_array($key, ['showscale', 'autocolorscale'])) {
                        $instance->data[0][$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    }
                }
            }
            //logger('Returning..', ['data' => $instance->data]);
            return [
                'data' => $instance->data,
                'layout' => $instance->layout,
                'config' => $instance->config,
                'filterable' => $visualization->is_filterable,
            ];


        } elseif ($visualization->type === 'Table') {
            $instance = new Table();
            $instance->vizId = $visualization->id;
            $instance->mount();
            return [
                'options' => $instance->options,
                'filterable' => $visualization->is_filterable,
            ];
        } else { // Scorecard
            $instance = new Scorecard();
            $instance->vizId = $visualization->id;
            $instance->mount();
            $path = $request->get('path');
            if ($path) {
                $dataParams = $this->updateDataParam($visualization->data_params, $path);
                $query = new QueryBuilder($dataParams);
                $rawData = Sorter::sort($query->get())->all();
                $instance->preparePayload($rawData);
            }
            return [
                'data' => $instance->data,
                'layout' => $instance->layout,
                'config' => $instance->config,
                'filterable' => $visualization->is_filterable,
            ];
        }

    }
}
