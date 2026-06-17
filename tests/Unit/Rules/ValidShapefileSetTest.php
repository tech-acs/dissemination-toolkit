<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Uneca\DisseminationToolkit\Rules\ValidShapefileSet;

function shapefiles(array $names): array
{
    return array_map(
        fn (string $name) => UploadedFile::fake()->createWithContent($name, 'content'),
        $names
    );
}

it('passes for a valid shapefile set', function () {
    $files = shapefiles(['regions.shp', 'regions.shx', 'regions.dbf']);

    $validator = Validator::make(['files' => $files], [
        'files' => [new ValidShapefileSet],
    ]);

    expect($validator->passes())->toBeTrue();
});

it('fails when less than three files are provided', function () {
    $validator = Validator::make(['files' => shapefiles(['regions.shp', 'regions.shx'])], [
        'files' => [new ValidShapefileSet],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('files'))->toContain('three shapefile component files are required');
});

it('fails when more than three files are provided', function () {
    $validator = Validator::make(['files' => shapefiles(['regions.shp', 'regions.shx', 'regions.dbf', 'regions.prj'])], [
        'files' => [new ValidShapefileSet],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('files'))->toContain('Only the three shapefile component files are required');
});

it('fails when filenames do not match', function () {
    $validator = Validator::make(['files' => shapefiles(['regions.shp', 'districts.shx', 'regions.dbf'])], [
        'files' => [new ValidShapefileSet],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('files'))->toContain('same filename');
});

it('fails when a required component is missing', function () {
    $validator = Validator::make(['files' => shapefiles(['regions.shp', 'regions.shx', 'regions.txt'])], [
        'files' => [new ValidShapefileSet],
    ]);

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->first('files'))->toContain('shp, shx & dbf');
});
