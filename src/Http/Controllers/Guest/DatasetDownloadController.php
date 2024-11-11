<?php

namespace Uneca\DisseminationToolkit\Http\Controllers\Guest;

use Uneca\DisseminationToolkit\Actions\BuildDatasetAction;
use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;
use Spatie\SimpleExcel\SimpleExcelWriter;

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
