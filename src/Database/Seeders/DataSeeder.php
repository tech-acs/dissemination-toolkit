<?php

namespace Uneca\DisseminationToolkit\Database\Seeders;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;
use Uneca\DisseminationToolkit\Actions\CreateDimensionAction;
use Uneca\DisseminationToolkit\Database\Factories\DatasetFactory;
use Uneca\DisseminationToolkit\Database\Factories\DimensionFactory;
use Uneca\DisseminationToolkit\Database\Factories\IndicatorFactory;
use Uneca\DisseminationToolkit\Database\Factories\TopicFactory;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Dimension;
use Uneca\DisseminationToolkit\Models\Indicator;

class DataSeeder
{
    private const CSV_DIR = __DIR__.'/../../../sample-data/census';

    private const TOPICS = [
        ['name' => 'Demography', 'description' => 'The study of the size, structure, and distribution of the population, including key metrics on births, deaths, and migration patterns.'],
        ['name' => 'Health', 'description' => 'Statistics on health status, healthcare access, and key health indicators across different population segments.'],
        ['name' => 'Education', 'description' => 'Data on educational attainment, school enrollment, literacy rates, and other education-related indicators.'],
    ];

    private const INDICATORS = [
        ['name' => 'Population count', 'topic' => 'Demography', 'description' => 'The total number of people enumerated in a given area, disaggregated by sex, age, and other demographic characteristics.'],
    ];

    private const DIMENSIONS = [
        [
            'name' => 'Sex',
            'table_name' => 'sex',
            'description' => 'The biological and physiological characteristics that distinguish males and females.',
            'values' => [
                ['code' => 'M', 'name' => 'Masculin', 'rank' => 1],
                ['code' => 'F', 'name' => 'Féminin', 'rank' => 2],
                ['code' => '_T', 'name' => 'Total', 'rank' => 3],
            ],
        ],
        [
            'name' => 'Year',
            'table_name' => 'year',
            'description' => 'The calendar year to which the observation refers.',
            'values' => [
                ['code' => '2024', 'name' => '2024', 'rank' => 1],
            ],
        ],
        [
            'name' => 'Area of residence',
            'table_name' => 'area_of_residence',
            'description' => 'The classification of the population by type of locality, distinguishing urban from rural areas.',
            'values' => [
                ['code' => 'U', 'name' => 'Urbain', 'rank' => 1],
                ['code' => 'R', 'name' => 'Rural', 'rank' => 2],
                ['code' => '_T', 'name' => 'Total', 'rank' => 3],
            ],
        ],
        [
            'name' => 'Five year age group',
            'table_name' => 'five_year_age_group',
            'description' => 'Age classification in five-year intervals, from 0–4 years to 80 years and over, used for standard demographic analysis.',
            'values' => [
                ['code' => '0-4', 'name' => '0-4 ans', 'rank' => 1],
                ['code' => '5-9', 'name' => '5-9 ans', 'rank' => 2],
                ['code' => '10-14', 'name' => '10-14 ans', 'rank' => 3],
                ['code' => '15-19', 'name' => '15-19 ans', 'rank' => 4],
                ['code' => '20-24', 'name' => '20-24 ans', 'rank' => 5],
                ['code' => '25-29', 'name' => '25-29 ans', 'rank' => 6],
                ['code' => '30-34', 'name' => '30-34 ans', 'rank' => 7],
                ['code' => '35-39', 'name' => '35-39 ans', 'rank' => 8],
                ['code' => '40-44', 'name' => '40-44 ans', 'rank' => 9],
                ['code' => '45-49', 'name' => '45-49 ans', 'rank' => 10],
                ['code' => '50-54', 'name' => '50-54 ans', 'rank' => 11],
                ['code' => '55-59', 'name' => '55-59 ans', 'rank' => 12],
                ['code' => '60-64', 'name' => '60-64 ans', 'rank' => 13],
                ['code' => '65-69', 'name' => '65-69 ans', 'rank' => 14],
                ['code' => '70-74', 'name' => '70-74 ans', 'rank' => 15],
                ['code' => '75-79', 'name' => '75-79 ans', 'rank' => 16],
                ['code' => '80+', 'name' => '80 ans ou plus', 'rank' => 17],
                ['code' => '_T', 'name' => 'Total', 'rank' => 18],
            ],
        ],
        [
            'name' => 'Broad age group',
            'table_name' => 'broad_age_group',
            'description' => 'Aggregated age categories that group the population into youth (0–14), working-age adults (15–59), and older adults (60+).',
            'values' => [
                ['code' => '0-14', 'name' => '0-14 ans', 'rank' => 1],
                ['code' => '15-59', 'name' => '15-59 ans', 'rank' => 2],
                ['code' => '60+', 'name' => '60 ans ou plus', 'rank' => 3],
                ['code' => '_T', 'name' => 'Total', 'rank' => 4],
            ],
        ],
    ];

