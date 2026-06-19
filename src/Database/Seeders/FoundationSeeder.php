<?php

namespace Uneca\DisseminationToolkit\Database\Seeders;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Uneca\DisseminationToolkit\Models\Area;
use Uneca\DisseminationToolkit\Models\AreaHierarchy;
use Uneca\DisseminationToolkit\Services\AreaTree;
use Uneca\DisseminationToolkit\Services\ShapefileImporter;
use Uneca\DisseminationToolkit\Traits\Geospatial;

class FoundationSeeder
{
    use Geospatial;

    private const SHAPEFILES_DIR = __DIR__.'/../../../sample-data/shapefiles';

    private const HIERARCHIES = [
        ['index' => 0, 'name' => 'Burundi', 'zero_pad_length' => 0],
        ['index' => 1, 'name' => 'Province', 'zero_pad_length' => 0],
        ['index' => 2, 'name' => 'Commune', 'zero_pad_length' => 0],
    ];

    private const SHAPEFILES = [
        ['file' => 'Burundi', 'level' => 0],
        ['file' => 'Provinces', 'level' => 1],
        ['file' => 'Communes', 'level' => 2],
    ];

    public function __construct(private ?Command $command = null) {}

    public function run(): void
    {
        $this->info('Seeding area hierarchies');
        $this->createAreaHierarchies();

        $this->info('Seeding areas from shapefiles');
        foreach (self::SHAPEFILES as $shapefile) {
            $this->importShapefile($shapefile['file'], $shapefile['level']);
        }
    }

    public function createAreaHierarchies(): void
    {
        foreach (self::HIERARCHIES as $hierarchy) {
            AreaHierarchy::firstOrCreate(
                ['index' => $hierarchy['index']],
                [
                    'name' => ['en' => $hierarchy['name']],
                    'zero_pad_length' => $hierarchy['zero_pad_length'],
                ]
            );
        }
    }

    public function importShapefile(string $filename, int $level): int
    {
        $filePath = self::SHAPEFILES_DIR.'/'.$filename.'.shp';

        if (! file_exists($filePath)) {
            $this->error("Shapefile not found: {$filePath}");

            return 0;
        }

        $hierarchies = (new AreaTree)->hierarchies;
        $locale = app()->getLocale();
        $areaHierarchy = AreaHierarchy::whereRaw("name->>'{$locale}' = '{$hierarchies[$level]}'")->first();

        $importer = new ShapefileImporter;
        $features = $importer->import($filePath);

        $count = 0;
        $skipped = 0;
        foreach ($features as $feature) {
            $code = $feature['attribs']['code'];
            $name = Str::of($feature['attribs']['name'])->trim()->lower()->limit(80)->title()->toString();
            $geom = $feature['geom'];
            $zeroPaddedCode = Str::padLeft($code, $areaHierarchy->zero_pad_length, '0');

            $areaPath = $level > 0
                ? $this->buildPath($level, $geom, $code)
                : $code;

            if ($areaPath === null) {
                $skipped++;

                continue;
            }

            Area::updateOrCreate(
                ['code' => $zeroPaddedCode, 'level' => $level, 'path' => $areaPath],
                ['name' => $name, 'geom' => $geom]
            );
            $count++;
        }

        $this->info("  {$filename}: imported {$count} area(s)".($skipped > 0 ? ", skipped {$skipped} orphan(s)" : ''));

        return $count;
    }

    private function buildPath(int $level, mixed $geom, string $code): ?string
    {
        $ancestor = self::findContainingGeometry($level - 1, $geom);

        if (empty($ancestor)) {
            return null;
        }

        return $ancestor->path.'.'.$code;
    }

    private function info(string $message): void
    {
        $this->command?->info($message);
    }

    private function error(string $message): void
    {
        $this->command?->error($message);
    }
}
