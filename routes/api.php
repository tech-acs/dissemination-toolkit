<?php

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Uneca\DisseminationToolkit\Http\Controllers\Api\DatasetController;
use Uneca\DisseminationToolkit\Http\Controllers\Api\DimensionController;
use Uneca\DisseminationToolkit\Http\Controllers\Api\IndicatorController;
use Uneca\DisseminationToolkit\Http\Controllers\Api\TopicController;

Route::prefix('api')
    ->middleware(['auth:sanctum', SubstituteBindings::class])
    ->name('api.')
    ->group(function () {
    Route::get('datasets', [DatasetController::class, 'index'])->name('datasets.index');
    Route::get('datasets/{dataset}', [DatasetController::class, 'show'])->name('datasets.show');
    Route::get('datasets/{dataset}/observations', [DatasetController::class, 'observations'])->name('datasets.observations');
    Route::get('datasets/{dataset}/metadata', [DatasetController::class, 'metadata'])->name('datasets.metadata');
    Route::get('datasets/{dataset}/download', [DatasetController::class, 'download'])->name('datasets.download');

    Route::get('indicators', [IndicatorController::class, 'index'])->name('indicators.index');
    Route::get('indicators/{indicator}', [IndicatorController::class, 'show'])->name('indicators.show');

    Route::get('topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('topics/{topic}', [TopicController::class, 'show'])->name('topics.show');

    Route::get('dimensions', [DimensionController::class, 'index'])->name('dimensions.index');
    Route::get('dimensions/{dimension}', [DimensionController::class, 'show'])->name('dimensions.show');
    Route::get('dimensions/{dimension}/values', [DimensionController::class, 'values'])->name('dimensions.values');
});
