<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class DataExplorerController extends Controller
{
    public function index()
    {
        return view('dissemination::guest.data-explorer');
    }
}
