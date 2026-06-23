<?php

namespace Uneca\DisseminationToolkit;

use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Uneca\DisseminationToolkit\Actions\CreateNewUser;
use Uneca\DisseminationToolkit\Commands\Adminify;
use Uneca\DisseminationToolkit\Commands\CreateDimensions;
use Uneca\DisseminationToolkit\Commands\CustomJetstreamInstallCommand;
use Uneca\DisseminationToolkit\Commands\Dissemination;
use Uneca\DisseminationToolkit\Commands\ImportData;
use Uneca\DisseminationToolkit\Commands\ImportDataset;
use Uneca\DisseminationToolkit\Commands\RemoveDimension;
use Uneca\DisseminationToolkit\Commands\RemoveDimensions;
use Uneca\DisseminationToolkit\Commands\SeedSample;
use Uneca\DisseminationToolkit\Commands\Update;
use Uneca\DisseminationToolkit\Components\Reviews;
use Uneca\DisseminationToolkit\Components\SmartTable;
use Uneca\DisseminationToolkit\Http\Middleware\CheckAccountSuspension;
use Uneca\DisseminationToolkit\Http\Middleware\Language;
use Uneca\DisseminationToolkit\Http\Middleware\RedirectIf2FAEnforced;
use Uneca\DisseminationToolkit\Livewire\AreaFilter;
use Uneca\DisseminationToolkit\Livewire\AreaSpreadsheetImporter;
use Uneca\DisseminationToolkit\Livewire\BulkInviter;
use Uneca\DisseminationToolkit\Livewire\DataExplorer;
use Uneca\DisseminationToolkit\Livewire\Dataset\Create;
use Uneca\DisseminationToolkit\Livewire\DatasetImporter;
use Uneca\DisseminationToolkit\Livewire\DataShaper;
use Uneca\DisseminationToolkit\Livewire\DataShaperSelectionsDisplay;
use Uneca\DisseminationToolkit\Livewire\INeedAlpine;
use Uneca\DisseminationToolkit\Livewire\InvitationManager;
use Uneca\DisseminationToolkit\Livewire\LanguageSwitcher;
use Uneca\DisseminationToolkit\Livewire\ManageStoryDesigner;
use Uneca\DisseminationToolkit\Livewire\MapOptionsShaper;
use Uneca\DisseminationToolkit\Livewire\NotificationBell;
use Uneca\DisseminationToolkit\Livewire\NotificationDropdown;
use Uneca\DisseminationToolkit\Livewire\NotificationInbox;
use Uneca\DisseminationToolkit\Livewire\ReviewForm;
use Uneca\DisseminationToolkit\Livewire\RoleManager;
use Uneca\DisseminationToolkit\Livewire\ScorecardOptionsShaper;
use Uneca\DisseminationToolkit\Livewire\StateRecorder;
use Uneca\DisseminationToolkit\Livewire\TableOptionsShaper;
use Uneca\DisseminationToolkit\Livewire\TidyDataMaker;
use Uneca\DisseminationToolkit\Livewire\TopicSelector;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Chart;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Map;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Scorecard;
use Uneca\DisseminationToolkit\Livewire\Visualizations\Table;
use Uneca\DisseminationToolkit\Livewire\Visualizer;
use Uneca\DisseminationToolkit\Models\Organization;
use Uneca\DisseminationToolkit\Models\Story;

class DisseminationToolkitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('dissemination')
            ->hasConfigFile(['dissemination', 'languages', 'filesystems'])
            ->hasViews()
            ->hasViewComponents(
                'dissemination',
                SmartTable::class,
                Reviews::class,
            )
            ->hasTranslations()
            ->hasRoute('web')
            ->hasMigrations([
                'install_postgis_extension',
                'install_ltree_extension',
                'install_tablefunc_extension',
                'add_is_suspended_and_last_login_at_columns_to_users_table',
                'create_invitations_table',
                'create_usage_stats_table',
                'create_areas_table',
                'create_indicators_table',
                'create_notifications_table',
                'create_announcements_table',
                'create_area_hierarchies_table',
                'create_settings_table',

                'create_documents_table',
                'create_dataset_dimension_table',
                'create_dataset_indicator_table',
                'create_datasets_table',
                'create_dimensions_table',
                /*'create_housing_facts_table',
                'create_population_facts_table',*/
                'create_fact_tables',
                'create_indicators_table',
                'create_organization_table',
                'create_reviews_table',
                'create_stories_table',
                'create_taggables_table',
                'create_tags_table',
                'create_topicables_table',
                'create_topics_table',
                'create_visualizations_table',
                'add_published_column_to_datasets_table',
                'add_code_and_rank_columns_to_topics_table',
                'add_restricted_column_to_visualizations_and_stories_tables',
                'add_code_column_to_dimensions_tables',
                'add_extra_columns_to_datasets_tables',
                'add_code_column_to_indicators_table',
                'add_rank_column_to_all_dimension_tables',
                'seed_default_permissions',
            ])
            ->hasCommands([
                Dissemination::class,
                CustomJetstreamInstallCommand::class,
                Adminify::class,
                CreateDimensions::class,
                ImportData::class,
                ImportDataset::class,
                RemoveDimension::class,
                RemoveDimensions::class,
                SeedSample::class,
                Update::class,
            ]);
    }

    public function packageRegistered()
    {
        Livewire::component('data-explorer', DataExplorer::class);
        Livewire::component('data-shaper', DataShaper::class);
        Livewire::component('data-shaper-selections-display', DataShaperSelectionsDisplay::class);
        Livewire::component('area-filter', AreaFilter::class);
        Livewire::component('area-spreadsheet-importer', AreaSpreadsheetImporter::class);
        Livewire::component('bulk-inviter', BulkInviter::class);
        Livewire::component('visualizations.chart', Chart::class);
        Livewire::component('visualizations.table', Table::class);
        Livewire::component('visualizations.map', Map::class);
        Livewire::component('visualizations.scorecard', Scorecard::class);
        Livewire::component('visualizer', Visualizer::class);
        Livewire::component('table-options-shaper', TableOptionsShaper::class);
        Livewire::component('map-options-shaper', MapOptionsShaper::class);
        Livewire::component('scorecard-options-shaper', ScorecardOptionsShaper::class);
        Livewire::component('topic-selector', TopicSelector::class);
        Livewire::component('invitation-manager', InvitationManager::class);
        Livewire::component('language-switcher', LanguageSwitcher::class);
        Livewire::component('notification-bell', NotificationBell::class);
        Livewire::component('notification-dropdown', NotificationDropdown::class);
        Livewire::component('notification-inbox', NotificationInbox::class);
        Livewire::component('role-manager', RoleManager::class);
        Livewire::component('state-recorder', StateRecorder::class);
        Livewire::component('i-need-alpine', INeedAlpine::class);
        Livewire::component('dataset-importer', DatasetImporter::class);
        Livewire::component('review-form', ReviewForm::class);
        Livewire::component('dataset.create', Create::class);
        Livewire::component('dataset.update', \Uneca\DisseminationToolkit\Livewire\Dataset\Update::class);
        Livewire::component('manage-story-designer', ManageStoryDesigner::class);
        Livewire::component('tidy-data-maker', TidyDataMaker::class);
    }

    public function packageBooted()
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        try {
            $stories = Story::select('id', 'title', 'slug', 'description')
                ->published()
                ->orderBy('updated_at')
                ->take(6)
                ->get();
        } catch (\Exception $exception) {
            $stories = collect();
        }

        try {
            $org = Organization::first();
        } catch (\Exception $exception) {
            $org = null;
        }

        View::share(['stories' => $stories, 'org' => $org]);

        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', CheckAccountSuspension::class);
        $router->pushMiddlewareToGroup('web', Language::class);
        $router->aliasMiddleware('enforce_2fa', RedirectIf2FAEnforced::class);
        // $router->aliasMiddleware('log_page_views', \Uneca\DisseminationToolkit\Http\Middleware\LogPageView::class);

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function (Request $request) {
            if (! $request->hasValidSignature()) {
                throw new InvalidSignatureException;
            }

            return view('auth.register')
                ->with(['encryptedEmail' => Crypt::encryptString($request->email)]);
        });

        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', CheckAccountSuspension::class);
        $router->pushMiddlewareToGroup('web', Language::class);
        $router->aliasMiddleware('enforce_2fa', RedirectIf2FAEnforced::class);
        // $router->aliasMiddleware('log_page_views', \Uneca\DisseminationToolkit\Http\Middleware\LogPageView::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);
    }
}
