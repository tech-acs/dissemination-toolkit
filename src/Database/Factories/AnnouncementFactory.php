<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Announcement;
use Uneca\DisseminationToolkit\Models\User;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'recipients' => fake()->randomElement(['all', 'admins', 'editors']),
            'body' => fake()->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}
