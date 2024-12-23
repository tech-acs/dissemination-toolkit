<?php

namespace Uneca\DisseminationToolkit;

use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
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
                \Uneca\DisseminationToolkit\Components\SmartTable::class,
                \Uneca\DisseminationToolkit\Components\Reviews::class,
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
                'add_rank_column_to_all_dimension_tables'
            ])
            ->hasCommands([
                \Uneca\DisseminationToolkit\Commands\Dissemination::class,
                \Uneca\DisseminationToolkit\Commands\CustomJetstreamInstallCommand::class,
                \Uneca\DisseminationToolkit\Commands\Adminify::class,
                \Uneca\DisseminationToolkit\Commands\CreateDimensions::class,
                \Uneca\DisseminationToolkit\Commands\ImportData::class,
                \Uneca\DisseminationToolkit\Commands\ImportDataset::class,
                \Uneca\DisseminationToolkit\Commands\RemoveDimension::class,
                \Uneca\DisseminationToolkit\Commands\RemoveDimensions::class,
                \Uneca\DisseminationToolkit\Commands\Update::class,
            ]);
    }

    public function packageRegistered()
    {
        Livewire::component('data-explorer', \Uneca\DisseminationToolkit\Livewire\DataExplorer::class);
        Livewire::component('data-shaper', \Uneca\DisseminationToolkit\Livewire\DataShaper::class);
        Livewire::component('data-shaper-selections-display', \Uneca\DisseminationToolkit\Livewire\DataShaperSelectionsDisplay::class);
        Livewire::component('area-filter', \Uneca\DisseminationToolkit\Livewire\AreaFilter::class);
        Livewire::component('area-spreadsheet-importer', \Uneca\DisseminationToolkit\Livewire\AreaSpreadsheetImporter::class);
        Livewire::component('bulk-inviter', \Uneca\DisseminationToolkit\Livewire\BulkInviter::class);
        Livewire::component('visualizations.chart', \Uneca\DisseminationToolkit\Livewire\Visualizations\Chart::class);
        Livewire::component('visualizations.table', \Uneca\DisseminationToolkit\Livewire\Visualizations\Table::class);
        Livewire::component('visualizations.map', \Uneca\DisseminationToolkit\Livewire\Visualizations\Map::class);
        Livewire::component('visualizations.scorecard', \Uneca\DisseminationToolkit\Livewire\Visualizations\Scorecard::class);
        Livewire::component('visualizer', \Uneca\DisseminationToolkit\Livewire\Visualizer::class);
        Livewire::component('table-options-shaper', \Uneca\DisseminationToolkit\Livewire\TableOptionsShaper::class);
        Livewire::component('map-options-shaper', \Uneca\DisseminationToolkit\Livewire\MapOptionsShaper::class);
        Livewire::component('scorecard-options-shaper', \Uneca\DisseminationToolkit\Livewire\ScorecardOptionsShaper::class);
        Livewire::component('topic-selector', \Uneca\DisseminationToolkit\Livewire\TopicSelector::class);
        Livewire::component('invitation-manager', \Uneca\DisseminationToolkit\Livewire\InvitationManager::class);
        Livewire::component('language-switcher', \Uneca\DisseminationToolkit\Livewire\LanguageSwitcher::class);
        Livewire::component('notification-bell', \Uneca\DisseminationToolkit\Livewire\NotificationBell::class);
        Livewire::component('notification-dropdown', \Uneca\DisseminationToolkit\Livewire\NotificationDropdown::class);
        Livewire::component('notification-inbox', \Uneca\DisseminationToolkit\Livewire\NotificationInbox::class);
        Livewire::component('role-manager', \Uneca\DisseminationToolkit\Livewire\RoleManager::class);
        Livewire::component('state-recorder', \Uneca\DisseminationToolkit\Livewire\StateRecorder::class);
        Livewire::component('i-need-alpine', \Uneca\DisseminationToolkit\Livewire\INeedAlpine::class);
        Livewire::component('dataset-importer', \Uneca\DisseminationToolkit\Livewire\DatasetImporter::class);
        Livewire::component('review-form', \Uneca\DisseminationToolkit\Livewire\ReviewForm::class);
        Livewire::component('dataset.create', \Uneca\DisseminationToolkit\Livewire\Dataset\Create::class);
        Livewire::component('dataset.update', \Uneca\DisseminationToolkit\Livewire\Dataset\Update::class);
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
        $router->pushMiddlewareToGroup('web', \Uneca\DisseminationToolkit\Http\Middleware\CheckAccountSuspension::class);
        $router->pushMiddlewareToGroup('web', \Uneca\DisseminationToolkit\Http\Middleware\Language::class);
        $router->aliasMiddleware('enforce_2fa', \Uneca\DisseminationToolkit\Http\Middleware\RedirectIf2FAEnforced::class);
        //$router->aliasMiddleware('log_page_views', \Uneca\DisseminationToolkit\Http\Middleware\LogPageView::class);

        Fortify::registerView(function (Request $request) {
            if (! $request->hasValidSignature()) {
                throw new InvalidSignatureException();
            }
            return view('auth.register')
                ->with(['encryptedEmail' => Crypt::encryptString($request->email)]);
        });

        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', \Uneca\DisseminationToolkit\Http\Middleware\CheckAccountSuspension::class);
        $router->pushMiddlewareToGroup('web', \Uneca\DisseminationToolkit\Http\Middleware\Language::class);
        $router->aliasMiddleware('enforce_2fa', \Uneca\DisseminationToolkit\Http\Middleware\RedirectIf2FAEnforced::class);
        //$router->aliasMiddleware('log_page_views', \Uneca\DisseminationToolkit\Http\Middleware\LogPageView::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middleware\PermissionMiddleware::class);
        $router->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);

        /*$this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('chimera:generate-reports')->hourly();
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/stubs' => resource_path('stubs'),
            ], 'chimera-stubs');
        }

        $this->app->singleton('settings', function () {
            return Cache::rememberForever('settings', function () {
                return Setting::all()->pluck('value', 'key');
            });
        });*/
    }
}
