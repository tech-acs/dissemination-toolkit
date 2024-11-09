<?php

namespace UNECA\DisseminationToolkit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use UNECA\DisseminationToolkit\Commands\DisseminationToolkitCommand;

class DisseminationToolkitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('dissemination-toolkit')
            ->hasConfigFile(['dissemination-toolkit', 'languages', 'filesystems'])
            ->hasViews()
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
            ])
            ->hasCommands([]);
    }
}
