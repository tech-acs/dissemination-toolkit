<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index()
    {
        $records = Year::all();
        return view('manage.year.index', compact('records'));
    }

    public function create()
    {
        return view('manage.year.create');
    }

    public function store(Request $request)
    {
        $year = Year::create($request->only(['code', 'name']));
        return redirect()->route('manage.year.index')->withMessage('Record created');
    }

    public function edit(Year $year, Request $request)
    {
        return view('manage.year.edit', compact('year'));
    }

    public function update(Year $year, Request $request)
    {
        $year->update($request->only(['code', 'name']));
        return redirect()->route('manage.year.index')->withMessage('Record updated');
    }

    public function destroy(Year $year)
    {
        if (is_null($year->datasets)) {
            $year->delete();
            return redirect()->route('manage.year.index')->withMessage('Record deleted');
        } else {
            return redirect()->route('manage.year.index')->withErrors('There are datasets associated with this year and therefore it can not be deleted');
        }
    }
}
