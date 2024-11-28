<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Models\Visualization;

class VisualizationPublishStatusController extends Controller
{
    public function __invoke(Request $request, Visualization $visualization)
    {
        $publishStatus = $request->boolean('published');
        $visualization->update(['published' => $publishStatus]);
        return redirect()->route('manage.visualization.index')->withMessage('Visualization ' . ($publishStatus ? 'published' : 'unpublished'));
    }
}
