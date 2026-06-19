<?php

namespace Uneca\DisseminationToolkit\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\SimpleExcel\SimpleExcelReader;
use Uneca\DisseminationToolkit\Jobs\ImportDatasetJob;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Dimension;

class DatasetImporter extends Component
{
    use WithFileUploads;

    public $spreadsheet;

    public bool $fileAccepted = false;

    public Dataset $dataset;

    public Collection $indicators;

    public Collection $dimensions;

    public array $columnHeaders = [];

    public array $columnMapping = [];

    public string $filePath = '';

    public string $message = '';

    // const CHUNK_SIZE = 500;
    public string $importError = '';

    private function mappings(): array
    {
        return [
            'indicators' => collect($this->indicators)->mapWithKeys(fn ($indicator) => [$indicator->id => ''])->all(),
            'dimensions' => collect($this->dimensions)->mapWithKeys(fn ($dimension) => [$dimension->id => ''])->all(),
            'others' => collect(['geography'])->mapWithKeys(fn ($other) => [$other => ''])->all(),
        ];
    }

    protected function rules()
    {
        return array_merge(['spreadsheet' => 'required|file|mimes:csv,xlsx'], $this->messages());
    }

    protected function messages()
    {
        return Arr::dot(collect($this->mappings())->mapWithKeys(fn ($group, $groupName) => ["columnMapping.$groupName" => collect($group)->map(fn ($item) => 'required')->all()]));
    }

    public function mount()
    {
        $this->indicators = $this->dataset->indicators;
        $this->dimensions = $this->dataset->dimensions;
        $this->columnMapping = $this->mappings();
    }

    public function updatedSpreadsheet()
    {
        $this->validateOnly('spreadsheet');
        $filename = collect([Str::random(40), $this->spreadsheet->getClientOriginalExtension()])->join('.');
        $this->spreadsheet->storeAs('/spreadsheets', $filename, 'imports');
        $this->filePath = Storage::disk('imports')->path('spreadsheets/'.$filename);
        $this->columnHeaders = SimpleExcelReader::create($this->filePath)->getHeaders();
        $this->fileAccepted = true;
    }

    private function makeLookupTables(): array
    {
        $lookups = [];
        foreach ($this->columnMapping['dimensions'] as $dimensionId => $columnName) {
            $dimension = Dimension::find($dimensionId);
            $lookups[$dimensionId] = [
                'lookup' => array_change_key_case(DB::table($dimension->table_name)->pluck('id', 'code')->all(), CASE_LOWER),
                'fk' => $dimension->foreign_key,
            ];
        }
        $lookups['geography'] = [
            'lookup' => array_change_key_case(Area::pluck('id', 'code')->all(), CASE_LOWER),
            'fk' => 'area_id',
        ];

        return $lookups;
    }

    public function import()
    {
        $this->validate();
        $lookups = $this->makeLookupTables();

        ImportDatasetJob::dispatch($this->dataset, $this->filePath, $lookups, $this->columnMapping, auth()->user(), app()->getLocale());

        $this->message = 'The file is being imported. You will receive a notification when the process is complete.';

        $this->reset('spreadsheet', 'fileAccepted', 'columnHeaders', 'columnMapping', 'filePath');
    }

    public function render()
    {
        $this->dataset->loadCount(['dimensions', 'indicators']);

        return view('dissemination::livewire.dataset-importer');
    }
}
