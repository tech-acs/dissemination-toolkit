<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

it('divides two numbers safely', function () {
    expect(safeDivide(10, 2))->toBe(5)
        ->and(safeDivide(10, 3))->toBe(10 / 3)
        ->and(safeDivide(10, 0))->toBe(0)
        ->and(safeDivide(10, -2))->toBe(0)
        ->and(safeDivide(10, 3, true))->toBe(3);
});

it('converts a collection of rows into a data frame', function () {
    $data = collect([
        ['a' => 1, 'b' => 2],
        ['a' => 3, 'b' => 4],
    ]);

    $df = toDataFrame($data);

    expect($df)->toBeInstanceOf(Collection::class)
        ->and($df->keys()->all())->toBe(['a', 'b'])
        ->and($df['a'])->toBe([1, 3]);
});

it('returns an empty data frame for empty data', function () {
    expect(toDataFrame(collect()))->toBeInstanceOf(Collection::class)->toBeEmpty();
});

it('converts a data frame back into a result set', function () {
    $df = collect([
        'a' => [1, 3],
        'b' => [2, 4],
    ]);

    $resultSet = toResultSet($df);

    expect($resultSet)->toBeInstanceOf(Collection::class)
        ->and($resultSet->all())->toBe([
            ['a' => 1, 'b' => 2],
            ['a' => 3, 'b' => 4],
        ]);
});

it('returns an empty result set for empty data frame', function () {
    expect(toResultSet(collect()))->toBeInstanceOf(Collection::class)->toBeEmpty();
});

it('handles model collections when converting to data frame', function () {
    $model = new class extends Model
    {
        protected $fillable = ['name', 'value'];
    };

    $data = collect([
        new $model(['name' => 'x', 'value' => 1]),
        new $model(['name' => 'y', 'value' => 2]),
    ]);

    $df = toDataFrame($data);

    expect($df['name'])->toBe(['x', 'y']);
});
