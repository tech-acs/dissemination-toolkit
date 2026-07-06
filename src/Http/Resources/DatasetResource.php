<?php

namespace Uneca\DisseminationToolkit\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\JsonApiResource;

class DatasetResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->getTranslations('name'),
            'description' => $this->getTranslations('description'),
            'code' => $this->code,
            'fact_table' => $this->fact_table,
            'data_source' => $this->data_source,
            'contributor' => $this->contributor,
            'data_date' => $this->data_date,
            'format' => $this->format,
            'language' => $this->language,
            'max_area_level' => $this->max_area_level,
            'published' => $this->published,
            'observations_count' => $this->when($this->observations_count !== null, $this->observations_count),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'topics' => TopicResource::class,
            'indicators' => IndicatorResource::class,
            'dimensions' => DimensionResource::class,
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => url('/api/datasets', $this->resource->getRouteKey()),
        ];
    }
}
