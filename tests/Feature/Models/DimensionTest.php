<?php

use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Models\Dimension;

it('can create a dimension using the factory', function () {
    $dimension = Dimension::factory()->create();

    expect($dimension->refresh())->toBeInstanceOf(Dimension::class)
        ->and($dimension->name)->toBeString();
});

it('generates a foreign key from the dimension name', function () {
    $dimension = Dimension::factory()->create(['name' => ['en' => 'Residence Type']]);

    expect($dimension->foreign_key)->toBe('residence_type_id');
});

it('can be attached to datasets', function () {
    $dimension = Dimension::factory()->create();
    $dataset = Dataset::factory()->create();

    $dimension->datasets()->attach($dataset);

    expect($dimension->datasets)->toHaveCount(1);
});

it('detects that its value table does not exist', function () {
    $dimension = Dimension::factory()->create(['table_name' => 'non_existent_table']);

    expect($dimension->table_exists)->toBeFalse()
        ->and($dimension->values_count)->toBe(0)
        ->and($dimension->is_complete)->toBeFalse();
});
