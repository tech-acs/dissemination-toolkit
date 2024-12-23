<?php

namespace Uneca\DisseminationToolkit\Services;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use Uneca\DisseminationToolkit\Enums\SortDirection;
use Spatie\SimpleExcel\SimpleExcelWriter;

class SmartTableData
{
    public Builder $builder;
    public Request $request;
    public Collection $columns;
    public Collection $sortableColumns;
    public LengthAwarePaginator $rows;
    public Collection $searchableColumns;
    public string $searchPlaceholder;
    public ?string $searchHint;
    public ?string $showRouteName;
    public ?string $editRouteName;
    public ?string $deleteRouteName;
    public bool $isDownloadable = false;
    public ?string $downloadableFileName;
    public string $sortBy;
    public SortDirection $sortDirection = SortDirection::ASC;
    public int $defaultPageSize;

    public function __construct(Builder $builder, Request $request)
    {
        $this->builder = $builder;
        $this->request = $request;
        $this->searchableColumns = collect();
        $this->searchPlaceholder = __('Search');
        $this->defaultPageSize = config('dissemination.records_per_page');
        return $this;
    }

    public function columns(array $columns): self
    {
        $this->columns = collect($columns)->map(function ($column) {
            $column->belongsTo($this);
            return $column;
        });
        $this->sortableColumns = $this->columns
            ->filter(fn ($c) => $c->isSortable())
            ->map(fn ($c) => $c->attribute);
        return $this;
    }

    public function sortBy(string $column): self
    {
        if ($this->request->has('sort_by') && $this->sortableColumns->contains($this->request->get('sort_by'))) {
            $this->sortBy = $this->request->get('sort_by');
            return $this;
        }
        $this->sortBy = $column;
        return $this;
    }

    public function sortDesc()
    {
        $this->sortDirection = SortDirection::DESC;
        return $this;
    }

    public function searchable(array $columns, $searchHint = null): self
    {
        $this->searchableColumns = collect($columns);
        $this->searchHint = $searchHint;
        if (is_null($searchHint) && $this->searchableColumns->isNotEmpty()) {
            $this->searchHint = "Search by " .
                $this->searchableColumns
                    ->map(fn ($col) => str($col)->replace('_', ' '))
                    ->join(', ', ' or ');
        }
        return $this;
    }

    public function showable(string $showRouteName): self
    {
        $this->showRouteName = $showRouteName;
        return $this;
    }

    public function editable(string $editRouteName): self
    {
        $this->editRouteName = $editRouteName;
        return $this;
    }

    public function deletable(string $deleteRouteName): self
    {
        $this->deleteRouteName = $deleteRouteName;
        return $this;
    }

    public function downloadable(string $fileName = 'table'): self
    {
        $this->isDownloadable = true;
        $this->downloadableFileName = $fileName;
        return $this;
    }

    public function build(Request $request): void
    {
        if (! isset($this->sortBy)) {
            dd('You have not set a default sorting column');
        }
        if ($request->has('sort_by') && $this->sortableColumns->contains($request->get('sort_by'))) {
            $this->sortBy = $request->get('sort_by');
            $this->sortDirection = $request->enum('sort_direction', SortDirection::class) ?? SortDirection::ASC;
        }
        if ($request->has('page_size')) {
            Session::put('page_size', $request->get('page_size'));
        }
        $this->builder
            ->when($request->has('search'), function ($query) use ($request) {
                return $query->whereAny($this->searchableColumns->toArray(), 'ILIKE', '%' . $request->get('search') . '%');
            })
            ->when(isset($this->sortBy), function ($query) {
                return $query->orderBy($this->sortBy, $this->sortDirection->value);
            });
        $this->rows = $this->builder->clone()
            ->paginate(Session::get('page_size', $request->get('page_size', $this->defaultPageSize)));
    }

    public function view(string $view, array $data = [])
    {
        if ($this->request->has('download')) {
            if ($this->request->get('download') === 'all') {
                $this->build($this->request->replace(['search' => null]));
            } else {
                $this->build($this->request);
            }
            $path = storage_path("app/public/{$this->downloadableFileName}.csv");
            $writer = SimpleExcelWriter::create($path);
            $records = $this->builder->clone()->get();
            foreach ($records as $row) {
                $line = [];
                foreach ($this->columns as $column) {
                    $line[$column->getLabel()] = str(Blade::render($column->getBladeTemplate(), compact('row', 'column')))
                        ->stripTags()
                        ->trim()
                        ->value();
                }
                $writer->addRow($line);
            }
            return response()->download($path);
        }

        $this->build($this->request);
        return view($view, ['smartTableData' => $this, ...$data]);
    }
}
