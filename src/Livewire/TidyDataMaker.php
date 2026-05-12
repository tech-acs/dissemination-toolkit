<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Livewire\Component;

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
        if (empty(trim($value))) {
            $this->resetData();
            return;
        }

        $lines = explode("\n", trim($value));
        if (count($lines) > 0) {
            // Detect if the user pasted tab-separated or comma-separated data
            $firstLine = $lines[0];
            $delimiter = strpos($firstLine, "\t") !== false ? "\t" : ",";

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

    public function render()
    {
        return view('livewire.tidy-data-maker');
    }
}
