<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\VizBuilder;

use App\Http\Controllers\Controller;
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
        //dump($resource);
        return view('dissemination::manage.viz-builder.map.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    public function step3(Request $request)
    {
        $step = 3;
        $this->recordChartDesign(json_decode($request->get('data'), true), json_decode($request->get('layout'), true));
        if (! $this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.map.design');
        }
        $resource = session()->get('viz-wizard-resource');
        $visualization = $resource?->vizId ? Visualization::find($resource->vizId) : new Visualization(['livewire_component' => Chart::class]);
        return view('dissemination::manage.viz-builder.step3')
            ->with([
                'steps' => $this->steps,
                'currentStep' => 3,
                //'topics' => $topics,
                'resource' => $resource,
                'visualization' => $visualization,
                'type' => $this->type,
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
                'livewire_component' => Chart::class,
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
        return view('dissemination::manage.viz-builder.map.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource]);
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

    private function makeOptions($resource, $visualization = null)
    {
        $table = new Chart();
        $table->vizId = $visualization?->id;
        $table->preparePayload($resource->rawData);
        return $table->options;
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
                config: [...$this->getConfig(), 'editable' => true],
                vizId: $visualization->id,
                rawData: $rawData,
            );
        } else {
            $geojson = Geospatial::getGeoJson(1);
            $mapTrace = [
                'meta' => ["columnNames" => ["z" => "Population", "locations" => "geography"]],
                'type' => "choroplethmap",
                'zsrc' => 'Population',
                'locationssrc' => 'geography',
                'geojson' => json_decode($geojson),
                'showscale' => false,
                'featureidkey' => 'properties.name',
                "locationmode" => "geojson-id",
            ];
            $mapStyle = [
                /* height
                   data column
                   color scale?
                   zoom  */
                'height' => 700,
                'map' => [
                    'zoom' => 5,
                    'center' => ['lat' => 1, 'lon' => 1]
                ]
            ];
            $options = [

            ];
            $resource = new ChartDesignerResource(
                data: [$mapTrace],
                config: [...$this->getConfig(), 'editable' => true],
                defaultLayout: [ ...self::DEFAULT_LAYOUT, ...$mapStyle],
            );
        }
        session()->put('viz-wizard-resource', $resource);
    }
}
