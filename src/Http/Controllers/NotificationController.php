<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __invoke()
    {
        return view('dissemination::notification.index');
    }
}
