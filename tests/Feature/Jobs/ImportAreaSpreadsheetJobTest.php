<?php

use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Uneca\DisseminationToolkit\Jobs\ImportAreaSpreadsheetJob;
use Uneca\DisseminationToolkit\Models\Area;

function areaSpreadsheetPath(array $rows): string
{
    $path = Storage::disk('local')->path('test/areas.xlsx');
    $writer = SimpleExcelWriter::create($path)
        ->addHeader(['country_code', 'country_name']);

    foreach ($rows as $row) {
        $writer->addRow($row);
    }

    $writer->close();

    return $path;
}

it('imports areas from a spreadsheet', function () {
    $path = areaSpreadsheetPath([
        ['country_code' => '1', 'country_name' => 'Ethiopia'],
        ['country_code' => '2', 'country_name' => 'Kenya'],
    ]);

    ImportAreaSpreadsheetJob::dispatch(
        filePath: $path,
        start: 0,
        chunkSize: 10,
        areaLevels: ['Country'],
        columnMapping: [
            'Country' => ['name' => 'country_name', 'code' => 'country_code', 'zeroPadding' => 2],
        ],
        user: adminUser(),
        locale: 'en'
    );

    $areas = Area::all();

    expect($areas)->toHaveCount(2)
        ->and($areas->pluck('code')->all())->toContain('01', '02')
        ->and($areas->first()->name)->toBe('Ethiopia');
});

it('applies zero padding based on the hierarchy config', function () {
    $path = areaSpreadsheetPath([
        ['country_code' => '42', 'country_name' => 'Testland'],
    ]);

    ImportAreaSpreadsheetJob::dispatch(
        filePath: $path,
        start: 0,
        chunkSize: 10,
        areaLevels: ['Country'],
        columnMapping: [
            'Country' => ['name' => 'country_name', 'code' => 'country_code', 'zeroPadding' => 5],
        ],
        user: adminUser(),
        locale: 'en'
    );

    expect(Area::first()->code)->toBe('00042');
});
