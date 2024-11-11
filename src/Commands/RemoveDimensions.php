<?php

namespace Uneca\DisseminationToolkit\Commands;

use App\Actions\RemoveDimensionAction;
use App\Models\Dimension;
use Illuminate\Console\Command;

// ToDo: Add optional ability to specify table prefix
class RemoveDimensions extends Command
{
    protected $signature = 'dissemination:remove-dimensions';

    protected $description = 'Drop dimension table, remove all foreign keys from fact tables and delete dimension entry for all in dimensions table';

    public function handle()
    {
        $dimensions = Dimension::all();
        foreach ($dimensions as $dimension) {
            $this->info('Removing dimension: ' . $dimension->name);
            $successful = (new RemoveDimensionAction)->handle($dimension);
            if ($successful) {
                $this->info("{$dimension->name} removed.");
            } else {
                $this->error("Error removing {$dimension->name}");
            }
        }
    }
}
