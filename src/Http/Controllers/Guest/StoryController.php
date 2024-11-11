<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Topic;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $records = Story::published()
            ->when($request->has('keyword'), function (Builder $query) use ($request) {
                $locale = app()->getLocale();
                $query->where("title->{$locale}", 'ilike', '%' . $request->get('keyword') . '%');
            })
            ->when(! empty($request->get('topic')), function (Builder $query) use ($request) {
                $query->whereRelation('topics', 'topic_id', '=', $request->get('topic'));
            })
            ->get()->sortByDesc('updated_at');
        $topics = Topic::all();
        return view('dissemination::guest.story.index', compact('records', 'topics'));
    }

    public function show(Story $story, Request $request)
    {
        if ($story->published || $request->user()) {
            return view('dissemination::guest.story.show', compact('story'));
        }
        abort(404);
    }
}
