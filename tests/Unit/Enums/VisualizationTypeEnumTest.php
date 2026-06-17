<?php

use Uneca\DisseminationToolkit\Enums\VisualizationTypeEnum;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Chart;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Map;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Table;

it('returns details for every visualization type', function () {
    foreach (VisualizationTypeEnum::cases() as $type) {
        $details = $type->details();

        expect($details)->toHaveKeys(['type', 'name', 'rank', 'component', 'icon']);
    }
});

it('returns the chart component class for a chart name', function () {
    expect(VisualizationTypeEnum::componentFromName('Chart'))->toHaveKey('component', Chart::class);
});

it('returns null when component name is not found', function () {
    expect(VisualizationTypeEnum::componentFromName('Unknown'))->toBeNull();
});

it('filters all types by type name', function () {
    expect(VisualizationTypeEnum::all('chart'))->toHaveCount(1);
});

it('returns an icon for a known visualization type', function () {
    expect(VisualizationTypeEnum::getIcon('Map'))->toBeString();
});

it('returns null for an unknown visualization type icon', function () {
    expect(VisualizationTypeEnum::getIcon('Unknown'))->toBeNull();
});
