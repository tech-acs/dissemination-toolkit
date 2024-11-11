<?php

namespace Uneca\DisseminationToolkit\Commands;

use App\Models\Dimension;
use App\Models\Indicator;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportData extends Command
{
    protected $signature = 'dissemination:import-data {--drop : Drop and re-create tables if they exist} {--truncate : Truncate tables before importing data}';

    protected $description = 'Create schema and import data';

    private string $schema = 'public';
    private const CHUNK_SIZE = 10000;

    private function createTable(array $tableInfo)
    {
        $fullTableName = "{$this->schema}.{$tableInfo['table']}";
        if (Schema::hasTable($fullTableName)) {
            if ($this->option('drop')) {
                $this->warn("Table $fullTableName already exists. Dropping...");
                Schema::drop($fullTableName);
            }
        } else {
            $this->newLine()->info("Creating $fullTableName ...");
            Schema::create($fullTableName, function (Blueprint $table) use ($tableInfo) {
                $table->id();
                foreach ($tableInfo['columns'] as $column => $columnDetails) {
                    $table->addColumn($columnDetails['db']['type'] ?? 'string', $column, $columnDetails['db']['parameters'] ?? []);
                }
            });
        }
    }

    /*private function writeIndicators(array $tableInfo)
    {
        $this->newLine()->comment("Extracting indicators from {$tableInfo['label']} fact table...");
        foreach ($tableInfo['columns'] as $dbColumn => $columnDetails) {
            if ( ($columnDetails['meta']['nature'] ?? null) === 'measure' ) {
                try {
                    $created = Indicator::create([
                        'name' => $columnDetails['meta']['label'],
                        'table' => "{$this->schema}.{$tableInfo['table']}",
                        'column' => $dbColumn
                    ]);
                    if ($created) {
                        $this->info($columnDetails['meta']['label'] . " ✔");
                    }
                } catch (\Exception $exception) {
                    $this->error("There was a problem creating the indicator: " . $columnDetails['meta']['label']);
                }
            }
        }
    }*/

    private function writeIndicators(array $tableInfo)
    {
        $this->newLine()->comment("Extracting indicators and their dimensions from {$tableInfo['label']} fact table...");
        $columns = collect($tableInfo['columns']);
        $dimensions = $columns
            ->filter(function ($columnDetails) {
                return ($columnDetails['meta']['nature'] ?? null) === 'dimension';
            })
            ->map(fn ($dimension) => $dimension['meta'])
            ->all();
        $columns
            ->filter(function ($columnDetails) {
                return ($columnDetails['meta']['nature'] ?? null) === 'measure';
            })
            ->each(function ($columnDetails, $columnName) use ($tableInfo, $dimensions) {
                try {
                    $created = Indicator::create([
                        'name' => $columnDetails['meta']['label'],
                        'table' => "{$this->schema}.{$tableInfo['table']}",
                        'column' => $columnName,
                        'dimensions' => $dimensions
                    ]);
                    if ($created) {
                        $this->info($columnDetails['meta']['label'] . " ✔");
                    }
                } catch (\Exception $exception) {
                    $this->error("There was a problem creating the indicator: " . $columnDetails['meta']['label']);
                }
            });
        /*foreach ($tableInfo['columns'] as $dbColumn => $columnDetails) {
            if ( ($columnDetails['meta']['nature'] ?? null) === 'measure' ) {
                try {
                    $created = Indicator::create([
                        'name' => $columnDetails['meta']['label'],
                        'table' => "{$this->schema}.{$tableInfo['table']}",
                        'column' => $dbColumn
                    ]);
                    if ($created) {
                        $this->info($columnDetails['meta']['label'] . " ✔");
                    }
                } catch (\Exception $exception) {
                    $this->error("There was a problem creating the indicator: " . $columnDetails['meta']['label']);
                }
            }
        }*/
    }

    private function writeDimensions(string $dimension, array $tableInfo)
    {
        $this->newLine()->comment("Extracting dimensions from {$tableInfo['label']} dimension table...");
        try {
            $created = Dimension::create([
                'name' => $dimension,
                'table' => $dimension,
                'label' => $tableInfo['label'],
            ]);
            if ($created) {
                $this->info($tableInfo['label'] . " ✔");
            }
        } catch (\Exception $exception) {
            $this->error("There was a problem creating the dimension: " . $tableInfo['label']);
        }
    }

    private function importDimensionData(array $tableInfo, string $distinctColumn = 'code')
    {
        $fullTableName = "{$this->schema}.{$tableInfo['table']}";
        if (Schema::hasTable($fullTableName)) {
            if ($this->option('truncate')) {
                DB::table($fullTableName)->truncate();
            }
            $tableIsEmpty = DB::table($fullTableName)->count();
            if (! $tableIsEmpty) {
                $rows = SimpleExcelReader::create($tableInfo['filepath'])->getRows();
                /*$entries = [];
                $rows->each(function(array $row) use (&$entries, $tableInfo) {
                    $entry = [];
                    foreach ($tableInfo['columns'] as $dbColumn => $columnDetails) {
                        $entry[$dbColumn] = $row[$columnDetails['import']['csv_header']];
                    }
                    array_push($entries, $entry);
                });
                $this->info("Data for table: $fullTableName:");
                $data = is_null($distinctColumn) ? $entries : collect($entries)->unique($distinctColumn)->all();
                DB::table($fullTableName)->insertOrIgnore($data);*/

                $rows->chunk(self::CHUNK_SIZE)->each(function ($chunk) use ($tableInfo, $distinctColumn, $fullTableName) {
                    $entries = [];
                    $chunk->each(function(array $row) use (&$entries, $tableInfo) {
                        $entry = [];
                        foreach ($tableInfo['columns'] as $dbColumn => $columnDetails) {
                            $entry[$dbColumn] = $row[$columnDetails['import']['csv_header']];
                        }
                        array_push($entries, $entry);
                    });
                    $this->info("Data for table: $fullTableName");
                    $data = is_null($distinctColumn) ? $entries : collect($entries)->unique($distinctColumn)->all();
                    DB::table($fullTableName)->insertOrIgnore($data);
                });
            }
        }
    }

    private function importFactData(array $tableInfo)
    {
        $fullTableName = "{$this->schema}.{$tableInfo['table']}";
        if (Schema::hasTable($fullTableName)) {
            if ($this->option('truncate')) {
                DB::table($fullTableName)->truncate();
            }
            $tableIsEmpty = DB::table($fullTableName)->count();
            if (! $tableIsEmpty) {
                $rows = SimpleExcelReader::create($tableInfo['filepath'])->getRows();
                $rows->chunk(self::CHUNK_SIZE)->each(function ($chunk) use ($tableInfo, $fullTableName) {
                    $entries = [];
                    $chunk->each(function(array $row) use (&$entries, $tableInfo) {
                        $entry = [];
                        foreach ($tableInfo['columns'] as $dbColumn => $columnDetails) {
                            if ( (($columnDetails['meta']['nature'] ?? null) === 'measure') && (! is_numeric($row[$columnDetails['import']['csv_header']])) ) {
                                $entry[$dbColumn] = null;
                            } else {
                                $entry[$dbColumn] = $row[$columnDetails['import']['csv_header']];
                            }
                        }
                        array_push($entries, $entry);
                    });
                    $this->info("Data for table: $fullTableName");
                    DB::table($fullTableName)->insertOrIgnore($entries);
                });
            }
        }
    }

    public function handle()
    {
        $this->schema = config('dissemination.schema');
        $starSchema = config('dissemination.data_mapping');

        DB::statement("CREATE SCHEMA IF NOT EXISTS {$this->schema}");

        foreach ($starSchema['Dimensions'] as $name => $dimension) {
            $this->createTable($dimension);
            $this->writeDimensions($name, $dimension);
            $this->importDimensionData($dimension);
        }
        foreach ($starSchema['Facts'] as $fact) {
            $this->createTable($fact);
            $this->writeIndicators($fact);
            $this->importFactData($fact);
        }

        /* $this->filePath = '/home/nahom/Desktop/Dissemination/ONS - Census/Sub_ICB_Locations_to_Integrated_Care_Boards_to_NHS_England_(Region)_(July_2022).csv';
         * $areas = [
            'Area' => [
                'table' => 'area',
                'columns' => [
                    'code' => ['type' => 'string', 'parameters' => ['length' => 25, 'unique' => 'subicbl_code_unique'], 'csv_header' => 'SICBL22CD'],
                    'name' => ['type' => 'string', 'csv_header' => 'SICBL22NM'],
                    'icb_code' => ['type' => 'string', 'parameters' => ['length' => 25], 'csv_header' => 'ICB22CD'],
                    'icb_name' => ['type' => 'string', 'csv_header' => 'ICB22NM'],
                    'nhser_code' => ['type' => 'string', 'parameters' => ['length' => 25], 'csv_header' => 'NHSER22CD'],
                    'nhser_name' => ['type' => 'string', 'csv_header' => 'NHSER22NM'],
                ],
            ]
        ];
        foreach ($areas as $x => $a) {
            $this->createTable($a);
        }
        $this->importData($areas);*/
    }
}
