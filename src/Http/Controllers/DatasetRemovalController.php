<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Uneca\DisseminationToolkit\Models\Dataset;

class DatasetRemovalController extends Controller
{
    public function __invoke(Dataset $dataset)
    {
        // $dataset->years()->detach();
        // $dataset->dimensions()->detach();
        DB::table($dataset->fact_table)
            // ->where('indicator_id', $dataset->indicator_id)
            ->where('dataset_id', $dataset->id)
            ->delete();
        $dataset->delete();

        return redirect()->route('manage.dataset.index')->withMessage('Record deleted');
    }
}
