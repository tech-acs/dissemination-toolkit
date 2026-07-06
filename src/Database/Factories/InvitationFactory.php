<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Invitation;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'link' => fake()->unique()->uuid(),
            'status' => fake()->randomElement(['Unused', 'Used', 'Expired']),
            'role' => fake()->optional()->word(),
            'generated_at' => now(),
            'expires_at' => now()->addDays(7),
        ];
    }
}
