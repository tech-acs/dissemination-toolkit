<?php

namespace UNECA\DisseminationToolkit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use UNECA\DisseminationToolkit\Commands\DisseminationToolkitCommand;

class DisseminationToolkitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('dissemination-toolkit')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_dissemination_toolkit_table')
            ->hasCommand(DisseminationToolkitCommand::class);
    }
}
