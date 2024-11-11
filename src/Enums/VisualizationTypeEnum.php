<?php

namespace Uneca\DisseminationToolkit\Enums;

use Illuminate\Support\Collection;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Chart;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Map;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Table;

enum VisualizationTypeEnum
{
    case TABLE;
    case CHART;
    case MAP;

    public static function all(?string $type = null): Collection
    {
        return collect(VisualizationTypeEnum::cases())
            ->when(isset($type), function (Collection $collection) use ($type) {
                return $collection->filter(fn ($vizTypeDetail) =>
                    strtolower($vizTypeDetail->details()['type']) === strtolower($type));
            })
            ->map(fn (VisualizationTypeEnum $vizType) => $vizType->details());
    }

    public static function componentFromName(string $name)
    {
        return self::all()
            ->first(function ($vizType) use ($name) {
                return $vizType['name'] == $name;
            });
    }

    public function details(): array
    {
        return match ($this) {
            self::TABLE => [
                'type' => 'Table',
                'name' => 'Table',
                'rank' => 1,
                'component' => Table::class,
                'icon' => '<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs> </defs> <g id="General" stroke-width="0.64" fill="none" fill-rule="evenodd"> <g id="SLICES-64px" transform="translate(-180.000000, -400.000000)"> </g> <g id="ICONS" transform="translate(-175.000000, -395.000000)"> <g id="db-table" transform="translate(182.000000, 404.000000)"> <path d="M0,45 C0,46.656 1.343,48 3,48 L12,48 L12,36 L0,36 L0,45 Z" id="Fill-581" fill="#FFFFFF"> </path> <polygon id="Fill-582" fill="#FFFFFF" points="0 36 12 36 12 24 0 24"> </polygon> <polygon id="Fill-583" fill="#FFFFFF" points="12 48 24 48 24 36 12 36"> </polygon> <polygon id="Fill-584" fill="#FFFFFF" points="24 48 36 48 36 36 24 36"> </polygon> <polygon id="Fill-585" fill="#FFFFFF" points="12 36 24 36 24 24 12 24"> </polygon> <polygon id="Fill-586" fill="#FFFFFF" points="24 36 36 36 36 24 24 24"> </polygon> <polygon id="Fill-587" fill="#FFFFFF" points="36 36 48 36 48 24 36 24"> </polygon> <polygon id="Fill-588" fill="#FFFFFF" points="0 24 12 24 12 12 0 12"> </polygon> <polygon id="Fill-589" fill="#FFFFFF" points="12 24 24 24 24 12 12 12"> </polygon> <polygon id="Fill-590" fill="#FFFFFF" points="24 24 36 24 36 12 24 12"> </polygon> <polygon id="Fill-591" fill="#FFFFFF" points="36 24 48 24 48 12 36 12"> </polygon> <path d="M45,0 L3,0 C1.343,0 0,1.344 0,3 L0,12 L48,12 L48,3 C48,1.344 46.657,0 45,0" id="Fill-592" fill="#25fdfc"> </path> <path d="M36,36 L36,48 L45,48 C46.657,48 48,46.656 48,45 L48,36 L36,36 Z" id="Fill-593" fill="#FFFFFF"> </path> <path d="M45,0 L3,0 C1.343,0 0,1.343 0,3 L0,45 C0,46.657 1.343,48 3,48 L45,48 C46.657,48 48,46.657 48,45 L48,3 C48,1.343 46.657,0 45,0 Z" id="Stroke-594" stroke="#1d9bfb" stroke-width="0.64" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M0,12 L48,12" id="Stroke-595" stroke="#1d9bfb" stroke-width="0.64" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M0,24 L48,24" id="Stroke-596" stroke="#1d9bfb" stroke-width="0.64" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M0,36 L48,36" id="Stroke-597" stroke="#1d9bfb" stroke-width="0.64" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M24,12 L24,48" id="Stroke-598" stroke="#1d9bfb" stroke-width="0.64" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M36,12 L36,48" id="Stroke-599" stroke="#1d9bfb" stroke-width="0.64" stroke-linecap="round" stroke-linejoin="round"> </path> <path d="M12,12 L12,48" id="Stroke-600" stroke="#1d9bfb" stroke-width="0.64" stroke-linecap="round" stroke-linejoin="round"> </path> </g> </g> </g> </g></svg>'
            ],

            self::CHART => [
                'type' => 'Chart',
                'name' => 'Chart',
                'rank' => 1,
                'component' => Chart::class,
                'icon' => '<svg fill="currentColor" preserveAspectRatio="xMidYMid meet" viewBox="0 0 46 46">
                    <path fill="none" d="M0 0h46v46H0z"/>
                    <path fill="#25fdfc" d="M7 28h6v12H7z"/>
                    <path fill="#1d9bfb" d="M32 28h6v12h-6zM15 10h6v30h-6z"/>
                    <path fill="#25fdfc" d="M24 20h6v20h-6z"/>
                </svg>',
            ],

            self::MAP => [
                'type' => 'Map',
                'name' => 'Map',
                'rank' => 1,
                'component' => Map::class,
                'icon' => '<svg fill="currentColor" preserveAspectRatio="xMidYMid meet" viewBox="0 0 46 46">
                    <path fill="none" d="M0 0h46v46H0z"/>
                    <path fill="#27d1f0" stroke="#fff" d="M32.05 26.375l-2.3 3.45-4.6 1.15-2.3-2.3H19.4l-6.15 1.15-3.45-2.3 3.85-4.6v-3.45h5.163l4.187 3 4.45-3 9.2 6.9h-4.6z" stroke-linecap="round" stroke-linejoin="round"/>
                    <path fill="#1d9bfb" stroke="#fff" d="M36.65 26.375l-9.2-6.9-4.45 3-4.187-3H13.65l-2.875-1.725v-2.3l-1.15-1.15-1.15 1.15-1.15-1.15V9.7h2.3l2.3-1.15h2.3l3.45 2.3h3.45l4.6-2.3 3.45 3.45-3.45 3.45h5.75v-2.3h3.45v1.15l1.15 1.15 1.15-1.15 3.45 3.45v3.45H36.65v5.175zm-9.775 7.475L25.725 35h-1.15l.575-4.025-2.3-2.3H19.4l-6.15 1.15 7.875 4.025v2.3l3.45 2.3h2.3l1.15-1.15V35l-1.15-1.15z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>',
            ],
        };
    }

    public static function getIcon($type)
    {
        $visualizationType = collect(VisualizationTypeEnum::all())
        ->first(fn ($vizType) => strtolower($vizType['type']) === strtolower($type));
        return $visualizationType ? $visualizationType['icon'] : null;
    }
}
