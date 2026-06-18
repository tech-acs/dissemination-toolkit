<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\User;
use Uneca\DisseminationToolkit\Models\Visualization;

/**
 * @extends Factory<Visualization>
 */
class VisualizationFactory extends Factory
{
    protected $model = Visualization::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->slug(3),
            'slug' => fake()->unique()->slug(3),
            'title' => ['en' => fake()->sentence(4)],
            'description' => ['en' => fake()->paragraph()],
            'published' => fake()->boolean(),
            'user_id' => User::factory(),
            'is_filterable' => fake()->boolean(),
            'is_reviewable' => fake()->boolean(),
            'restricted' => true,
            'livewire_component' => 'Uneca\\DisseminationToolkit\\Livewire\\Visualizations\\Chart',
            'data_params' => [],
            'data' => [],
            'layout' => [],
            'thumbnail' => null,
            'options' => [],
        ];
    }
}
