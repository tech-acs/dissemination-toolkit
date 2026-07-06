<?php

namespace Uneca\DisseminationToolkit\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class DimensionResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'code' => $this->code,
            'table_name' => $this->table_name,
            'for' => $this->for,
            'sorting_type' => $this->sorting_type,
            'values_count' => $this->when($this->values_count !== null, $this->values_count),
            'is_complete' => $this->when($this->is_complete !== null, $this->is_complete),
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'datasets' => DatasetResource::class,
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => url('/api/dimensions', $this->resource->getRouteKey()),
            'values' => url('/api/dimensions', $this->resource->getRouteKey()) . '/values',
        ];
    }
}
