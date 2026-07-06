<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Models\Organization;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        return [
            'name' => ['en' => fake()->company()],
            'website' => fake()->url(),
            'email' => fake()->unique()->companyEmail(),
            'logo_path' => null,
            'slogan' => ['en' => fake()->catchPhrase()],
            'blurb' => ['en' => fake()->paragraph()],
            'hero_image_path' => null,
            'social_media' => [
                'twitter' => fake()->url(),
                'facebook' => fake()->url(),
                'instagram' => fake()->url(),
                'linkedin' => fake()->url(),
            ],
            'address' => fake()->address(),
        ];
    }
}
