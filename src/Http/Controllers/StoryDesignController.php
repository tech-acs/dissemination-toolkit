<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryDesignController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:png,jpg,jpeg']);

        $image = $request->file('image');
        $imageName = Str::uuid().'.'.$image->getClientOriginalExtension();
        $imagePath = $image->storeAs('stories/images', $imageName, 'public');

        return response()->json(['image_path' => asset('storage/'.$imagePath)]);
    }
}
