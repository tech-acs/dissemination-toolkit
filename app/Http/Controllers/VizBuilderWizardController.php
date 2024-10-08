<?php

namespace App\Http\Controllers;

use App\Livewire\Visualizations\Chart;
use App\Livewire\Visualizations\Table;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\Visualization;
use App\Services\QueryBuilder;
use App\Services\Sorter;
use App\Traits\PlotlyDefaults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VizBuilderWizardController extends Controller
{
    use PlotlyDefaults;

    private function canShowStep(int $step): bool
    {
        return true;
    }

    private function getConfig(): array
    {
        return [
            ...self::DEFAULT_CONFIG,
            //'toImageButtonOptions' => ['filename' => $this->graphDiv . ' (' . now()->toDayDateTimeString() . ')'],
            'locale' => app()->getLocale(),
        ];
    }

    private function reset()
    {
        session()->forget([
            'step1.data', 'step1.indicatorName', 'step1.dataParams', 'step1.dataSources',
            'step2.data', 'step2.layout', 'step2.options', 'step2.vizType',
            'step3.description', 'step3.topicIds', 'step3.filterable',
        ]);
    }

    public function show(int $currentStep, Request $request)
    {
        if ($request->has('viz-id')) {
            $viz = Visualization::find($request->get('viz-id'));
            session()->put('viz-id', $viz->id);
            session()->put('step1.dataParams', $viz->data_params);
            session()->put('step1.indicatorName', $viz->title);
            $query = new QueryBuilder($viz->data_params);
            $rawData = Sorter::sort($query->get())->all();
            session()->put('step1.data', $rawData);
            session()->put('step1.dataSources', toDataFrame(collect(session('step1.data', []))));
            session()->put('step2.vizType', $viz->livewire_component);
            if (session('step2.vizType') === Table::class) {
                session()->put('step2.options', $viz->options);
            } else {
                session()->put('step2.data', $viz->data);
                session()->put('step2.layout', $viz->layout);
            }
            session()->put('step3.description', $viz->title);
            session()->put('step3.topicIds', $viz->topicIds);
            session()->put('step3.filterable', $viz->is_filterable);
        }
        $steps = [
            1 => 'Prepare data',
            2 => 'Visualize',
            3 => 'Review & save',
        ];
        $topics = Topic::pluck('name', 'id');
        if ($this->canShowStep($currentStep)) {
            return view("manage.viz-builder.$currentStep", compact('steps', 'topics', 'currentStep'));
        } else {
            return redirect()->back();
        }
    }

    public function update(int $currentStep, Request $request)
    {
        if ($currentStep === 1) {
            if ($request->has('reset')) {
                $this->reset();
                return back();
            }
            // 'data', 'indicatorName' and 'dataParams' already sent via the StateRecorder
            session()->put('step1.dataSources', toDataFrame(collect(session('step1.data', []))));
            return redirect()->route('manage.viz-builder-wizard.show.{currentStep}', 2);

        } elseif ($currentStep === 2) {
            session()->put('step2.vizType', request('viz', session('step2.vizType',Table::class)));
            session()->put('step2.data', json_decode(request('chart-data', '[]'), true));
            session()->put('step2.layout', json_decode(request('chart-layout', '{}'), true));
            if (session('step2.vizType') === Table::class) {
                session()->put('step2.options', array_replace_recursive(Table::DEFAULT_OPTIONS, []));
            } else {
                session()->put('step2.options', []);
            }
            return redirect()->route('manage.viz-builder-wizard.show.{currentStep}', 3);

        } elseif ($currentStep === 3) {
            $title = $request->get('title');
            $description = $request->get('description');
            $topicIds = $request->get('topicIds');
            $dataParams = session('step1.dataParams');
            $data = collect(session('step2.data'))
                ->map(function ($trace) {
                    unset($trace['x'], $trace['y']);
                    return $trace;
                });
            $layout = session('step2.layout', []);
            $options = session('step2.options', []);

            /*$viz = Auth::user()->visualizations()->create([
                'name' => str($title)->slug()->toString(),
                'title' => $title,
                'slug' => str($title)->slug()->toString(),
                'description' => $description,
                'topic_id' => $topicId,
                'type' => 'No longer needed. Drop this column',
                'data_params' => $dataParams,
                'data' => $data,
                'layout' => $layout,
                'options' => $options,
                'livewire_component' => session('step2.vizType')
            ]);*/

            $validator = Validator::make(
                [
                    'title' => $title,
                    'topicIds' => $topicIds,
                    'dataParams' => $dataParams,
                    'data' => $data,
                    'layout' => $layout,
                ],
                [
                    'title' => 'required',
                    'topicIds' => 'required|array|min:1',
                    'dataParams' => 'required|array',
                    'layout' => Rule::requiredIf(session('step2.vizType') == Chart::class),
                    'data' => Rule::requiredIf(session('step2.vizType') == Chart::class),
                ],
                [
                    'data.required' => 'Make sure there is some data',
                    'dataParams.required' => 'You have not set valid data parameters'
                ],
            );

            if ($validator->passes()) {
                $viz = Auth::user()->visualizations()->updateOrCreate(
                    ['id' => session('viz-id')],
                    [
                        'name' => str($title)->slug()->toString(),
                        'title' => $title,
                        'slug' => str($title)->slug()->toString(),
                        'description' => $description,
                        'topicIds' => $topicIds,
                        'type' => 'No longer needed. Drop this column',
                        'data_params' => $dataParams,
                        'data' => $data,
                        'layout' => $layout,
                        'options' => $options,
                        'livewire_component' => session('step2.vizType')
                    ]
                );
                if ($viz->exists()) {
                    $updatedTags = Tag::prepareForSync($request->get('tags', ''));
                    $viz->tags()->sync($updatedTags->pluck('id'));

                    $this->reset();
                    return redirect()->route('manage.visualization.index')->withMessage('Visualization successfully created');
                }
            } else {
                $errors = $validator->errors();
                return redirect()->back()->withErrors($errors);
            }
        }
    }

    public function ajaxSaveChart(Request $request)
    {
        $traces = collect($request->json('data'));
        $layout = $request->get('layout');

        logger('Save', ['request' => $request->all()]);

        session()->put('step2.layout', $layout);
        session()->put('step2.data', $traces);
    }

    public function ajaxGetChart(Request $request)
    {
        $dataSources = session('step1.dataSources', []);
        $data = session('step2.data');
        $layout = session('step2.layout');
        return [
            'dataSources' => $dataSources,
            'data' => $data,
            'layout' => $layout,
            'config' => [...$this->getConfig(), 'editable' => true],
            'title' => '',
        ];
    }
}
