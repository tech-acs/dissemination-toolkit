<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;
use Spatie\SimpleExcel\SimpleExcelWriter;

class DatasetTemplateController extends Controller
{
    public function __invoke(Dataset $dataset)
    {
        $filename = "{$dataset->name}.xlsx";

        $stream = SimpleExcelWriter::streamDownload($filename);

        $writer = $stream->getWriter();

        $datasetSheet = $writer->getCurrentSheet();
        $datasetSheet->setName('Datasets');

        $stream->addHeader($dataset->templateFileColumnHeaders());

        foreach ($dataset->dimensions as $dimension) {
            $dimensionSheet = $writer->addNewSheetAndMakeItCurrent();
            $dimensionSheet->setName($this->sanitizeSheetName($dimension['name']));
            $values = $dimension->values()->pluck('name', 'code');

            $stream->addHeader(['code', 'name'])->addRows(
                $values->map(function ($name, $code) {
                    return [$code, $name];
                })->toArray()
            );

        }
        return $stream->toBrowser();
    }
    private function sanitizeSheetName($name)
    {
        $invalidCharacters = ['\\', '/', '?', '*', '[', ']', ':', '<', '>', '&'];
        $name = str_replace($invalidCharacters, '', $name);
        return mb_substr($name, 0, 31); // Limit to 31 characters
    }
}
