<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;
use Spatie\SimpleExcel\SimpleExcelWriter;

class DatasetTemplateController extends Controller
{
    public function __invoke(Dataset $dataset)
    {
        SimpleExcelWriter::streamDownload("{$dataset->name}.xlsx")
            ->addHeader($dataset->templateFileColumnHeaders())
            ->toBrowser();
    }
}
