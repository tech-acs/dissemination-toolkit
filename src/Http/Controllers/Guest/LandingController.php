<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Visualization;

class LandingController extends Controller
{
    public function index()
    {
        $datasetSummary = [
            'datasets' => Dataset::count(),
            'indicators' => Indicator::count(),
            'visualizations' => Visualization::published()->count(),
            'data_stories' => Story::published()->count(),
        ];
        $featuredStories = Story::published()
            ->featured()
            ->orderBy('updated_at')
            ->take(config('dissemination.featured_stories'))
            ->get();
        return view('dissemination::guest.landing', compact('datasetSummary', 'featuredStories'));
    }
}
