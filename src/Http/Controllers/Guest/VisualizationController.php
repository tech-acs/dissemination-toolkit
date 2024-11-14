<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Models\Visualization;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VisualizationController extends Controller
{
    public function index(Request $request)
    {
        $records = Visualization::published()
            ->when($request->has('keyword'), function (Builder $query) use ($request) {
                $locale = app()->getLocale();
                $keyword = $request->get('keyword');
                $query->where("title->{$locale}", 'ilike', "%{$keyword}%")
                    ->orWhereHas('tags', function ($query) use ($keyword) {
                        $query->where('name', 'ilike', "%{$keyword}%");
                    });
            })
            ->when(! empty($request->get('topic')), function (Builder $query) use ($request) {
                $query->whereRelation('topics', 'topic_id', '=', $request->get('topic'));
            })
            ->get()->sortByDesc('updated_at');
        $topics = Topic::all();
        return view('dissemination::guest.visualization.index', compact('records', 'topics'));
    }

    public function show(Visualization $visualization, Request $request)
    {
        if ($visualization->published || $request->user()) {
            if ($request->has('embed')) {
                return view('dissemination::guest.visualization.embed', compact('visualization'));
            }
            return view('dissemination::guest.visualization.show', compact('visualization'));
        }
        abort(403);
    }
}
