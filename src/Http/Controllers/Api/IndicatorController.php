<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Api;

use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Http\Resources\IndicatorResource;
use Uneca\DisseminationToolkit\Models\Indicator;

class IndicatorController
{
    public function index(Request $request)
    {
        $perPage = (int) ($request->input('page.size', config('dissemination.api.per_page', 20)));

        $indicators = Indicator::with('topics')
            ->paginate($perPage);

        return IndicatorResource::collection($indicators);
    }

    public function show(Indicator $indicator)
    {
        $indicator->load('topics');

        return IndicatorResource::make($indicator);
    }
}
