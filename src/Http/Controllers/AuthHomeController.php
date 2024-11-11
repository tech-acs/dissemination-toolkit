<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;

class AuthHomeController extends Controller
{
    public function __invoke()
    {
        return view('dissemination::manage.home');
    }
}
