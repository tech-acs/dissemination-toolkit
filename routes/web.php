<?php

use Illuminate\Support\Facades\Route;
use Uneca\DisseminationToolkit\Http\Controllers\AnnouncementController;
use Uneca\DisseminationToolkit\Http\Controllers\AreaController;
use Uneca\DisseminationToolkit\Http\Controllers\AreaHierarchyController;
use Uneca\DisseminationToolkit\Http\Controllers\AuthHomeController;
use Uneca\DisseminationToolkit\Http\Controllers\DimensionTableCreationController;
use Uneca\DisseminationToolkit\Http\Controllers\DocumentManagementController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\DocumentController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\DataExplorerController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\DatasetController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\DatasetDownloadController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\LandingController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\MapVisualizationController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\RendererController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\StoryController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\VisualizationController;
use Uneca\DisseminationToolkit\Http\Controllers\Guest\VizAjaxController;
use Uneca\DisseminationToolkit\Http\Controllers\IndicatorController;
use Uneca\DisseminationToolkit\Http\Controllers\NotificationController;
use Uneca\DisseminationToolkit\Http\Controllers\RoleController;
use Uneca\DisseminationToolkit\Http\Controllers\TopicController;
use Uneca\DisseminationToolkit\Http\Controllers\UserController;
use Uneca\DisseminationToolkit\Http\Controllers\UserSuspensionController;

