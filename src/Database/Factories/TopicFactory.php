<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Topic;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        return [
            'name' => ['en' => fake()->unique()->words(2, true)],
            'description' => ['en' => fake()->sentence()],
            'type' => fake()->optional()->word(),
            'code' => fake()->unique()->lexify('topic_???'),
            'rank' => fake()->numberBetween(1, 100),
        ];
    }
}
