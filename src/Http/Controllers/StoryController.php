<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Http\Requests\StoryRequest;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        return (new SmartTableData(Story::query(), $request))
            ->columns([
                SmartTableColumn::make('title')->sortable()
                    ->setBladeTemplate('{{ $row->title }} <x-dissemination::icon.featured class="text-amber-600 -mt-2" :value="$row->featured" />'),
                SmartTableColumn::make('topic')
                    ->setBladeTemplate('{{ $row->topics?->pluck("name")->join(", ") }}'),
                SmartTableColumn::make('published_at')->setLabel('Status')
                    ->setBladeTemplate('<x-dissemination::yes-no value="{{ $row->published }}" true-label="Published" false-label="Draft" />'),
                SmartTableColumn::make('author')
                    ->setBladeTemplate('{{ $row->user->name }}'),
                SmartTableColumn::make('updated_at')->setLabel('Last Updated')->sortable()
                    ->setBladeTemplate('{{ $row->updated_at->format("M j, H:i") }}'),
            ])
            ->searchable(['title'])
            ->sortBy('updated_at')
            ->sortDesc()
            ->view('dissemination::manage.story.index');
    }

    public function create()
    {
        $tags = Tag::all();
        $topics = Topic::pluck('name', 'id');
        $templates = collect(); //(new StoryTemplateStore())->getAll();
        $story = (new Story());
        return view('dissemination::manage.story.create', compact('tags', 'topics', 'templates', 'story'));
    }

    public function store(StoryRequest $request)
    {
        if ($request->file('image')) {
            $path = $request->file('image')->storeAs('stories', $request->file('image')->getClientOriginalName(), 'public');
            $request->merge(['featured_image' => "storage/$path"]);
        }
        $story = Auth::user()->stories()->create($request->only(['title',  'description', 'featured', 'is_filterable', 'is_reviewable', 'featured_image']));
        $story->update(['html' => '']);//(new StoryTemplateStore)->get($request->get('template_id'))->getHtml()]);
        $updatedTags = Tag::prepareForSync($request->get('tags', ''));
        $story->tags()->sync($updatedTags->pluck('id'));
        $story->topics()->sync($request->get('topics'));
        return redirect()->route('manage.story.index')->withMessage('Story created');
    }

    public function edit(Story $story)
    {
        $tags = Tag::all();
        $topics = Topic::pluck('name', 'id');
        return view('dissemination::manage.story.edit', compact('story', 'tags', 'topics'));
    }

    public function update(StoryRequest $request, Story $story)
    {
        if ($request->file('image')) {
            $path = $request->file('image')->storeAs('stories', $request->file('image')->getClientOriginalName(), 'public');
            $request->merge(['featured_image' => "storage/$path"]);
        }
        $story->update($request->only(['title', 'description', 'featured', 'is_filterable', 'is_reviewable', 'featured_image']));
        $updatedTags = Tag::prepareForSync($request->get('tags'));
        $story->tags()->sync($updatedTags->pluck('id'));
        $story->topics()->sync($request->get('topics'));
        return redirect()->route('manage.story.index')->withMessage('Story updated');
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return redirect()->route('manage.story.index')->withMessage('Story deleted');
    }
}
