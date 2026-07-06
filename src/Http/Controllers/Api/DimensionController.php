<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Api;

use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Http\Resources\DimensionResource;
use Uneca\DisseminationToolkit\Models\Dimension;

class DimensionController
{
    public function index(Request $request)
    {
        $perPage = (int) ($request->input('page.size', config('dissemination.api.per_page', 20)));

        $dimensions = Dimension::paginate($perPage);

        return DimensionResource::collection($dimensions);
    }

    public function show(Dimension $dimension)
    {
        return DimensionResource::make($dimension);
    }

    public function values(Request $request, Dimension $dimension)
    {
        $values = $dimension->values();

        return response()->json([
            'meta' => [
                'values' => $values ?: [],
            ],
            'jsonapi' => ['version' => '1.1'],
        ]);
    }
}
