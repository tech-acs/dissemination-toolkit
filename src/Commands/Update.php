<?php

namespace Uneca\DisseminationToolkit\Commands;

use Illuminate\Console\Command;
use Uneca\DisseminationToolkit\Traits\PackageTasksTrait;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;

class Update extends Command
{
    public $signature = 'dissemination:update {--composer=global}
        {--all : Runs all tasks (almost like new install)}
        {--dissemination-config : Publishes dissemination.php config file}
        {--migrations : Publishes migration files from dissemination}
        {--packages : Installs php dependencies via composer}
        {--jetstream-customizations : Copies customized jetstream files from dissemination}
        {--assets : Copies assets (css, js, images and stubs)}
        {--color-palettes : Copies color palettes from dissemination}
        {--npm : Installs node dependencies}
        {--copy-env : Copies .env.example from kit to .env and also generates key}';

    public $description = 'Update the Dashboard Starter Kit';

    use PackageTasksTrait;

    public function handle(): int
    {
        if (collect($this->options())->filter()->except('composer')->isEmpty()) {
            error('You have not specified any options');
            return self::FAILURE;
        }

        $runAll = $this->option('all') ?? false;
        $this->components->info("Updating Dashboard Starter Kit");

        if ($runAll || $this->option('dissemination-config')) {
            $this->components->task('Publishing dissemination config...', function () use ($runAll) {
                $this->callSilent('vendor:publish', ['--tag' => 'dissemination-config', '--force' => true]);
            });
        }
        if ($runAll || $this->option('migrations')) {
            $this->components->task('Publishing dissemination migrations...', function () use ($runAll) {
                $this->callSilent('vendor:publish', ['--tag' => 'dissemination-migrations', '--force' => true]);
            });
        }
        if ($runAll || $this->option('packages')) {
            $this->installPhpDependencies();
        }
        if ($runAll || $this->option('jetstream-customizations')) {
            $this->copyCustomizedJetstreamFiles();
        }
        if ($runAll || $this->option('assets')) {
            $this->copyAssets();
        }
        if ($runAll || $this->option('color-palettes')) {
            $this->copyColorPalettes();
        }
        if ($runAll || $this->option('stubs')) {
            $this->publishStubs();
        }
        if ($runAll || $this->option('npm')) {
            $this->installJsDependencies();
        }
        if ($runAll || $this->option('copy-env')) {
            $this->installEnvFiles();
        }

        info('Update complete');
        return self::SUCCESS;
    }

}
