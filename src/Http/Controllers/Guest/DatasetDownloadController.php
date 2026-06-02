<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Uneca\DisseminationToolkit\Actions\BuildDatasetAction;
use Uneca\DisseminationToolkit\Models\Dataset;

class DatasetDownloadController extends Controller
{
    public function __invoke(Dataset $dataset)
    {
        $datasetRows = (new BuildDatasetAction($dataset))->handle();
        $filename = "{$dataset->name}.xlsx";
        SimpleExcelWriter::streamDownload($filename)
            ->addRows($datasetRows)
            ->toBrowser();
    }
}
