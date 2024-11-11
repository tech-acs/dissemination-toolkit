<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Story;

class StoryDuplicationController extends Controller
{
    public function __invoke(Story $story)
    {
        $duplicateStory = $story->replicate()->fill(['title' => $story->title . " (copy)", 'user_id' => auth()->user()->id]);
        $duplicateStory->save();
        return redirect()->route('manage.story.index')->withMessage('Story duplicated');
    }
}
