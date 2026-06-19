<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Dimension;

/**
 * @extends Factory<Dimension>
 */
class DimensionFactory extends Factory
{
    protected $model = Dimension::class;

    public function definition(): array
    {
        return [
            'name' => ['en' => fake()->unique()->words(2, true)],
            'description' => ['en' => fake()->sentence()],
            'code' => fake()->unique()->lexify('dim_???'),
            'table_name' => fake()->unique()->lexify('dim_??????'),
            'table_created_at' => null,
            'for' => [],
            'sorting_type' => fake()->numberBetween(0, 3),
        ];
    }
}
