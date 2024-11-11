<?php

namespace Uneca\DisseminationToolkit\Commands;

use App\Models\Dataset;
use App\Models\Dimension;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportDataset extends Command
{
    protected $signature = 'dissemination:import-dataset {--truncate : Truncate tables before importing data}';

    protected $description = 'Import dataset';

    private string $schema = 'public';
    private const CHUNK_SIZE = 10000;

    public function handle()
    {
        $this->schema = config('dissemination.schema');
        DB::statement("CREATE SCHEMA IF NOT EXISTS {$this->schema}");

        $dataInfo = [
            'name' => 'Population by area of residence, sex and age',
            'filepath' => './sample-data/Pop by area of residence, sex and age.csv',
            'fact_table' => 'population_facts',
        ];
        $dataset = Dataset::create(['name' => $dataInfo['name']]);
        $dataInfo['dataset_id'] = $dataset->id;

        $dataFile = SimpleExcelReader::create($dataInfo['filepath']);
        $rows = $dataFile->getRows();
        $headers = $dataFile->getHeaders();

        $locale = app()->getLocale();
        $dimensionsInCsv = collect($headers)->mapWithKeys(function ($header) use ($locale) {
            return [$header => Dimension::where("name->{$locale}", 'ilike', $header)->first()];
        })->filter();
        $dataset->dimensions()->attach($dimensionsInCsv->pluck('id')->all());

        $lookups = $dimensionsInCsv->map(function ($model, $key) {
            return [
                'table' => $model->table_name,
                'fk' => str($key)->lower()->snake()->append('_id')->toString(),
                'lookup' => DB::table($model->table_name),
            ];
        });

        $rows->chunk(self::CHUNK_SIZE)->each(function ($chunk) use ($dataInfo, $lookups) {
            $entries = [];
            $common = [
                'indicator_id' => 3,
                'area_id' => 1,
                'year_id' => 1,
                'dataset_id' => $dataInfo['dataset_id'],
            ];
            $chunk->each(function(array $row) use (&$entries, $dataInfo, $lookups, $common) {
                // Invert the loop so that we iterate on the $lookup->keys()
                $entry = [...$common];
                /*foreach ($row as $col => $value) {
                    if (in_array($col, $lookup->keys()->all())) {
                        $query = $lookup[$col]['lookup']->clone();
                        $dimension = $query->where('code', $value)->first();
                        $entry[$lookup[$col]['fk']] = $dimension->id ?? null;
                    }
                }*/
                foreach ($lookups as $col => $lookup) {
                    $query = $lookup['lookup']->clone();
                    $dimension = $query->where('code', $row[$col])->first();
                    $entry[$lookup['fk']] = $dimension->id ?? null;
                }
                $entry['value'] = $row['Value'];
                //dump($row, $entry);
                array_push($entries, $entry);
            });
            $this->info("Data for table: {$dataInfo['fact_table']}");
            $result = DB::table($dataInfo['fact_table'])->insertOrIgnore($entries);
            //dump($result);
            //dump($entries);
        });
    }
}
