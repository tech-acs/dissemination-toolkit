<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Http\Requests\IndicatorRequest;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index(Request $request)
    {
        return (new SmartTableData(Indicator::query()->with('topics'), $request))
            ->columns([
                SmartTableColumn::make('name')->sortable(),
                SmartTableColumn::make('topic')->setLabel('Topic')
                    ->setBladeTemplate('{{ $row?->topics?->pluck("name")->join(", ") }}'),
            ])
            ->editable('manage.indicator.edit')
            ->deletable('manage.indicator.destroy')
            ->searchable(['name', 'description'])
            ->sortBy('name')
            ->downloadable()
            ->view('dissemination::manage.indicator.index');
    }

    public function create()
    {
        $topics = Topic::pluck('name', 'id');
        $indicator = new Indicator();
        return view('dissemination::manage.indicator.create', compact('topics', 'indicator'));
    }

    public function store(IndicatorRequest $request)
    {
        $indicator = Indicator::create($request->only(['name', 'description', 'code']));
        $indicator->topics()->sync($request->get('topics'));
        return redirect()->route('manage.indicator.index')->withMessage('Record created');
    }

    public function edit(Indicator $indicator)
    {
        $topics = Topic::pluck('name', 'id');
        return view('dissemination::manage.indicator.edit', compact('indicator', 'topics'));
    }

    public function update(Indicator $indicator, IndicatorRequest $request)
    {
        $indicator->update($request->only(['name', 'description', 'code']));
        $indicator->topics()->sync($request->get('topics'));
        return redirect()->route('manage.indicator.index')->withMessage('Record updated');
    }

    public function destroy(Indicator $indicator)
    {
        //Check if the indicator has any related datasets
        if ($indicator->datasets()->count() > 0) {
            return redirect()->back()->withErrors(['This indicator has related datasets, please delete those first.']);
        }
        $indicator->delete();
        return redirect()->route('manage.indicator.index')->withMessage('Record deleted');
    }
}
