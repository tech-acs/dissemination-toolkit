<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\User;

/**
 * @extends Factory<Story>
 */
class StoryFactory extends Factory
{
    protected $model = Story::class;

    public function definition(): array
    {
        return [
            'title' => ['en' => fake()->unique()->sentence(4)],
            'description' => ['en' => fake()->paragraph()],
            'html' => fake()->randomHtml(),
            'published' => fake()->boolean(),
            'featured' => fake()->boolean(),
            'featured_image' => null,
            'user_id' => User::factory(),
            'is_filterable' => fake()->boolean(),
            'is_reviewable' => fake()->boolean(),
            'restricted' => true,
        ];
    }
}
