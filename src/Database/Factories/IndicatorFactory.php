<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Indicator;

/**
 * @extends Factory<Indicator>
 */
class IndicatorFactory extends Factory
{
    protected $model = Indicator::class;

    public function definition(): array
    {
        return [
            'name' => ['en' => fake()->unique()->words(3, true)],
            'description' => ['en' => fake()->sentence()],
            'code' => fake()->unique()->lexify('ind_???'),
        ];
    }
}
