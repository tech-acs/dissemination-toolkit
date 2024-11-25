<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\VizBuilder;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Uneca\DisseminationToolkit\Http\Resources\ChartDesignerResource;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Visualization;
use Uneca\DisseminationToolkit\Services\QueryBuilder;
use Uneca\DisseminationToolkit\Services\Sorter;
use Uneca\DisseminationToolkit\Traits\PlotlyDefaults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Uneca\DisseminationToolkit\Http\Requests\VisualizationRequest;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Scorecard;

class ScorecardWizardController extends Controller
{
    use PlotlyDefaults;

    private array $steps = [
        1 => 'Prepare data',
        2 => 'Design scorecard',
        3 => 'Add metadata & save',
    ];
    private string $type = 'scorecard';

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
            return redirect()->route('manage.viz-builder.map.step1')
                ->withErrors('You must prepare appropriate data for your visualization before proceeding to the next step');
        }
        $resource = session()->get('viz-wizard-resource');
        $options = $this->makeOptions($resource);
        $resource = $this->addCurrentValuesToResource($resource, $options);

        //dump($resource, $options);
        return view('dissemination::manage.viz-builder.scorecard.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
    }

    public function step3(Request $request)
    {
        $step = 3;
        if (! $this->isStepValid($step)) {
            return redirect()->route('manage.viz-builder.scorecard.step1');
        }
        $resource = session()->get('viz-wizard-resource');
        //dump($resource);
        $visualization = $resource?->vizId ? Visualization::find($resource->vizId) : new Visualization(['livewire_component' => Scorecard::class, 'title' => $resource->indicatorTitle]);
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
            return redirect()->route('manage.viz-builder.scorecard.prepare-data');
        }
        $title = $request->get('title');
        $description = $request->get('description');
        //$isFilterable = $request->boolean('filterable');
        $isPublished = $request->boolean('published');
        $resource = session()->get('viz-wizard-resource');

        $vizInfo = [
            'title' => $title,
            'slug' => str($title)->slug()->toString(),
            'description' => $description,
            'data' => $resource->data,
            'layout' => $resource->layout,
            'is_filterable' => false,
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
                'livewire_component' => Scorecard::class,
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
        $options = $this->makeOptions($resource, $visualization);
        $resource = $this->addCurrentValuesToResource($resource, $options);
        //dump('synt', $resource, $options);
        return view('dissemination::manage.viz-builder.scorecard.step2')->with(['steps' => $this->steps, 'currentStep' => $step, 'resource' => $resource, 'options' => $options]);
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
        $indicators = array_filter(array_keys($resource->dataSources), function ($column) {
            return str($column)->endsWith(QueryBuilder::VALUE_COLUMN_INVISIBLE_MARKER);
        });
        $firstIndicator = reset($indicators);
        return [
            'data.meta.columnNames.text' => [
                'type' => 'hidden',
                'value' => $firstIndicator
            ],
            'data.value' => [
                'type' => 'hidden',
                'value' => $resource->dataSources[$firstIndicator][0] ?? 0,
            ],
            'data.title.text' => [
                'type' => 'text',
                'label' => 'Title',
                'value' => $firstIndicator ?? 'Title'
            ],
            'data.title.align' => [
                'type' => 'select',
                'label' => 'Title alignment',
                'options' => ['left', 'center', 'right'],
                'value' => $visualization->data[0]['title']['align'] ?? 'center'
            ],
            'data.align' => [
                'type' => 'select',
                'label' => 'Value alignment',
                'options' => ['left', 'center', 'right'],
                'value' => 'center'
            ],
            'layout.paper_bgcolor' => [
                'type' => 'color',
                'label' => 'Background color',
                'value' => $visualization->layout['paper_bgcolor'] ?? '#d3d3d3'
            ],
            'layout.font.color' => [
                'type' => 'color',
                'label' => 'Font color',
                'value' => $visualization->layout['font']['color'] ?? '#000000'
            ],
            'layout.width' => [
                'type' => 'number',
                'label' => 'Width',
                'value' => 600
            ],
            'layout.height' => [
                'type' => 'number',
                'label' => 'Height',
                'value' => 250
            ],
        ];
    }

    private function addCurrentValuesToResource($resource, $options)
    {
        $indicatorTrace = [
            'type' => 'indicator',
            'mode' => 'number',
            'value' => 0,
            'align' => 'left',
            //'meta' => ['columnNames' => ['value' => '']],
            'title' => [
                'text' => 'Title',
                'align' => 'center',
                'font' => [
                    'size' => 40,
                ]
            ]
        ];

        $setValues = Arr::undot(array_map(fn($option) => $option['value'], $options));
        $setDataValues = $setValues['data'];
        $setLayoutValues = $setValues['layout'];
        $resource->data = [array_replace_recursive($indicatorTrace, $setDataValues)];

        $layout = [
            'height' => 250,
            'width' => 600,
            'margin' => ['l' => 0, 'r' => 0, 't' => 0, 'b' => 0],
            'paper_bgcolor' => 'lightgray',
            'font' => [
                'color' => 'black'
            ]
        ];
        $resource->layout = array_replace_recursive($layout, $setLayoutValues);
        //dump($setValues, $resource);
        return $resource;
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
