<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\AreaHierarchy;

/**
 * @extends Factory<AreaHierarchy>
 */
class AreaHierarchyFactory extends Factory
{
    protected $model = AreaHierarchy::class;

    public function definition(): array
    {
        return [
            'index' => fake()->unique()->numberBetween(0, 10),
            'name' => ['en' => fake()->unique()->word()],
            'zero_pad_length' => fake()->numberBetween(0, 5),
            'simplification_tolerance' => fake()->randomFloat(4, 0, 1),
            'map_zoom_levels' => [fake()->numberBetween(1, 20), fake()->numberBetween(1, 20)],
        ];
    }
}
