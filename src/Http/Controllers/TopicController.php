<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Http\Requests\TopicRequest;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        return (new SmartTableData(Topic::query()->withCount(['indicators', 'visualizations', 'stories', 'datasets', 'documents']), $request))
            ->columns([
                SmartTableColumn::make('name')->sortable(),
                SmartTableColumn::make('coverage')->setLabel('Coverage')
                    ->setBladeTemplate('
                        {{ $row?->indicators_count }} indicators,
                        {{ $row?->visualizations_count }} visualizations,
                        {{ $row?->stories_count }} stories,
                        {{ $row?->datasets_count }} datasets,
                        {{ $row?->documents_count }} tables
                    '),
            ])
            ->editable('manage.topic.edit')
            ->deletable('manage.topic.destroy')
            ->searchable(['name', 'description'])
            ->sortBy('rank')
            ->downloadable()
            ->view('dissemination::manage.topic.index');
    }

    public function create()
    {
        return view('dissemination::manage.topic.create');
    }

    public function store(TopicRequest $request)
    {
        Topic::create($request->validated());
        return redirect()->route('manage.topic.index')->withMessage('Record created');
    }

    public function edit(Topic $topic)
    {
        return view('dissemination::manage.topic.edit', compact('topic'));
    }

    public function update(Topic $topic, TopicRequest $request)
    {
        $topic->update($request->validated());
        return redirect()->route('manage.topic.index')->withMessage('Record updated');
    }

    public function destroy(Topic $topic)
    {
        if ($topic->indicators->count() > 0) {
            return redirect()->back()->withErrors(
                new MessageBag(['There are indicators that belong to this topic and thus can not be deleted. Move the indicators to another topic before trying again.'])
            );
        }
        $topic->delete();
        return redirect()->route('manage.topic.index')->withMessage('Record deleted');
    }
}
