<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Visualization;

class RendererController extends Controller
{
    public function __invoke(Visualization $visualization)
    {
        return view('dissemination::guest.renderer', compact('visualization'));
    }
}
