<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Uneca\DisseminationToolkit\Actions\CreateDimensionAction;
use Uneca\DisseminationToolkit\Actions\RemoveDimensionAction;
use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Http\Requests\DimensionRequest;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;
use Illuminate\Http\Request;

class DimensionController extends Controller
{
    public function index(Request $request)
    {
        return (new SmartTableData(Dimension::query(), $request))
            ->columns([
                SmartTableColumn::make('name')->sortable(),
                SmartTableColumn::make('table_name')->setLabel('Table Name')->sortable(),
                SmartTableColumn::make('values')->setLabel('Values')
                    ->setBladeTemplate('{{ $row->values_count }}
                                        @if(! $row->is_complete)
                                            <a title="Value set is incomplete (must contain code _T)"><x-dissemination::icon.exclamation-circle class="-mt-0.5" /></a>
                                        @endif'),
                SmartTableColumn::make('for')->setLabel('Applies to')
                    ->setBladeTemplate('{{ implode(" | ", $row->for) }}'),
            ])
            ->editable('manage.dimension.edit')
            ->searchable(['name', 'table_name'])
            ->sortBy('name')
            //->downloadable()
            ->view('dissemination::manage.dimension.index');
    }

    public function create()
    {
        $factTables = config('dissemination.fact_tables', []);
        $dimension = new Dimension();
        return view('dissemination::manage.dimension.create', compact('factTables', 'dimension'));
    }

    private function makeTableName(string $dimensionName): string
    {
        return str($dimensionName)->lower()->snake()->toString();
    }

    public function store(DimensionRequest $request)
    {
        $request->merge(['table_name' => $this->makeTableName($request->get('name'))]);
        $dimension = Dimension::create($request->only(['name', 'description', 'table_name', 'sorting_type', 'for']));
        if ($dimension) {
            $successful = (new CreateDimensionAction)->handle($dimension);
            if (! $successful) {
                $dimension->delete();
                return redirect()->route('manage.dimension.index')->withErrors('Could not create the dimension');
            }
        }
        return redirect()->route('manage.dimension.index')->withMessage('Dimension created');
    }

    public function edit(Dimension $dimension)
    {
        $factTables = config('dissemination.fact_tables');
        return view('dissemination::manage.dimension.edit', compact('dimension', 'factTables'));
    }

    public function update(Dimension $dimension, DimensionRequest $request)
    {
        $dimension->update($request->only(['name', 'description', 'sorting_type', 'for']));
        return redirect()->route('manage.dimension.index')->withMessage('Dimension updated');
    }

    public function destroy(Dimension $dimension)
    {
        if (is_null($dimension->table_created_at)) {
            $dimension->delete();
        } else {
            if ($dimension->datasets()->count() > 0) {
                return redirect()->route('manage.dimension.index')->withErrors('Dimension is used in a dataset');
            }
            if (! (new RemoveDimensionAction)->handle($dimension)) {
                return redirect()->route('manage.dimension.index')->withErrors('Could not remove the dimension');
            }
        }
        return redirect()->route('manage.dimension.index')->withMessage('Dimension removed');
    }
}
