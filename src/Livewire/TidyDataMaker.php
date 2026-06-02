<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Models\Indicator;

class TidyDataMaker extends Component
{
    public $rawData = '';
    public $columns = [];
    public $parsedData = [];
    public $checkedColumns = [];

    // Names for the newly pivoted columns
    public $nameColumn = 'variable';
    public $valueColumn = 'value';

    public $tidiedData = [];
    public $csvOutput = '';

    // Reactively parse data when the user pastes into the textarea
    public function updatedRawData($value)
    {
        $value = preg_replace('/^\xEF\xBB\xBF/', '', $value);

        if (empty(trim($value))) {
            $this->resetData();
            return;
        }

        $lines = explode("\n", trim($value));
        if (count($lines) > 0) {
            // Detect delimiter: tab, semicolon, or comma (by frequency in first line)
            $firstLine = $lines[0];
            $tabCount = substr_count($firstLine, "\t");
            $semiCount = substr_count($firstLine, ";");
            $commaCount = substr_count($firstLine, ",");
            $delimiter = $tabCount ? "\t" : ($semiCount > $commaCount ? ";" : ",");

            $this->columns = str_getcsv($firstLine, $delimiter);

            $this->parsedData = [];
            for ($i = 1; $i < count($lines); $i++) {
                if (empty(trim($lines[$i]))) continue;

                $row = str_getcsv($lines[$i], $delimiter);
                // Ensure row length matches header length to avoid offsets
                if(count($row) === count($this->columns)) {
                    $this->parsedData[] = array_combine($this->columns, $row);
                }
            }
        }
        $this->tidyData();
    }

    // Reactively re-pivot the data if any inputs change
    public function updatedCheckedColumns() { $this->tidyData(); }
    public function updatedNameColumn() { $this->tidyData(); }
    public function updatedValueColumn() { $this->tidyData(); }

    public function tidyData()
    {
        if (empty($this->parsedData) || empty($this->checkedColumns)) {
            $this->tidiedData = [];
            $this->csvOutput = '';
            return;
        }

        // Columns that are NOT checked become the "identifier" variables
        $notChecked = array_diff($this->columns, $this->checkedColumns);
        $tidied = [];

        foreach ($this->parsedData as $row) {
            // For every column the user checks to melt
            foreach ($this->checkedColumns as $checkedCol) {
                $obj = [];

                // 1. Keep identifier columns unchanged
                foreach ($notChecked as $nc) {
                    $obj[$nc] = $row[$nc] ?? null;
                }

                // 2. Add the pivoted Name and Value
                $obj[$this->nameColumn] = $checkedCol;
                $obj[$this->valueColumn] = $row[$checkedCol] ?? null;

                $tidied[] = $obj;
            }
        }

        $this->tidiedData = $tidied;
        $this->generateCsvOutput();
    }

    public function generateCsvOutput()
    {
        if (empty($this->tidiedData)) {
            $this->csvOutput = '';
            return;
        }

        // Write to memory to generate a formatted TSV/CSV string
        $output = fopen('php://temp', 'r+');
        $headers = array_keys($this->tidiedData[0]);
        fputcsv($output, $headers, "\t");

        foreach ($this->tidiedData as $row) {
            fputcsv($output, $row, "\t");
        }

        rewind($output);
        $this->csvOutput = stream_get_contents($output);
        fclose($output);
    }

    private function resetData()
    {
        $this->parsedData = [];
        $this->columns = [];
        $this->checkedColumns = [];
        $this->tidiedData = [];
        $this->csvOutput = '';
    }

    public function downloadCsv(): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo str_replace("\t", ",", $this->csvOutput);
        }, 'tidy-data.csv');
    }

    public function downloadCodifiedCsv(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $columnLookups = [];
            $identifierColumns = array_diff($this->columns, $this->checkedColumns);

            foreach ([...$identifierColumns, $this->nameColumn] as $colName) {
                $lookup = $this->buildLookup($colName);
                if ($lookup !== null) {
                    $columnLookups[$colName] = $lookup;
                }
            }

            $codified = array_map(function ($row) use ($columnLookups) {
                foreach ($columnLookups as $col => $lookup) {
                    $label = $row[$col] ?? null;
                    $row[$col] = $lookup[mb_strtoupper($label)] ?? $label;
                }
                return $row;
            }, $this->tidiedData);

            $output = fopen('php://temp', 'r+');
            $headers = array_keys($codified[0] ?? []);
            $headers = array_map(fn ($h) => isset($columnLookups[$h]) ? $h . ' code' : $h, $headers);
            fputcsv($output, $headers, ',');

            foreach ($codified as $row) {
                fputcsv($output, $row, ',');
            }

            rewind($output);
            echo stream_get_contents($output);
            fclose($output);
        }, 'tidy-data-codified.csv');
    }

    private function buildLookup(string $nameColumn): ?array
    {
        $geographyKeywords = ['Area', 'Geography'];

        if (in_array(mb_strtolower($nameColumn), array_map('mb_strtolower', $geographyKeywords))) {
            $areaLookup = Area::get()->pluck('code', 'name')
                ->mapWithKeys(fn ($code, $name) => [mb_strtoupper($name) => $code])
                ->toArray();
            return ! empty($areaLookup) ? $areaLookup : null;
        }

        $dimension = Dimension::where('name->' . app()->getLocale(), $nameColumn)->first();
        if (! $dimension) {
            return null;
        }

        $values = $dimension->values();
        if ($values === false) {
            return null;
        }

        return collect($values)->pluck('code', 'name')
            ->mapWithKeys(fn ($code, $name) => [mb_strtoupper($name) => $code])
            ->toArray();
    }

    #[Computed]
    public function dimensions()
    {
        return Dimension::orderBy('name')->get()->pluck('name');
    }

    #[Computed]
    public function indicators()
    {
        return Indicator::orderBy('name')->get()->pluck('name');
    }

    public function render()
    {
        return view('dissemination::livewire.tidy-data-maker');
    }
}
