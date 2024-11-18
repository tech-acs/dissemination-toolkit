<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\VizBuilder;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Map;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Visualization;
use Uneca\DisseminationToolkit\Services\Geospatial;
use Uneca\DisseminationToolkit\Services\QueryBuilder;
use Uneca\DisseminationToolkit\Services\Sorter;
use Uneca\DisseminationToolkit\Traits\PlotlyDefaults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Uneca\DisseminationToolkit\Http\Requests\VisualizationRequest;
use Uneca\DisseminationToolkit\Http\Resources\ChartDesignerResource;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Chart;

class MapWizardController extends Controller
{
    use PlotlyDefaults;

    private array $steps = [
        1 => 'Prepare data',
        2 => 'Design map',
        3 => 'Add metadata & save',
    ];
    private string $type = 'map';

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
            return redirect()->route('manage.viz-builder.map.step1');
        }
        $resource = session()->get('viz-wizard-resource');
        $options = $this->makeOptions($resource);

        /*$areaIds = array_merge(array_values($resource->dataParams['geographies']));
        $geojson = Geospatial::getGeoJsonByAreaId($areaIds[0] ?? []);
        $mapTrace = [
            'type' => 'choroplethmap',
            'featureidkey' => 'properties.name',
            'locationmode' => 'geojson-id',
            'meta' => ['columnNames' => ['z' => '', 'locations' => 'geography']],
            'locationssrc' => 'geography',
            'geojson' => json_decode($geojson),
            'showscale' => false,
        ];

        $setValues = Arr::undot(array_map(fn($option) => $option['value'], $options));
        $setDataValues = $setValues['data'];
        $setLayoutValues = $setValues['layout'];
        foreach ($setDataValues as $key => $value) {
            if (in_array($key, ['showscale', 'autocolorscale'])) {
                $setDataValues[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }
        $resource->data = [array_replace_recursive($mapTrace, $setDataValues)];

        $layout = [
            ...self::DEFAULT_LAYOUT,
            'height' => 650,
            'margin' => ['l' => 0, 'r' => 0, 't' => 0, 'b' => 0],
            'map' => [
                'zoom' => config('dissemination.map.starting_zoom'),
                'center' => config('dissemination.map.center'),
                'style' => '',
            ]
        ];
        $resource->layout = array_replace_recursive($layout, $setLayoutValues);*/

        $resource = $this->addCurrentValuesToResource($resource, $options);

        //dump($resource, $options);
        return view('dissemination::manage.viz-builder.map.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    public function step3(Request $request)
    {
        $step = 3;
        if (! $this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.map.step1');
        }
        $resource = session()->get('viz-wizard-resource');
        dump($resource);
        $visualization = $resource?->vizId ? Visualization::find($resource->vizId) : new Visualization(['livewire_component' => Map::class, 'title' => $resource->indicatorTitle]);
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
            return redirect()->route('manage.viz-builder.map.prepare-data');
        }
        $title = $request->get('title');
        $description = $request->get('description');
        $isFilterable = $request->boolean('filterable');
        $isPublished = $request->boolean('published');
        $resource = session()->get('viz-wizard-resource');

        $vizInfo = [
            'title' => $title,
            'slug' => str($title)->slug()->toString(),
            'description' => $description,
            'data' => $resource->data,
            'layout' => $resource->layout,
            'is_filterable' => $isFilterable,
            'published' => $isPublished,
            'thumbnail' => $resource->thumbnail,
        ];
        if ($resource?->vizId) {
            $visualization = Visualization::find($resource->vizId);
            $visualization->update($vizInfo);
        } else {
            $visualization = Auth::user()->visualizations()->create([
                'name' => str($title)->slug()->toString(),
                'data_params' => $resource->dataParams,
                'livewire_component' => Map::class,
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
            return redirect()->route('manage.visualization.index')
                ->withMessage('The visualization is either broken or could not be located');
        }
        $resource = session()->get('viz-wizard-resource');
        //dump('from db', $resource);
        $options = $this->makeOptions($resource);
        $resource = $this->addCurrentValuesToResource($resource, $options);

        return view('dissemination::manage.viz-builder.map.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    public function ajaxGetChart()
    {
        return session('viz-wizard-resource');
    }

    private function isStepValid($step): bool
    {
        $resource = session()->get('viz-wizard-resource');
        return (! is_null($resource)) && (! empty($resource->dataSources));
    }

    private function getConfig(): array
    {
        return [
            ...self::DEFAULT_CONFIG,
            //'toImageButtonOptions' => ['filename' => $this->graphDiv . ' (' . now()->toDayDateTimeString() . ')'],
            'locale' => app()->getLocale(),
        ];
    }

    private function recordChartDesign(array $data, array $layout): void
    {
        $resource = session()->get('viz-wizard-resource');
        $resource->data = $data;
        $resource->layout = $layout;
        session()->put('viz-wizard-resource', $resource);
    }

    private function addCurrentValuesToResource($resource, $options)
    {
        $areaIds = array_merge(array_values($resource->dataParams['geographies']));
        $geojson = Geospatial::getGeoJsonByAreaId($areaIds[0] ?? []);
        $mapTrace = [
            'type' => 'choroplethmap',
            'featureidkey' => 'properties.name',
            'locationmode' => 'geojson-id',
            'meta' => ['columnNames' => ['z' => '', 'locations' => 'geography']],
            'locationssrc' => 'geography',
            'geojson' => json_decode($geojson),
            'showscale' => false,
        ];

        $setValues = Arr::undot(array_map(fn($option) => $option['value'], $options));
        $setDataValues = $setValues['data'];
        $setLayoutValues = $setValues['layout'];
        foreach ($setDataValues as $key => $value) {
            if (in_array($key, ['showscale', 'autocolorscale'])) {
                $setDataValues[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }
        $resource->data = [array_replace_recursive($mapTrace, $setDataValues)];

        $layout = [
            ...self::DEFAULT_LAYOUT,
            'height' => 650,
            'margin' => ['l' => 0, 'r' => 0, 't' => 0, 'b' => 0],
            'map' => [
                'zoom' => config('dissemination.map.starting_zoom'),
                'center' => config('dissemination.map.center'),
                'style' => '',
            ]
        ];
        $resource->layout = array_replace_recursive($layout, $setLayoutValues);
        //dump('mixed', $resource);
        return $resource;
    }

    private function makeOptions($resource, $visualization = null)
    {
        $indicators = array_filter(array_keys($resource->dataSources), function ($column) {
            return str($column)->endsWith(QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER);
        });
        $firstIndicator = reset($indicators);
        return [
            'data.meta.columnNames.z' => [
                'type' => 'hidden',
                'label' => 'Displayed indicator',
                'options' => array_values($indicators),
                'value' => $firstIndicator
            ],
            'data.zsrc' => [
                'type' => 'hidden',
                'value' => $firstIndicator,
            ],
            'data.autocolorscale' => [
                'type' => 'select',
                'label' => 'Auto color scale',
                'options' => ['No', 'Yes'],
                'value' => 'No'
            ],
            'data.colorscale' => [
                'type' => 'select',
                'label' => 'Color scale',
                'options' => ['Blackbody','Bluered','Blues','Cividis','Earth','Electric','Greens','Greys','Hot','Jet','Picnic','Portland','Rainbow','RdBu','Reds','Viridis','YlGnBu','YlOrRd'],
                'value' => 'Grey'
            ],
            'data.showscale' => [
                'type' => 'select',
                'label' => 'Display colorbar',
                'options' => ['No', 'Yes'],
                'value' => 'No'
            ],
            'layout.map.zoom' => [
                'type' => 'select',
                'label' => 'Zoom level',
                'options' => [4, 5, 6, 7, 8],
                'value' => config('dissemination.map.starting_zoom')
            ],
            'layout.map.style' => [
                'type' => 'select',
                'label' => 'Base map',
                'options' => ['basic', 'carto-darkmatter', 'carto-darkmatter-nolabels', 'carto-positron',
                    'carto-positron-nolabels', 'carto-voyager', 'carto-voyager-nolabels', 'dark', 'light',
                    'open-street-map', 'outdoors', 'satellite', 'satellite-streets', 'streets', 'white-bg'],
                'value' => 'streets'
            ],
        ];
    }

    private function setupResource(Visualization $visualization = null): void
    {
        if ($visualization) {
            $query = new QueryBuilder($visualization->data_params);
            $rawData = Sorter::sort($query->get())->all();
            $resource = new ChartDesignerResource(
                dataSources: toDataFrame(collect($rawData))->toArray(),
                data: $visualization->data,
                layout: $visualization->layout,
                config: $this->getConfig(),
                vizId: $visualization->id,
                dataParams: $visualization->data_params,
                rawData: $rawData,
            );
        } else {
            $resource = new ChartDesignerResource(config: $this->getConfig());
        }
        session()->put('viz-wizard-resource', $resource);
    }
}
