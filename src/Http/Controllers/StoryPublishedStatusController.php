<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Models\Story;

class StoryPublishedStatusController extends Controller
{
    public function __invoke(Request $request, Story $story)
    {
        $publishStatus = $request->boolean('published');
        $story->update(['published' => $publishStatus]);

        return redirect()->route('manage.story.index')->withMessage('Story '.($publishStatus ? 'published' : 'unpublished'));
    }
}
