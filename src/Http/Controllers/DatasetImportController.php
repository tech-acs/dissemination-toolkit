<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Routing\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;

class DatasetImportController extends Controller
{
    public function create(Dataset $dataset)
    {
        return view('dissemination::manage.dataset.import.create', compact('dataset'));
    }
}
