<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Routing\Controller;

class AuthHomeController extends Controller
{
    public function __invoke()
    {
        return view('dissemination::manage.home');
    }
}