    private const DATASET = [
        'name' => 'Population by sex (up to commune)',
        'description' => 'Population counts by sex for the entire country, disaggregated down to the commune level.',
        'fact_table' => 'census_facts',
        'max_area_level' => 2,
        'indicator' => 'Population count',
        'dimensions' => ['Sex', 'Year'],
    ];

    private const CSV_FILES = [
        'country-population-by-sex.csv',
        'province-population-by-sex.csv',
        'commune-population-by-sex.csv',
    ];

    private const INSERT_CHUNK_SIZE = 100;

    public function __construct(private ?Command $command = null) {}

    public function run(): void
    {
        $this->info('Seeding topics');
        $topics = $this->createTopics();

        $this->info('Seeding indicators');
        $indicators = $this->createIndicators($topics);

        $this->info('Seeding dimensions and their values');
        $dimensions = $this->createDimensions();

        $this->info('Seeding dataset');
        $dataset = $this->createDataset($indicators, $dimensions);

        $this->info('Importing observations from CSV');
        $this->importObservations($dataset, $indicators, $dimensions);
    }

    private function createTopics(): array
    {
        $topics = [];
        foreach (self::TOPICS as $topic) {
            $topics[$topic['name']] = TopicFactory::new()->create([
                'name' => ['en' => $topic['name']],
                'description' => ['en' => $topic['description']],
                'code' => null,
            ]);
        }

        $this->info('  '.count($topics).' topic(s) created');

        return $topics;
    }

    private function createIndicators(array $topics): array
    {
        $indicators = [];
        foreach (self::INDICATORS as $config) {
            $indicator = IndicatorFactory::new()->create([
                'name' => ['en' => $config['name']],
                'description' => ['en' => $config['description']],
                'code' => null,
            ]);
            $indicator->topics()->sync([$topics[$config['topic']]->id]);
            $indicators[$config['name']] = $indicator;
        }

        $this->info('  '.count($indicators).' indicator(s) created');

        return $indicators;
    }

    private function createDimensions(): array
    {
        $dimensions = [];
        foreach (self::DIMENSIONS as $config) {
            $dimension = DimensionFactory::new()->create([
                'name' => ['en' => $config['name']],
                'description' => ['en' => $config['description']],
                'table_name' => $config['table_name'],
                'for' => ['census_facts'],
                'code' => null,
                'table_created_at' => null,
            ]);

            (new CreateDimensionAction)->handle($dimension);

            DB::table($config['table_name'])->insert($config['values']);

            $dimensions[$config['name']] = $dimension;

            $this->info("  {$config['name']}: {$config['table_name']} table created, ".count($config['values']).' value(s) inserted');
        }

        return $dimensions;
    }

    private function createDataset(array $indicators, array $dimensions): Dataset
    {
        $dataset = DatasetFactory::new()->create([
            'name' => ['en' => self::DATASET['name']],
            'description' => ['en' => self::DATASET['description']],
            'fact_table' => self::DATASET['fact_table'],
            'max_area_level' => self::DATASET['max_area_level'],
            'published' => true,
            'code' => null,
        ]);

        $dataset->indicators()->sync([$indicators[self::DATASET['indicator']]->id]);

        $dimensionIds = collect(self::DATASET['dimensions'])
            ->map(fn ($name) => $dimensions[$name]->id)
            ->all();
        $dataset->dimensions()->sync($dimensionIds);

        $inheritedTopics = $dataset->indicators->pluck('topics')->flatten()->pluck('id')->unique();
        $dataset->topics()->sync($inheritedTopics);

        $this->info('  '.self::DATASET['name'].' (1 indicator, '.count($dimensionIds).' dimension(s))');

        return $dataset;
    }

