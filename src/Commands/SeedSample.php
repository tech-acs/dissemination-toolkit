<?php

namespace Uneca\DisseminationToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Uneca\DisseminationToolkit\Database\Seeders\DataSeeder;
use Uneca\DisseminationToolkit\Database\Seeders\FoundationSeeder;
use Uneca\DisseminationToolkit\Models\AreaHierarchy;

class SeedSample extends Command
{
    public $signature = 'dissemination:seed-sample
        {--only= : Only run a specific seeder (foundational or data)}
        {--no-wipe : Do not wipe tables before seeding}';

    public $description = 'Seed sample data (area hierarchies, areas, topics, indicators, dimensions, datasets, observations)';

    private const FOUNDATIONAL_TABLES = ['areas', 'area_hierarchies'];

    private const DATA_TABLES = [
        'topicables',
        'dataset_indicator',
        'dataset_dimension',
        'census_facts',
        'sex',
        'year',
        'area_of_residence',
        'five_year_age_group',
        'broad_age_group',
        'dimensions',
        'datasets',
        'indicators',
        'topics',
    ];

    public function handle(): int
    {
        $only = $this->option('only');

        if ($only !== null && ! in_array($only, ['foundational', 'data'])) {
            $this->error("Invalid value for --only. Use 'foundational' or 'data'.");

            return self::FAILURE;
        }

        $wipe = ! $this->option('no-wipe');
        $runFoundational = $only === null || $only === 'foundational';
        $runData = $only === null || $only === 'data';

        if ($runFoundational) {
            if ($wipe) {
                $this->wipeTables(self::FOUNDATIONAL_TABLES, 'foundation');
            }
            (new FoundationSeeder($this))->run();
        }

        if ($runData) {
            if (! $runFoundational && ! AreaHierarchy::exists()) {
                $this->error('No area hierarchies found. The data seeder requires foundational data. Run without --only or run --only=foundational first.');

                return self::FAILURE;
            }

            if ($wipe) {
                $this->wipeTables(self::DATA_TABLES, 'data');
            }
            (new DataSeeder($this))->run();
        }

        $this->components->info('Sample data seeding complete.');

        return self::SUCCESS;
    }

    private function wipeTables(array $tables, string $label): void
    {
        $this->components->task("Wiping {$label} tables", function () use ($tables) {
            $existing = array_filter($tables, fn (string $table) => Schema::hasTable($table));
            if (! empty($existing)) {
                DB::statement('TRUNCATE '.implode(', ', $existing).' RESTART IDENTITY CASCADE');
            }
        });
    }
}
