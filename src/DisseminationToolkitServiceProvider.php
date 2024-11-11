<?php

namespace Uneca\DisseminationToolkit;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
                'create_housing_facts_table',
                'create_population_facts_table',
                'create_indicators_table',
                'create_organization_table',
                'create_reviews_table',
                'create_stories_table',
                'create_taggables_table',
                'create_tags_table',
                'create_topicables_table',
                'create_topics_table',
                'create_visualizations_table',
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
        Livewire::component('chart', \Uneca\DisseminationToolkit\Livewire\Visualizations\Chart::class);
        Livewire::component('visualizations.table', \Uneca\DisseminationToolkit\Livewire\Visualizations\Table::class);
        Livewire::component('map', \Uneca\DisseminationToolkit\Livewire\Visualizations\Map::class);
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

        /*Fortify::registerView(function (Request $request) {
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
        $router->aliasMiddleware('log_page_views', \Uneca\DisseminationToolkit\Http\Middleware\LogPageView::class);

        $this->app->booted(function () {
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
