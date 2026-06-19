<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\AreaHierarchy;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Models\Indicator;

class TidyDataMaker extends Component
{
    public $rawData = '';

    public $columns = [];

    public $parsedData = [];

    public $checkedColumns = [];

    // Names for the newly pivoted columns
    public $nameColumn = '';

    public $valueColumn = '';

    public $tidiedData = [];

    public $csvOutput = '';

    public $codifiedCsvOutput = '';

    public $codificationWarnings = [];

    public $skipUnmatched = false;

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
            $semiCount = substr_count($firstLine, ';');
            $commaCount = substr_count($firstLine, ',');
            $delimiter = $tabCount ? "\t" : ($semiCount > $commaCount ? ';' : ',');

            $this->columns = str_getcsv($firstLine, $delimiter);

            $this->parsedData = [];
            for ($i = 1; $i < count($lines); $i++) {
                if (empty(trim($lines[$i]))) {
                    continue;
                }

                $row = str_getcsv($lines[$i], $delimiter);
                // Ensure row length matches header length to avoid offsets
                if (count($row) === count($this->columns)) {
                    $this->parsedData[] = array_combine($this->columns, $row);
                }
            }
        }
        $this->reset('checkedColumns', 'nameColumn', 'valueColumn');
        $this->tidyData();
    }

    // Reactively re-pivot the data if any inputs change
    public function updatedCheckedColumns() {}

    public function updatedNameColumn() {}

    public function updatedValueColumn() {}

    public function updatedSkipUnmatched()
    {
        $this->tidyData();
    }

    public function apply()
    {
        $this->validate([
            'checkedColumns' => 'required|array|min:2',
            'nameColumn' => 'required',
            'valueColumn' => 'required',
        ], [
            'checkedColumns.min' => 'Please select at least 2 columns to melt.',
            'nameColumn.required' => 'Please select a dimension for the new column.',
            'valueColumn.required' => 'Please select an indicator for the new column.',
        ]);

        $this->tidyData();
    }

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
                $obj[$this->valueColumn] = str($row[$checkedCol] ?? null)->squish()->replace(',', '')->toString();

                $tidied[] = $obj;
            }
        }

        $this->tidiedData = $tidied;
        $this->codificationWarnings = [];

        $columnLookups = $this->buildColumnLookups();
        $unmapped = [];
        $filtered = [];
        foreach ($this->tidiedData as $row) {
            $hasUnmapped = false;
            foreach ($columnLookups as $col => $lookup) {
                $label = $row[$col] ?? null;
                if ($label !== null && ! isset($lookup[mb_strtoupper($label)])) {
                    $unmapped[$col][$label] = true;
                    $hasUnmapped = true;
                }
            }
            if (! $this->skipUnmatched || ! $hasUnmapped) {
                $filtered[] = $row;
            }
        }
        $this->tidiedData = $filtered;

        foreach ($unmapped as $col => $labels) {
            $this->codificationWarnings[] = $col.': '.implode(', ', array_keys($labels)).' ('.count($labels).($this->skipUnmatched ? ' excluded' : ' unmapped').' value(s))';
        }

        $this->generateCsvOutput();
        $this->generateCodifiedCsvOutput($columnLookups);
    }

    public function generateCsvOutput()
    {
        if (empty($this->tidiedData)) {
            $this->csvOutput = '';

            return;
        }

        $output = fopen('php://temp', 'r+');
        $headers = array_keys($this->tidiedData[0]);
        fputcsv($output, $headers, ',');

        foreach ($this->tidiedData as $row) {
            fputcsv($output, $row, ',');
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
        $this->codifiedCsvOutput = '';
        $this->codificationWarnings = [];
        $this->skipUnmatched = false;
    }

    public function downloadCsv(): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo $this->csvOutput;
        }, 'tidy-data.csv');
    }

    public function downloadCodifiedCsv(): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo $this->codifiedCsvOutput;
        }, 'tidy-data-codified.csv');
    }

    private function buildColumnLookups(): array
    {
        $columnLookups = [];
        $identifierColumns = array_diff($this->columns, $this->checkedColumns);

        foreach ([...$identifierColumns, $this->nameColumn] as $colName) {
            $lookup = $this->buildLookup($colName);
            if ($lookup !== null) {
                $columnLookups[$colName] = $lookup;
            }
        }

        return $columnLookups;
    }

    public function generateCodifiedCsvOutput(array $columnLookups = [])
    {
        if (empty($this->tidiedData)) {
            $this->codifiedCsvOutput = '';
            $this->codificationWarnings = [];

            return;
        }

        if (empty($columnLookups)) {
            $columnLookups = $this->buildColumnLookups();
        }

        $codified = array_map(function ($row) use ($columnLookups) {
            foreach ($columnLookups as $col => $lookup) {
                $label = $row[$col] ?? null;
                $row[$col] = $lookup[mb_strtoupper($label)] ?? $label;
            }

            return $row;
        }, $this->tidiedData);

        foreach ($columnLookups as $colName => $lookup) {
            $hierarchy = AreaHierarchy::where('name->'.app()->getLocale(), $colName)->first();

            if (! $hierarchy) {
                continue;
            }

            $ambiguous = Area::select('name')
                ->ofLevel($hierarchy->index)
                ->groupBy('name')
                ->having(DB::raw('count(*)'), '>', 1)
                ->pluck('name')
                ->map(fn ($n) => mb_strtoupper($n));

            $valuesInData = array_unique(array_map(
                fn ($r) => mb_strtoupper($r[$colName] ?? ''),
                $this->tidiedData
            ));

            $hits = $ambiguous->intersect($valuesInData);

            foreach ($hits as $name) {
                $this->codificationWarnings[] = "$colName: '$name' is ambiguous (matches multiple codes)";
            }
        }

        $output = fopen('php://temp', 'r+');
        $headers = array_keys($codified[0] ?? []);
        $headers = array_map(fn ($h) => isset($columnLookups[$h]) ? $h.' code' : $h, $headers);
        fputcsv($output, $headers, ',');

        foreach ($codified as $row) {
            fputcsv($output, $row, ',');
        }

        rewind($output);
        $this->codifiedCsvOutput = stream_get_contents($output);
        fclose($output);
    }

    private function buildLookup(string $nameColumn): ?array
    {
        $hierarchy = AreaHierarchy::where('name->'.app()->getLocale(), 'ILIKE', $nameColumn)->first();

        if ($hierarchy) {
            $areaLookup = Area::ofLevel($hierarchy->index)->get()->pluck('code', 'name')
                ->mapWithKeys(fn ($code, $name) => [mb_strtoupper($name) => $code])
                ->toArray();

            return ! empty($areaLookup) ? $areaLookup : null;
        }

        $dimension = Dimension::where('name->'.app()->getLocale(), 'ILIKE', $nameColumn)->first();
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
