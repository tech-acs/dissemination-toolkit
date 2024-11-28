<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;
use Spatie\SimpleExcel\SimpleExcelWriter;

class DatasetTemplateController extends Controller
{
    public function __invoke(Dataset $dataset)
    {
        $columnHeaders = [
            'Area Code',
            ...$dataset->dimensions->pluck('name')->map(fn ($name) => "$name code")->toArray(),
            ...$dataset->indicators->pluck('name')->toArray()
        ];
        SimpleExcelWriter::streamDownload("{$dataset->name}.xlsx")
            ->addHeader($columnHeaders)
            ->toBrowser();
    }
}
