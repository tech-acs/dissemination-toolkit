<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Services\DynamicDimensionModel;

class DimensionTableTruncationController extends Controller
{
    public function __invoke(Dimension $dimension, Request $request)
    {
        // dd($dimension->table_name, new DynamicDimensionModel($dimension->table_name));
        (new DynamicDimensionModel($dimension->table_name))->truncate();

        return redirect()->route('manage.dimension.index')->withMessage('Dimension values deleted');
    }
}
