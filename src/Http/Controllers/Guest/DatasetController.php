<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Topic;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function __invoke(Request $request)
    {
        $records = Dataset::query()
            ->published()
            ->when(! empty($request->get('keyword')), function (Builder $query) use ($request) {
                $locale = app()->getLocale();
                $query->where("name->{$locale}", 'ilike', '%' . $request->get('keyword') . '%');
            })
            ->when(! empty($request->get('topic')), function (Builder $query) use ($request) {
                $query->whereRelation('topics', 'topic_id', '=', $request->get('topic'));
            })
            ->get()
            ->sortByDesc('updated_at')
            ->mapWithKeys(fn($dataset) => [ $dataset->id => $dataset->info() ]);
        $topics = Topic::all();
        return view('dissemination::guest.dataset.index', compact('records', 'topics'));
    }
}
