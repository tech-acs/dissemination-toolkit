<?php

use Illuminate\Support\Facades\Route;
use Uneca\DisseminationToolkit\Enums\PermissionsEnum;
use Uneca\DisseminationToolkit\Http\Controllers\AnnouncementController;
use Uneca\DisseminationToolkit\Http\Controllers\AreaController;
use Uneca\DisseminationToolkit\Http\Controllers\AreaHierarchyController;
use Uneca\DisseminationToolkit\Http\Controllers\AuthHomeController;
use Uneca\DisseminationToolkit\Http\Controllers\DatasetController as DatasetManagementController;
use Uneca\DisseminationToolkit\Http\Controllers\DatasetImportController;
use Uneca\DisseminationToolkit\Http\Controllers\DatasetPublishStatusController;
use Uneca\DisseminationToolkit\Http\Controllers\DatasetRemovalController;
use Uneca\DisseminationToolkit\Http\Controllers\DatasetTemplateController;
use Uneca\DisseminationToolkit\Http\Controllers\DatasetTruncationController;
use Uneca\DisseminationToolkit\Http\Controllers\DimensionController;
use Uneca\DisseminationToolkit\Http\Controllers\DimensionTableCreationController;
use Uneca\DisseminationToolkit\Http\Controllers\DimensionValueController;
use Uneca\DisseminationToolkit\Http\Controllers\DimensionValueImportController;
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
use Uneca\DisseminationToolkit\Http\Controllers\OrganizationController;
use Uneca\DisseminationToolkit\Http\Controllers\RoleController;
use Uneca\DisseminationToolkit\Http\Controllers\StoryBuilderController;
use Uneca\DisseminationToolkit\Http\Controllers\StoryController as StoryManagementController;
use Uneca\DisseminationToolkit\Http\Controllers\StoryDuplicationController;
use Uneca\DisseminationToolkit\Http\Controllers\StoryPublishStatusController;
use Uneca\DisseminationToolkit\Http\Controllers\TagController;
use Uneca\DisseminationToolkit\Http\Controllers\TopicController;
use Uneca\DisseminationToolkit\Http\Controllers\UserController;
use Uneca\DisseminationToolkit\Http\Controllers\UserSuspensionController;
use Uneca\DisseminationToolkit\Http\Controllers\VisualizationController as VisualizationManagementControllerAlias;
use Uneca\DisseminationToolkit\Http\Controllers\VisualizationPublishedStatusController;
use Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\ChartWizardController;
use Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\MapWizardController;
use Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\ScorecardWizardController;
use Uneca\DisseminationToolkit\Http\Controllers\VizBuilder\TableWizardController;
use Uneca\DisseminationToolkit\Http\Controllers\YearController;

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
        Route::resource('dimension', DimensionController::class);
        Route::resource('year', YearController::class);
        Route::resource('dimension.values', DimensionValueController::class);
        Route::resource('dimension.import-values', DimensionValueImportController::class)->only(['create', 'store']);

        //Route::resource('dataset', DatasetManagementController::class)->only(['index', 'create', 'edit', 'destroy']);
        Route::get('dataset', [DatasetManagementController::class, 'index'])->name('dataset.index');
        Route::get('dataset/create', [DatasetManagementController::class, 'create'])->name('dataset.create')
            ->can(PermissionsEnum::CREATE_DATASET);
        Route::get('dataset/{dataset}/edit', [DatasetManagementController::class, 'edit'])->name('dataset.edit')
            ->can(PermissionsEnum::EDIT_DATASET);
        Route::delete('dataset/{dataset}', [DatasetManagementController::class, 'destroy'])->name('dataset.destroy')
            ->can(PermissionsEnum::DELETE_DATASET);
        Route::get('dataset/{dataset}/import', [DatasetImportController::class, 'create'])->name('dataset.import')
            ->can(PermissionsEnum::IMPORT_DATASET);
        //Route::get('dataset/{dataset}/remove', DatasetRemovalController::class)->name('dataset.remove');
        Route::get('dataset/{dataset}/truncate', DatasetTruncationController::class)->name('dataset.truncate')
            ->can(PermissionsEnum::IMPORT_DATASET);
        Route::get('dataset/{dataset}/download-template', DatasetTemplateController::class)->name('dataset.download-template');
        Route::patch('dataset/{dataset}/change-publish-status', DatasetPublishStatusController::class)->name('dataset.change-publish-status')
            ->can(PermissionsEnum::PUBLISH_AND_UNPUBLISH_DATASET);

        //Route::resource('story', \Uneca\DisseminationToolkit\Http\Controllers\StoryController::class);
        Route::get('story', [StoryManagementController::class, 'index'])->name('story.index');
        Route::get('story/create', [StoryManagementController::class, 'create'])->name('story.create')->can(PermissionsEnum::CREATE_STORY);
        Route::post('story', [StoryManagementController::class, 'store'])->name('story.store')->can(PermissionsEnum::CREATE_STORY);
        Route::get('story/{story}/edit', [StoryManagementController::class, 'edit'])->name('story.edit')->can(PermissionsEnum::EDIT_STORY);
        Route::patch('story/{story}', [StoryManagementController::class, 'update'])->name('story.update')->can(PermissionsEnum::EDIT_STORY);
        Route::delete('story', [StoryManagementController::class, 'destroy'])->name('story.destroy')->can(PermissionsEnum::DELETE_STORY);
        Route::get('story/{story}/duplicate', StoryDuplicationController::class)->name('story.duplicate')->can(PermissionsEnum::CREATE_STORY);
        Route::get('story-builder/{story}', [StoryBuilderController::class, 'edit'])->name('story-builder.edit')->can(PermissionsEnum::EDIT_STORY);
        Route::patch('story-builder/{story}', [StoryBuilderController::class, 'update'])->name('story-builder.update')->can(PermissionsEnum::EDIT_STORY);
        Route::patch('story/{story}/change-published-status', StoryPublishStatusController::class)->name('story.change-published-status')
            ->can(PermissionsEnum::PUBLISH_AND_UNPUBLISH_STORY);

        Route::get('visualization', [VisualizationManagementControllerAlias::class, 'index'])->name('visualization.index');
        Route::patch('visualization/{visualization}/change-published-status', VisualizationPublishedStatusController::class)->name('visualization.change-published-status')
            ->can(PermissionsEnum::PUBLISH_AND_UNPUBLISH_VIZ);
        Route::delete('visualization/{visualization}', [VisualizationManagementControllerAlias::class, 'destroy'])->name('visualization.destroy')
            ->can(PermissionsEnum::DELETE_VIZ);
        Route::get('viz-builder/chart/api/get', [ChartWizardController::class, 'ajaxGetChart']);
        Route::controller(ChartWizardController::class)->group(function () {
            Route::get('viz-builder/chart/step1', 'step1')->name('viz-builder.chart.step1');
            Route::get('viz-builder/chart/step2', 'step2')->name('viz-builder.chart.step2');
            Route::post('viz-builder/chart/step3', 'step3')->name('viz-builder.chart.step3');
            Route::get('viz-builder/chart/{viz}/edit', 'edit')->name('viz-builder.chart.edit');
            Route::post('viz-builder/chart', 'store')->name('viz-builder.chart.store');
        })->middleware(['can:create:viz', 'can:edit:viz']);
        Route::controller(TableWizardController::class)->group(function () {
            Route::get('viz-builder/table/step1', 'step1')->name('viz-builder.table.step1');
            Route::get('viz-builder/table/step2', 'step2')->name('viz-builder.table.step2');
            Route::get('viz-builder/table/step3', 'step3')->name('viz-builder.table.step3');
            Route::get('viz-builder/table/{viz}/edit', 'edit')->name('viz-builder.table.edit');
            Route::post('viz-builder/table', 'store')->name('viz-builder.table.store');
        })->middleware(['can:create:viz', 'can:edit:viz']);
        Route::controller(MapWizardController::class)->group(function () {
            Route::get('viz-builder/map/step1', 'step1')->name('viz-builder.map.step1');
            Route::get('viz-builder/map/step2', 'step2')->name('viz-builder.map.step2');
            Route::get('viz-builder/map/step3', 'step3')->name('viz-builder.map.step3');
            Route::get('viz-builder/map/{viz}/edit', 'edit')->name('viz-builder.map.edit');
            Route::post('viz-builder/map', 'store')->name('viz-builder.map.store');
        })->middleware(['can:create:viz', 'can:edit:viz']);
        Route::controller(ScorecardWizardController::class)->group(function () {
            Route::get('viz-builder/scorecard/step1', 'step1')->name('viz-builder.scorecard.step1');
            Route::get('viz-builder/scorecard/step2', 'step2')->name('viz-builder.scorecard.step2');
            Route::get('viz-builder/scorecard/step3', 'step3')->name('viz-builder.scorecard.step3');
            Route::get('viz-builder/scorecard/{viz}/edit', 'edit')->name('viz-builder.scorecard.edit');
            Route::post('viz-builder/scorecard', 'store')->name('viz-builder.scorecard.store');
        })->middleware(['can:create:viz', 'can:edit:viz']);

        Route::resource('census-table', DocumentManagementController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');

        Route::resource('announcement', AnnouncementController::class)->only(['index', 'create', 'store']);

        Route::middleware(['can:Super Admin'])->group(function () {
            Route::resource('role', RoleController::class)->only(['index', 'store', 'edit', 'destroy']);
            Route::resource('user', UserController::class)->only(['index', 'edit', 'update', 'destroy'])->middleware('password.confirm');
            Route::get('user/{user}/suspension', UserSuspensionController::class)->name('user.suspension')->middleware('password.confirm');

            Route::resource('area-hierarchy', AreaHierarchyController::class);
            Route::resource('area', AreaController::class)->except(['destroy']);
            Route::delete('area/truncate', [AreaController::class, 'destroy'])->name('area.destroy');

            Route::get('organization', [OrganizationController::class, 'edit'])->name('organization.edit');
            Route::patch('organization/{organization}', [OrganizationController::class, 'update'])->name('organization.update');
            Route::resource('tag', TagController::class)->only(['index', 'edit', 'update']);
            /*Route::name('templates.')->group(function () {
                //Route::resource('templates/visualization', \App\Http\Controllers\VisualizationTemplateController::class)->only(['index', 'destroy']);
                Route::resource('templates/story', \App\Http\Controllers\StoryTemplateController::class)->only(['index', 'destroy']);
            });*/
        });
    });

    Route::get('/', function () {
        return redirect()->route('landing');
    });

    Route::fallback(function () {
        return redirect()->route('landing');
    });
});
