<?php

use Uneca\DisseminationToolkit\Traits\PlotlyDefaults;

it('exposes default plotly config and layout constants', function () {
    $subject = new class
    {
        use PlotlyDefaults;
    };

    expect($subject::DEFAULT_CONFIG)->toBeArray()
        ->toHaveKey('responsive')
        ->toHaveKey('displaylogo')
        ->toHaveKey('modeBarButtonsToRemove');

    expect($subject::DEFAULT_LAYOUT)->toBeArray()
        ->toHaveKey('showlegend')
        ->toHaveKey('legend')
        ->toHaveKey('xaxis')
        ->toHaveKey('height')
        ->toHaveKey('margin')
        ->toHaveKey('modebar')
        ->toHaveKey('dragmode');
});
