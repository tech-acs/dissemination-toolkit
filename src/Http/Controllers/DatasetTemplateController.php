<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Routing\Controller;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Uneca\DisseminationToolkit\Models\Dataset;

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
