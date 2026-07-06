<?php

namespace Uneca\DisseminationToolkit\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class IndicatorResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'code' => $this->code,
            'data' => $this->data,
            'layout' => $this->layout,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'topics' => TopicResource::class,
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => url('/api/indicators', $this->resource->getRouteKey()),
        ];
    }
}
