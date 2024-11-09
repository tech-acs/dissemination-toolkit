<?php

namespace UNECA\DisseminationToolkit\Commands;

use Illuminate\Console\Command;

class DisseminationToolkitCommand extends Command
{
    public $signature = 'dissemination-toolkit';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
