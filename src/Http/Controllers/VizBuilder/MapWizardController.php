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

    private function getConfig(): array
    {
        return [
            ...self::DEFAULT_CONFIG,
            //'toImageButtonOptions' => ['filename' => $this->graphDiv . ' (' . now()->toDayDateTimeString() . ')'],
            'locale' => app()->getLocale(),
        ];
    }

    public function step2()
    {
        $step = 2;
        if (!$this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.map.step1')
                ->withErrors('You must prepare appropriate data for your visualization before proceeding to the next step');
        }
        $resource = session()->get('viz-wizard-resource');
        $options = $this->makeOptions($resource);
        $resource = $this->addCurrentValuesToResource($resource, $options);

        //dump($resource, $options);
        return view('dissemination::manage.viz-builder.map.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    private function isStepValid($step): bool
    {
        $resource = session()->get('viz-wizard-resource');
        return (!is_null($resource)) && (!empty($resource->dataSources));
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
            'layout.map.zoom' => [
                'type' => 'select',
                'label' => 'Zoom level',
                'options' => [4, 5, 6, 7, 8],
                'value' => $visualization->layout['map']['zoom'] ?? config('dissemination.map.starting_zoom')
            ],
            'layout.map.style' => [
                'type' => 'select',
                'label' => 'Base map',
                'options' => ["Blank Background", "Open Street Map", "Google Hybrid", "Open Topo Map", "CartoDB"]
                ,
                'value' => $visualization->layout['map']['style'] ?? 'Open Street Map'
            ],
            'layout.legend.orientation' => [
                'type' => 'select',
                'label' => 'Legend orientation',
                'options' => ['Vertical', 'Horizontal'],
                'value' => $visualization->layout['legend']['orientation'] ?? 'Vertical'
            ],
            'layout.legend.type'=>[
                'type' => 'select',
                'label' => 'Legend type',
                'options' => ['continuous', 'categorical'],
                'value' => $visualization->layout['legend']['type'] ?? 'categorical'
            ],
            'layout.legend.position' => [
                'type' => 'select',
                'label' => 'Legend position',
                'options' => ['bottomright', 'topleft', 'topright', 'bottomleft'],
                'value' => $visualization->layout['legend']['position'] ?? 'bottomright'
            ],
            'layout.showlegend' => [
                'type' => 'select',
                'label' => 'Show legend',
                'options' => ['No', 'Yes'],
                'value' => $visualization->layout['showlegend'] ?? 'Yes'
            ],
            'layout.steps' => [
                'type' => 'select',
                'label' => 'Steps',
                'options' => [3, 5, 7, 9],
                'value' => $visualization->layout['steps'] ?? 5
            ],
            'layout.colorpallette' => [
                'type' => 'select',
                'label' => 'Color pallette',
                'options' => [
                    'BuGn', 'BuPu', 'GnBu', 'OrRd', 'PuBu', 'PuBuGn', 'PuRd', 'RdPu', 'YlGn', 'YlGnBu', 'YlOrBr', 'YlOrRd', 'Blues', 'Greens', 'Greys', 'Oranges', 'Purples', 'Reds', 'BrBG', 'PiYG', 'PRGn', 'PuOr', 'RdBu', 'RdGy', 'RdYlBu', 'RdYlGn', 'Spectral', 'Accent', 'Dark2', 'Paired', 'Pastel1', 'Pastel2', 'Set1', 'Set2', 'Set3', 'Rag',
                ],
                'value' => $visualization->layout['colorpallette'] ?? 'BuGn'
            ],

        ];
    }

    private function addCurrentValuesToResource($resource, $options)
    {
        $areaIds = array_merge(...array_values($resource->dataParams['geographies']));
        $geojson = Geospatial::getGeoJsonByAreaId($areaIds ?? []);
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

    public function step3(Request $request)
    {
        $step = 3;
        if (!$this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.map.step1');
        }
        $resource = session()->get('viz-wizard-resource');
        //dump($resource);
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
        if (!$this->isStepValid($step)) {
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
        if (!$this->isStepValid($step)) {
            return redirect()->route('manage.visualization.index')
                ->withMessage('The visualization is either broken or could not be located');
        }
        $resource = session()->get('viz-wizard-resource');
        //dump('from db', $resource);
        $options = $this->makeOptions($resource, $visualization);
        $resource = $this->addCurrentValuesToResource($resource, $options);
        //dump('synt', $resource, $options);
        return view('dissemination::manage.viz-builder.map.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    public function ajaxGetChart()
    {
        return session('viz-wizard-resource');
    }

    private function recordChartDesign(array $data, array $layout): void
    {
        $resource = session()->get('viz-wizard-resource');
        $resource->data = $data;
        $resource->layout = $layout;
        session()->put('viz-wizard-resource', $resource);
    }
}
