<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Api;

use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Http\Resources\TopicResource;
use Uneca\DisseminationToolkit\Models\Topic;

class TopicController
{
    public function index(Request $request)
    {
        $perPage = (int) ($request->input('page.size', config('dissemination.api.per_page', 20)));

        $topics = Topic::paginate($perPage);

        return TopicResource::collection($topics);
    }

    public function show(Topic $topic)
    {
        return TopicResource::make($topic);
    }
}