    private function importObservations(Dataset $dataset, array $indicators, array $dimensions): void
    {
        $indicator = $indicators[self::DATASET['indicator']];

        $attachedDimensions = collect(self::DATASET['dimensions'])
            ->map(fn ($name) => $dimensions[$name])
            ->keyBy(fn (Dimension $d) => strtolower($d->name));

        $areaLookup = Area::pluck('id', 'code')->all();

        $dimensionLookups = $attachedDimensions->mapWithKeys(function (Dimension $dimension) {
            return [$dimension->table_name => DB::table($dimension->table_name)->pluck('id', 'code')->all()];
        });

        $totalInserted = 0;
        $totalSkipped = 0;

        foreach (self::CSV_FILES as $csvFile) {
            $filePath = self::CSV_DIR.'/'.$csvFile;

            if (! file_exists($filePath)) {
                $this->error("  CSV not found: {$filePath}");

                continue;
            }

            [$inserted, $skipped] = $this->importCsvFile($filePath, $dataset, $indicator, $attachedDimensions, $areaLookup, $dimensionLookups);
            $totalInserted += $inserted;
            $totalSkipped += $skipped;

            $this->info("  {$csvFile}: {$inserted} row(s) inserted".($skipped > 0 ? ", {$skipped} skipped" : ''));
        }

        $this->info("  Total: {$totalInserted} observation(s) inserted".($totalSkipped > 0 ? ", {$totalSkipped} skipped" : ''));
    }

    private function importCsvFile(
        string $filePath,
        Dataset $dataset,
        Indicator $indicator,
        Collection $attachedDimensions,
        array $areaLookup,
        Collection $dimensionLookups
    ): array {
        $reader = SimpleExcelReader::create($filePath);
        $headers = $reader->getHeaders();
        $rows = $reader->getRows();

        $headerMap = collect($headers)->mapWithKeys(fn ($h) => [strtolower($h) => $h])->all();

        $areaCodeColumn = $this->findAreaCodeColumn($headerMap, $attachedDimensions);
        $indicatorColumn = $headerMap[strtolower($indicator->name)] ?? null;

        $dimensionColumns = $attachedDimensions->mapWithKeys(function (Dimension $dimension) use ($headerMap) {
            $key = strtolower($dimension->name.' code');
            $column = $headerMap[$key] ?? null;

            return [$dimension->table_name => $column];
        });

        $inserted = 0;
        $skipped = 0;
        $batch = [];

        $rows->each(function (array $row) use (
            &$batch, &$inserted, &$skipped,
            $dataset, $indicator, $areaLookup, $dimensionLookups,
            $areaCodeColumn, $indicatorColumn, $dimensionColumns
        ) {
            $areaId = $areaLookup[$row[$areaCodeColumn]] ?? null;
            if ($areaId === null) {
                $skipped++;

                return;
            }

            $entry = [
                'indicator_id' => $indicator->id,
                'area_id' => $areaId,
                'dataset_id' => $dataset->id,
                'value' => (float) $row[$indicatorColumn],
            ];

            foreach ($dimensionColumns as $tableName => $column) {
                if ($column === null) {
                    continue;
                }
                $fkColumn = $tableName.'_id';
                $code = $row[$column];
                $entry[$fkColumn] = $dimensionLookups[$tableName][$code] ?? null;
                if ($entry[$fkColumn] === null) {
                    $skipped++;

                    return;
                }
            }

            $batch[] = $entry;

            if (count($batch) >= self::INSERT_CHUNK_SIZE) {
                DB::table($dataset->fact_table)->insert($batch);
                $inserted += count($batch);
                $batch = [];
            }
        });

        if (! empty($batch)) {
            DB::table($dataset->fact_table)->insert($batch);
            $inserted += count($batch);
        }

        return [$inserted, $skipped];
    }

    private function findAreaCodeColumn(array $headerMap, Collection $attachedDimensions): ?string
    {
        $dimensionCodeKeys = $attachedDimensions
            ->map(fn (Dimension $d) => strtolower($d->name.' code'))
            ->all();

        foreach ($headerMap as $lowerKey => $originalHeader) {
            if (str_ends_with($lowerKey, ' code') && ! in_array($lowerKey, $dimensionCodeKeys)) {
                return $originalHeader;
            }
        }

        return null;
    }

    private function info(string $message): void
    {
        $this->command?->info($message);
    }

    private function error(string $message): void
    {
        $this->command?->error($message);
    }
}
