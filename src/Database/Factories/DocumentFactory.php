<?php

namespace Uneca\DisseminationToolkit\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum;
use Uneca\DisseminationToolkit\Models\Document;
use Uneca\DisseminationToolkit\Models\User;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'title' => ['en' => fake()->unique()->sentence(4)],
            'description' => ['en' => fake()->paragraph()],
            'dataset_type' => CensusTableTypeEnum::cases()[array_rand(CensusTableTypeEnum::cases())]->value,
            'producer' => fake()->company(),
            'publisher' => fake()->company(),
            'published_date' => fake()->date(),
            'data_source' => fake()->url(),
            'file_name' => fake()->word().'.pdf',
            'file_size' => fake()->numberBetween(1000, 1000000),
            'file_path' => 'documents/'.fake()->uuid().'.pdf',
            'file_type' => 'application/pdf',
            'comment' => fake()->optional()->sentence(),
            'published' => fake()->boolean(),
            'user_id' => User::factory(),
            'view_count' => fake()->numberBetween(0, 1000),
            'download_count' => fake()->numberBetween(0, 1000),
        ];
    }
}
