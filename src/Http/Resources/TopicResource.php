<?php

namespace Uneca\DisseminationToolkit\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class TopicResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'type' => $this->type,
            'code' => $this->code,
            'rank' => $this->rank,
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => url('/api/topics', $this->resource->getRouteKey()),
        ];
    }
}
