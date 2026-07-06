<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    public function __invoke()
    {
        return view('dissemination::notification.index');
    }
}
