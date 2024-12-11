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
use Uneca\DisseminationToolkit\Http\Controllers\DocumentPublishedStatusController;
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
use Uneca\DisseminationToolkit\Http\Controllers\StoryPublishedStatusController;
use Uneca\DisseminationToolkit\Http\Controllers\StoryRestrictedStatusController;
use Uneca\DisseminationToolkit\Http\Controllers\TagController;
use Uneca\DisseminationToolkit\Http\Controllers\TopicController;
use Uneca\DisseminationToolkit\Http\Controllers\UserController;
use Uneca\DisseminationToolkit\Http\Controllers\UserSuspensionController;
use Uneca\DisseminationToolkit\Http\Controllers\VisualizationController as VisualizationManagementControllerAlias;
use Uneca\DisseminationToolkit\Http\Controllers\VisualizationPublishedStatusController;
use Uneca\DisseminationToolkit\Http\Controllers\VisualizationRestrictedStatusController;
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
    Route::get('document', [DocumentController::class, 'index'])->name('document.index');
    Route::get('document/{id}', [DocumentController::class, 'show'])->name('document.show');
    Route::get('document/download/{Document}', [DocumentController::class, 'download'])->name('document.download');
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

        //Route::resource('topic', TopicController::class);
        Route::get('topic', [TopicController::class, 'index'])->name('topic.index');
        Route::get('topic/create', [TopicController::class, 'create'])->name('topic.create')->can(PermissionsEnum::CREATE_TOPIC);
        Route::post('topic', [TopicController::class, 'store'])->name('topic.store')->can(PermissionsEnum::CREATE_TOPIC);
        Route::get('topic/{topic}/edit', [TopicController::class, 'edit'])->name('topic.edit')->can(PermissionsEnum::EDIT_TOPIC);
        Route::patch('topic/{topic}', [TopicController::class, 'update'])->name('topic.update')->can(PermissionsEnum::EDIT_TOPIC);
        Route::delete('topic/{topic}', [TopicController::class, 'destroy'])->name('topic.destroy')->can(PermissionsEnum::DELETE_TOPIC);

        //Route::resource('indicator', IndicatorController::class);
        Route::get('indicator', [IndicatorController::class, 'index'])->name('indicator.index');
        Route::get('indicator/create', [IndicatorController::class, 'create'])->name('indicator.create')->can(PermissionsEnum::CREATE_INDICATOR);
        Route::post('indicator', [IndicatorController::class, 'store'])->name('indicator.store')->can(PermissionsEnum::CREATE_INDICATOR);
        Route::get('indicator/{indicator}/edit', [IndicatorController::class, 'edit'])->name('indicator.edit')->can(PermissionsEnum::EDIT_INDICATOR);
        Route::patch('indicator/{indicator}', [IndicatorController::class, 'update'])->name('indicator.update')->can(PermissionsEnum::EDIT_INDICATOR);
        Route::delete('indicator/{indicator}', [IndicatorController::class, 'destroy'])->name('indicator.destroy')->can(PermissionsEnum::DELETE_INDICATOR);

        //Route::resource('dimension', DimensionController::class);
        Route::get('dimension/create-table', DimensionTableCreationController::class)->name('dimension.create-table')->can(PermissionsEnum::CREATE_DIMENSION);
        Route::get('dimension', [DimensionController::class, 'index'])->name('dimension.index');
        Route::get('dimension/create', [DimensionController::class, 'create'])->name('dimension.create')->can(PermissionsEnum::CREATE_DIMENSION);
        Route::post('dimension', [DimensionController::class, 'store'])->name('dimension.store')->can(PermissionsEnum::CREATE_DIMENSION);
        Route::get('dimension/{dimension}/edit', [DimensionController::class, 'edit'])->name('dimension.edit')->can(PermissionsEnum::EDIT_DIMENSION);
        Route::patch('dimension/{dimension}', [DimensionController::class, 'update'])->name('dimension.update')->can(PermissionsEnum::EDIT_DIMENSION);
        Route::delete('dimension/{dimension}', [DimensionController::class, 'destroy'])->name('dimension.destroy')->can(PermissionsEnum::DELETE_DIMENSION);

        Route::middleware('permission:manage-values:dimension')->group(function () {
            Route::resource('dimension.values', DimensionValueController::class);
            Route::resource('dimension.import-values', DimensionValueImportController::class)->only(['create', 'store']);
        });

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
        Route::get('page-builder/{story}', [StoryBuilderController::class, 'designPage'])->name('page-builder.designPage')->can(PermissionsEnum::EDIT_STORY);
        Route::get('story-builder/{story}', [StoryBuilderController::class, 'edit'])->name('story-builder.edit')->can(PermissionsEnum::EDIT_STORY);
        Route::patch('story-builder/{story}', [StoryBuilderController::class, 'update'])->name('story-builder.update')->can(PermissionsEnum::EDIT_STORY);
        
        Route::patch('page-builder/{story}', [StoryBuilderController::class, 'updatePage'])->name('story.updatePage')->can(PermissionsEnum::EDIT_STORY);

        Route::patch('story/{story}/change-published-status', StoryPublishedStatusController::class)->name('story.change-published-status')
            ->can(PermissionsEnum::PUBLISH_AND_UNPUBLISH_STORY);
        Route::patch('story/{story}/change-restricted-status', StoryRestrictedStatusController::class)->name('story.change-restricted-status')
            ->can(PermissionsEnum::EDIT_STORY);
        Route::get('story/topics', [StoryBuilderController::class, 'getTopics'])->name('story.builder.topics');
        Route::get('story/artifacts/{topic_id}', [StoryBuilderController::class, 'getArtifacts'])->name('story.builder.artifacts');

        Route::get('visualization', [VisualizationManagementControllerAlias::class, 'index'])->name('visualization.index');
        Route::patch('visualization/{visualization}/change-published-status', VisualizationPublishedStatusController::class)->name('visualization.change-published-status')
            ->can(PermissionsEnum::PUBLISH_AND_UNPUBLISH_VIZ);
        Route::delete('visualization/{visualization}', [VisualizationManagementControllerAlias::class, 'destroy'])->name('visualization.destroy')
            ->can(PermissionsEnum::DELETE_VIZ);
        Route::patch('visualization/{visualization}/change-restricted-status', VisualizationRestrictedStatusController::class)->name('visualization.change-restricted-status')
            ->can(PermissionsEnum::EDIT_VIZ);
        Route::get('viz-builder/chart/api/get', [ChartWizardController::class, 'ajaxGetChart']);
        Route::middleware('permission:create:viz|edit:viz')->controller(ChartWizardController::class)->group(function () {
            Route::get('viz-builder/chart/step1', 'step1')->name('viz-builder.chart.step1');
            Route::get('viz-builder/chart/step2', 'step2')->name('viz-builder.chart.step2');
            Route::post('viz-builder/chart/step3', 'step3')->name('viz-builder.chart.step3');
            Route::get('viz-builder/chart/{viz}/edit', 'edit')->name('viz-builder.chart.edit');
            Route::post('viz-builder/chart', 'store')->name('viz-builder.chart.store');
        });
        Route::middleware('permission:create:viz|edit:viz')->controller(TableWizardController::class)->group(function () {
            Route::get('viz-builder/table/step1', 'step1')->name('viz-builder.table.step1');
            Route::get('viz-builder/table/step2', 'step2')->name('viz-builder.table.step2');
            Route::get('viz-builder/table/step3', 'step3')->name('viz-builder.table.step3');
            Route::get('viz-builder/table/{viz}/edit', 'edit')->name('viz-builder.table.edit');
            Route::post('viz-builder/table', 'store')->name('viz-builder.table.store');
        });
        Route::middleware('permission:create:viz|edit:viz')->controller(MapWizardController::class)->group(function () {
            Route::get('viz-builder/map/step1', 'step1')->name('viz-builder.map.step1');
            Route::get('viz-builder/map/step2', 'step2')->name('viz-builder.map.step2');
            Route::get('viz-builder/map/step3', 'step3')->name('viz-builder.map.step3');
            Route::get('viz-builder/map/{viz}/edit', 'edit')->name('viz-builder.map.edit');
            Route::post('viz-builder/map', 'store')->name('viz-builder.map.store');
        });
        Route::middleware('permission:create:viz|edit:viz')->controller(ScorecardWizardController::class)->group(function () {
            Route::get('viz-builder/scorecard/step1', 'step1')->name('viz-builder.scorecard.step1');
            Route::get('viz-builder/scorecard/step2', 'step2')->name('viz-builder.scorecard.step2');
            Route::get('viz-builder/scorecard/step3', 'step3')->name('viz-builder.scorecard.step3');
            Route::get('viz-builder/scorecard/{viz}/edit', 'edit')->name('viz-builder.scorecard.edit');
            Route::post('viz-builder/scorecard', 'store')->name('viz-builder.scorecard.store');
        });

        //Route::resource('document', DocumentManagementController::class)->only('index', 'create', 'store', 'edit', 'update', 'destroy');
        Route::get('document', [DocumentManagementController::class, 'index'])->name('document.index');
        Route::get('document/create', [DocumentManagementController::class, 'create'])->name('document.create')->can(PermissionsEnum::CREATE_DOCUMENT);
        Route::post('document', [DocumentManagementController::class, 'store'])->name('document.store')->can(PermissionsEnum::CREATE_DOCUMENT);
        Route::get('document/{document}/edit', [DocumentManagementController::class, 'edit'])->name('document.edit')->can(PermissionsEnum::EDIT_DOCUMENT);
        Route::patch('document/{document}', [DocumentManagementController::class, 'update'])->name('document.update')->can(PermissionsEnum::EDIT_DOCUMENT);
        Route::delete('document/{document}', [DocumentManagementController::class, 'destroy'])->name('document.destroy')->can(PermissionsEnum::DELETE_DOCUMENT);
        Route::patch('document/{document}/change-published-status', DocumentPublishedStatusController::class)->name('document.change-published-status')
            ->can(PermissionsEnum::PUBLISH_AND_UNPUBLISH_DOCUMENT);

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