Route::middleware(['web'])->group(function () {
    Route::get('landing', [LandingController::class, 'index'])->name('landing');
    Route::get('data-explorer', [DataExplorerController::class, 'index'])->name('data-explorer');
    Route::get('visualization', [VisualizationController::class, 'index'])->name('visualization.index');
    Route::get('map-visualization', [MapVisualizationController::class, 'index'])->name('map-visualization.index');
    Route::get('visualization/{visualization}', [VisualizationController::class, 'show'])->name('visualization.show');
    Route::get('story', [StoryController::class, 'index'])->name('story.index');
    Route::get('story/{story}', [StoryController::class, 'show'])->name('story.show');
    Route::get('census-table', [DocumentController::class, 'index'])->name('census-table.index');
    Route::get('census-table/{id}', [DocumentController::class, 'show'])->name('census-table.show');
    Route::get('census-table/download/{Document}', [DocumentController::class, 'download'])->name('census-table.download');
    Route::get('dataset', DatasetController::class)->name('dataset.index');
    Route::get('dataset/{dataset}/download', DatasetDownloadController::class)->name('dataset.download');

    Route::view('about', 'dissemination::guest.about')->name('about');
    Route::view('contact', 'dissemination::guest.contact')->name('contact');
    Route::get('renderer/visualization/{visualization}', RendererController::class);
    Route::get('notification', NotificationController::class)->name('notification.index');
    Route::get('api/visualization/{visualization}', [VizAjaxController::class, 'show']);
    Route::get('api/visualization', [VizAjaxController::class, 'index']);

    Route::middleware(['auth:sanctum', 'verified', 'enforce_2fa'])->prefix('manage')->name('manage.')->group(function () {
        Route::get('/home', AuthHomeController::class)->name('home');
        Route::resource('topic', TopicController::class);
        Route::resource('indicator', IndicatorController::class);
        Route::get('dimension/create-table', DimensionTableCreationController::class)->name('dimension.create-table');
        //Route::delete('dimension/delete-table', \App\Http\Controllers\DimensionTableDeletionController::class)->name('dimension.delete-table');
        Route::resource('dimension', \Uneca\DisseminationToolkit\Http\Controllers\DimensionController::class);
        Route::resource('year', \Uneca\DisseminationToolkit\Http\Controllers\YearController::class);
        Route::resource('dimension.values', \Uneca\DisseminationToolkit\Http\Controllers\DimensionValueController::class);
        Route::resource('dimension.import-values', \Uneca\DisseminationToolkit\Http\Controllers\DimensionValueImportController::class)->only(['create', 'store']);
        Route::get('dataset/{dataset}/remove', \Uneca\DisseminationToolkit\Http\Controllers\DatasetRemovalController::class)->name('dataset.remove');
        Route::get('dataset/{dataset}/truncate', \Uneca\DisseminationToolkit\Http\Controllers\DatasetTruncationController::class)->name('dataset.truncate');
        Route::get('dataset/{dataset}/get-template', \Uneca\DisseminationToolkit\Http\Controllers\DatasetTemplateController::class)->name('dataset.get-template');
        Route::resource('dataset', \Uneca\DisseminationToolkit\Http\Controllers\DatasetController::class)->only(['index', 'create', 'edit', 'destroy']);
        Route::resource('dataset.import', \Uneca\DisseminationToolkit\Http\Controllers\DatasetImportController::class)->only(['create', 'store']);
        Route::resource('visualization', \Uneca\DisseminationToolkit\Http\Controllers\VisualizationController::class)->except(['create', 'show']);
        Route::post('upload-visualization/{visualization}', [\Uneca\DisseminationToolkit\Http\Controllers\VisualizationController::class, 'upload'])->name('visualization.upload');
        //Route::get('visualization-builder', \App\Http\Controllers\VisualizationBuilderController::class)->name('visualization-builder');
        //Route::get('visualization-deriver', \App\Http\Controllers\VisualizationDeriverController::class)->name('visualization-deriver');
        Route::get('story/{story}/duplicate', \Uneca\DisseminationToolkit\Http\Controllers\StoryDuplicationController::class)->name('story.duplicate');
        Route::resource('story', \Uneca\DisseminationToolkit\Http\Controllers\StoryController::class);

        Route::patch('visualization/{visualization}/change-publish-status', \Uneca\DisseminationToolkit\Http\Controllers\VisualizationPublishStatusController::class)->name('visualization.change-publish-status');

        Route::controller(\Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\ChartWizardController::class)->group(function () {
            Route::get('viz-builder/chart/step1', 'step1')->name('viz-builder.chart.step1');
            Route::get('viz-builder/chart/step2', 'step2')->name('viz-builder.chart.step2');
            Route::post('viz-builder/chart/step3', 'step3')->name('viz-builder.chart.step3');
            Route::get('viz-builder/chart/{viz}/edit', 'edit')->name('viz-builder.chart.edit');
            Route::post('viz-builder/chart', 'store')->name('viz-builder.chart.store');
        });
        Route::get('viz-builder/chart/api/get', [\Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\ChartWizardController::class, 'ajaxGetChart']);

        Route::controller(\Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\TableWizardController::class)->group(function () {
            Route::get('viz-builder/table/step1', 'step1')->name('viz-builder.table.step1');
            Route::get('viz-builder/table/step2', 'step2')->name('viz-builder.table.step2');
            Route::get('viz-builder/table/step3', 'step3')->name('viz-builder.table.step3');
            Route::get('viz-builder/table/{viz}/edit', 'edit')->name('viz-builder.table.edit');
            Route::post('viz-builder/table', 'store')->name('viz-builder.table.store');
        });

        Route::controller(\Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\MapWizardController::class)->group(function () {
            Route::get('viz-builder/map/step1', 'step1')->name('viz-builder.map.step1');
            Route::get('viz-builder/map/step2', 'step2')->name('viz-builder.map.step2');
            Route::get('viz-builder/map/step3', 'step3')->name('viz-builder.map.step3');
            Route::get('viz-builder/map/{viz}/edit', 'edit')->name('viz-builder.map.edit');
            Route::post('viz-builder/map', 'store')->name('viz-builder.map.store');
        });

        Route::controller(\Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\ScorecardWizardController::class)->group(function () {
            Route::get('viz-builder/scorecard/step1', 'step1')->name('viz-builder.scorecard.step1');
            Route::get('viz-builder/scorecard/step2', 'step2')->name('viz-builder.scorecard.step2');
            Route::get('viz-builder/scorecard/step3', 'step3')->name('viz-builder.scorecard.step3');
            Route::get('viz-builder/scorecard/{viz}/edit', 'edit')->name('viz-builder.scorecard.edit');
            Route::post('viz-builder/scorecard', 'store')->name('viz-builder.scorecard.store');
        });

        Route::resource('story-builder', \Uneca\DisseminationToolkit\Http\Controllers\StoryBuilderController::class)->parameters(['story-builder' => 'story'])->only(['edit', 'update']);

        Route::resource('announcement', AnnouncementController::class)->only(['index', 'create', 'store']);
        //Route::get('usage_stats', UsageStatsController::class)->name('usage_stats');

        Route::middleware(['can:Super Admin'])->group(function () {
            Route::resource('role', RoleController::class)->only(['index', 'store', 'edit', 'destroy']);
            Route::resource('user', UserController::class)->only(['index', 'edit', 'update', 'destroy'])->middleware('password.confirm');
            Route::get('user/{user}/suspension', UserSuspensionController::class)->name('user.suspension')->middleware('password.confirm');

            Route::resource('area-hierarchy', AreaHierarchyController::class);
            Route::resource('area', AreaController::class)->except(['destroy']);
            Route::delete('area/truncate', [AreaController::class, 'destroy'])->name('area.destroy');

            Route::get('organization', [\Uneca\DisseminationToolkit\Http\Controllers\OrganizationController::class, 'edit'])->name('organization.edit');
            Route::patch('organization/{organization}', [\Uneca\DisseminationToolkit\Http\Controllers\OrganizationController::class, 'update'])->name('organization.update');
            Route::resource('tag', \Uneca\DisseminationToolkit\Http\Controllers\TagController::class)->only(['index', 'edit', 'update']);
            /*Route::name('templates.')->group(function () {
                //Route::resource('templates/visualization', \App\Http\Controllers\VisualizationTemplateController::class)->only(['index', 'destroy']);
                Route::resource('templates/story', \App\Http\Controllers\StoryTemplateController::class)->only(['index', 'destroy']);
            });*/
        });

        Route::resource('census-table', DocumentManagementController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    });

    Route::get('/', function () {
        return redirect()->route('landing');
    });

    Route::fallback(function () {
        return redirect()->route('landing');
    });
});
