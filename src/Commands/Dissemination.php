<?php

namespace Uneca\DisseminationToolkit\Commands;

use Illuminate\Console\Command;
use Uneca\DisseminationToolkit\Traits\PackageTasksTrait;
use function Laravel\Prompts\info;

class Dissemination extends Command
{
    public $signature = 'dissemination:install {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    public $description = 'Install the dissemination toolkit into your newly created Laravel application';

    use PackageTasksTrait;

    public function handle(): int
    {
        $this->installJetstream();
        $this->installPhpDependencies();
        $this->publishVendorFiles();
        $this->copyCustomizedJetstreamFiles();
        $this->configureJetstreamFeatures();
        $this->copyAssets();
        $this->copyColorPalettes();
        $this->customizeExceptionRendering();
        $this->installEnvFiles();
        $this->installEmptyWebRoutesFile();
        $this->installJsDependencies();
//        $this->createPermissions();
        $this->cleanup();

        info("Installation complete");
        return self::SUCCESS;
    }
}
