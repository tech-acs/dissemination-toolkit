<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Area;

/**
 * @extends Factory<Area>
 */
class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition(): array
    {
        return [
            'code' => fake()->unique()->lexify('area_???'),
            'name' => ['en' => fake()->unique()->city()],
            'level' => fake()->numberBetween(0, 3),
            'geom' => null,
            'path' => fake()->unique()->regexify('[a-z0-9]{4,10}'),
        ];
    }
}
