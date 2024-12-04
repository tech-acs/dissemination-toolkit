<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Story;
use Illuminate\Http\Request;

class StoryRestrictedStatusController extends Controller
{
    public function __invoke(Request $request, Story $story)
    {
        $restrictedStatus = $request->boolean('restricted');
        $story->update(['restricted' => $restrictedStatus]);
        return redirect()->route('manage.story.index')->withMessage('Story ' . ($restrictedStatus ? 'restricted' : 'shared'));
    }
}
