<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;

class DatasetController extends Controller
{
    public function index()
    {
        $records = Dataset::with('indicators', 'dimensions', 'topics')->orderByDesc('updated_at')->get();
        return view('dissemination::manage.dataset.index', compact('records'));
    }

    public function create()
    {
        /*$indicators = Indicator::orderBy('name')->get();
        $dimensions = Dimension::orderBy('name')->get();
        $factTables = config('dissemination.fact_tables');
        $areaLevels = (new AreaTree())->hierarchies;
        $dataset = new Dataset();*/
        return view('dissemination::manage.dataset.create');
    }

    /*public function store(DatasetRequest $request)
    {
        $dataset = Dataset::create($request->only(['fact_table', 'max_area_level', 'name', 'description']));
        $dataset->indicators()->sync($request->indicators);
        $dataset->dimensions()->sync($request->dimensions);
        $inheritedTopics = $dataset->indicators->pluck('topics')->flatten()->pluck('id')->unique();
        $dataset->topics()->sync($inheritedTopics);
        return redirect()->route('manage.dataset.index')->withMessage('Record created');
    }*/

    public function edit(Dataset $dataset)
    {
        /*$indicators = Indicator::orderBy('name')->get();
        $dimensions = Dimension::orderBy('name')->get();
        $factTables = config('dissemination.fact_tables');
        $areaLevels = (new AreaTree())->hierarchies;*/
        return view('dissemination::manage.dataset.edit', compact('dataset'));
    }

    /*public function update(Dataset $dataset, DatasetRequest $request)
    {
        $dataset->update($request->only(['fact_table', 'max_area_level', 'name', 'description']));
        $dataset->indicators()->sync($request->indicators);
        $dataset->dimensions()->sync($request->dimensions);
        $inheritedTopics = $dataset->indicators->pluck('topics')->flatten()->pluck('id')->unique();
        $dataset->topics()->sync($inheritedTopics);
        return redirect()->route('manage.dataset.index')->withMessage('Record updated');
    }*/

    public function destroy(Dataset $dataset)
    {
        $warning = "The dataset contains data and therefore should not be deleted.
                    If you want to remove the dataset along with the data and other references, visit this url: " . url()->route('manage.dataset.remove', $dataset);
        if ($dataset->observationsCount() > 0) {
            return redirect()->route('manage.dataset.index')->withErrors($warning);
        }
        $dataset->delete();
        return redirect()->route('manage.dataset.index')->withMessage('Record deleted');
    }
}
