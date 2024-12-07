<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum;
use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Document;
use Uneca\DisseminationToolkit\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::published()
            ->when(! empty($request->get('keyword')), function (Builder $query) use ($request) {
                $locale = app()->getLocale();
                $query->where("title->$locale", 'ilike', '%' . $request->get('keyword') . '%');
                $query->orWhere("description->$locale", 'ilike', '%' . $request->get('keyword') . '%');
            })
            ->when(! empty($request->get('topic')), function (Builder $query) use ($request) {
                $query->whereHas('topics', function (Builder $query) use ($request) {
                    if ($request->get('topic') == 0) {
                        return;
                    }
                    $query->where('topics.id', $request->get('topic'));
                });
            })
            ->when($request->has('tags'), function (Builder $query) use ($request) {
                $query->whereHas('tags', function (Builder $query) use ($request) {
                    $query->whereIn('tags.id', $request->get('tags'));
                });
            });

        $fromYear = $request->get('fromYear');
        $toYear = $request->get('toYear');
        if ($fromYear && $toYear) {
            if ($fromYear > $toYear) {
                return redirect()->back()->withErrors(['fromYear' => "From year ($fromYear) must be less than to year ($toYear) for filtering"]);
            }
            $query->whereRaw("date_part('year', published_date) between $fromYear and $toYear");
        } elseif ($fromYear) {
            $query->whereRaw("date_part('year', published_date) >= $fromYear");
        } elseif ($toYear) {
            $query->whereRaw("date_part('year', published_date) <= $toYear");
        }

        if ($request->has('dataset_type') && $request->get('type') != 'all') {
            if ($request->get('dataset_type') != 'all') {
                $query->where('dataset_type', $request->get('dataset_type'));
            }
        }

        list($sortBy, $sortOrder) = $this->setSortOrder($request->get('sort', 'relevance'));
        $query->orderBy($sortBy, $sortOrder);

        $records = $query->paginate(config('app.page_size', 10));

        $sortOptions = $this->getSortOptions();
        $censusYears = $this->getCensusYears();
        $types = CensusTableTypeEnum::getTypes();
        $types->prepend((object) [
            'name' => 'All',
            'id' => 'all',
        ]);

        $tags = Tag::whereHas('documents')
            ->withCount('documents')->orderByDesc('documents_count')->orderBy('name')->get();

        return view('dissemination::guest.document.index', compact('records', 'sortOptions', 'censusYears', 'tags', 'types'));
    }

    public function show($id)
    {
        $censusTable = Document::published()->findOrFail($id);
        $censusTable->load(['topics', 'tags']);
        Document::where('id', $censusTable->id)
            ->increment('view_count', 1, ['updated_at' => $censusTable->updated_at]);

        $censusTable->updated_by = $censusTable->user->name;
        return view('dissemination::guest.document.show', compact('censusTable'));
    }

    public function download(Document $censusTable)
    {
        $censusTable = Document::published()->findOrFail($censusTable->id);
        Document::where('id', $censusTable->id)
            ->increment('download_count', 1, ['updated_at' => $censusTable->updated_at]);

        return Storage::disk('public')->download($censusTable->file_path, $censusTable->file_name);
    }

    private function setSortOrder(string $sortBy): array
    {
        switch ($sortBy) {
            case 'popularity':
                $sortBy = 'download_count';
                $sortOrder = 'DESC';
                break;
            case 'yearDesc':
                $sortBy = 'updated_at';
                $sortOrder = 'DESC';
                break;
            case 'year':
                $sortBy = 'updated_at';
                $sortOrder = 'ASC';
                break;
            case 'title':
                $sortOrder = 'ASC';
                break;
            case 'titleDesc':
                $sortBy = 'title';
                $sortOrder = 'DESC';
                break;
            case 'relevance':
            default:
                $sortBy = 'view_count';
                $sortOrder = 'DESC';
                break;
        }
        return array($sortBy, $sortOrder);
    }

    private function getSortOptions(): array
    {
        return [
            'relevance' => 'Relevance',
            'popularity' => 'Popularity',
            'yearDesc' => 'Recent ↑',
            'year' => 'Oldest ↓',
            'title' => 'Title (A-Z)',
            'titleDesc' => 'Title (Z-A)'
        ];
    }

    private function getCensusYears()
    {
        return Document::published()->
        selectRaw("distinct date_part('year', published_date) as id, date_part('year', published_date) as name")
            ->orderBy('name')->get();
    }
}
