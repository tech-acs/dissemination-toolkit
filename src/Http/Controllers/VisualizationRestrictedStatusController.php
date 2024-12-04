<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Models\Visualization;

class VisualizationRestrictedStatusController extends Controller
{
    public function __invoke(Request $request, Visualization $visualization)
    {
        $restrictedStatus = $request->boolean('restricted');
        $visualization->update(['restricted' => $restrictedStatus]);
        return redirect()->route('manage.visualization.index')->withMessage('Visualization ' . ($restrictedStatus ? 'restricted' : 'shared'));
    }
}
