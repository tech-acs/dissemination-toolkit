<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Http\Requests\MapRequest;
use Uneca\DisseminationToolkit\Jobs\ImportShapefileJob;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Services\AreaTree;
use Uneca\DisseminationToolkit\Services\ShapefileImporter;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $areaCounts = Area::select('level', DB::raw('count(*) AS count'))->groupBy('level')->get()->keyBy('level');
        $hierarchies = (new AreaTree())->hierarchies;
        $summary = collect($hierarchies)->map(function ($levelName, $level) use ($areaCounts) {
            return ($areaCounts[$level]?->count ?? 0) . ' ' . str($levelName)->plural();
        })->join(', ', ' and ');
        view()->share('hierarchies', $hierarchies);

        return (new SmartTableData(Area::query(), $request))
            ->columns([
                SmartTableColumn::make('name')->sortable(),
                SmartTableColumn::make('code')->sortable(),
                SmartTableColumn::make('level')->sortable()
                    ->setBladeTemplate('{{ ucfirst($hierarchies[$row->level] ?? $row->level) }}'),
                SmartTableColumn::make('path'),
                SmartTableColumn::make('geom')->setLabel('Has Map')
                    ->setBladeTemplate('<x-yes-no value="{{ $row->geom }}" />'),
            ])
            ->editable('manage.area.edit')
            ->searchable(['name', 'code'])
            ->sortBy('level')
            ->downloadable()
            ->view('dissemination::manage.area.index', compact('summary'));
    }

    public function create()
    {
        $levels = (new AreaTree)->hierarchies;
        return view('dissemination::manage.area.create', ['levels' => array_map(fn ($level) => ucfirst($level), $levels)]);
    }

    public function store(MapRequest $request)
    {
        $level = $request->integer('level');
        $files = $request->file('shapefile');
        $filename = Str::random(40);
        foreach ($files as $file) {
            $filenameWithExt = collect([$filename, $file->getClientOriginalExtension()])->join('.');
            $file->storeAs('/shapefiles', $filenameWithExt, 'imports');
        }
        $shpFile = collect([$filename, 'shp'])->join('.');
        $filePath = Storage::disk('imports')->path('shapefiles/' . $shpFile);

        $importer = new ShapefileImporter();
        $sampleFeature = $importer->sample($filePath);

        // Check for empty shapefiles
        if (empty($sampleFeature)) {
            throw ValidationException::withMessages([
                'shapefile' => ['The shapefile does not contain any valid features.'],
            ]);
        }

        // Check that shapefile has 'name' and 'code' columns in the attribute table
        if (! (array_key_exists('name', $sampleFeature['attribs']) && array_key_exists('code', $sampleFeature['attribs']))) {
            throw ValidationException::withMessages([
                'shapefile' => ["The shapefile needs to have 'name' and 'code' attributes"],
            ]);
        }

        ImportShapefileJob::dispatch($filePath, $level, auth()->user(), app()->getLocale());

        return redirect()->route('manage.area.index')
            ->withMessage("Importing is in progress. You will be notified when it is complete.");
    }

    public function edit(Area $area)
    {
        return view('dissemination::manage.area.edit', compact('area'));
    }

    public function update(Area $area, Request $request)
    {
        $area->update($request->only(['name', 'code']));
        return redirect()->route('manage.area.index')
            ->withMessage("The area has been updated");
    }

    public function destroy()
    {
        Area::truncate();
        return redirect()->route('manage.area.index')
            ->withMessage("The areas table has been truncated");
    }
}
