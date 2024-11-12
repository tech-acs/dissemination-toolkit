<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $records = Tag::withCount(['visualizations', 'stories','documents'])->get();
        return view('dissemination::manage.tag.index', compact('records'));
    }

    /*public function create()
    {
        return view('manage.tag.create');
    }

    public function store(Request $request)
    {
        $tag = Tag::create($request->only(['name']));
        return redirect()->route('manage.tag.index')->withMessage('Record created');
    }*/

    public function edit(Tag $tag)
    {
        return view('dissemination::manage.tag.edit', compact('tag'));
    }

    public function update(Tag $tag, Request $request)
    {
        $tag->update($request->only(['name']));
        return redirect()->route('manage.tag.index')->withMessage('Record updated');
    }

    public function destroy(Tag $tag)
    {
        //$tag->delete();
        return redirect()->route('manage.tag.index')->withMessage('Record deleted');
    }
}
