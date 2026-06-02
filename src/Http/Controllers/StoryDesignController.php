<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Visualization;

class StoryDesignController extends Controller
{
    public function edit(Story $story)
    {
        $visualizations = Visualization::published()->orderBy('title')->get();
        $blocks = [];
        if ($story->html) {
            $decoded = json_decode($story->html, true);
            if (is_array($decoded)) {
                $blocks = $decoded;
            }
        }

        return view('dissemination::manage.story.block-editor', compact('story', 'visualizations', 'blocks'));
    }

    public function update(Request $request, Story $story)
    {
        $request->validate([
            'blocks' => 'required|array',
            'blocks.*.type' => 'required|in:text,image,visualization,two-column',
            'blocks.*.data' => 'required|array',
        ]);

        $story->update(['html' => json_encode($request->blocks)]);

        return response('Success', 200);
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:png,jpg,jpeg']);

        $image = $request->file('image');
        $imageName = Str::uuid().'.'.$image->getClientOriginalExtension();
        $imagePath = $image->storeAs('stories/images', $imageName, 'public');

        return response()->json(['image_path' => asset('storage/'.$imagePath)]);
    }
}
