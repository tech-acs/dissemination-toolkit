<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Dataset;

/**
 * @extends Factory<Dataset>
 */
class DatasetFactory extends Factory
{
    protected $model = Dataset::class;

    public function definition(): array
    {
        return [
            'name' => ['en' => fake()->unique()->words(3, true)],
            'description' => ['en' => fake()->paragraph()],
            'max_area_level' => fake()->numberBetween(0, 3),
            'fact_table' => 'census_facts',
            'data_source' => fake()->company(),
            'contributor' => fake()->name(),
            'data_date' => fake()->year(),
            'format' => fake()->fileExtension(),
            'code' => fake()->unique()->lexify('ds_???'),
            'language' => fake()->languageCode(),
            'published' => fake()->boolean(),
        ];
    }
}
