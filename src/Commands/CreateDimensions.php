<?php

namespace Uneca\DisseminationToolkit\Commands;

use App\Actions\CreateDimensionAction;
use App\Models\Dimension;
use Illuminate\Console\Command;

// ToDo: Add optional ability to specify table prefix
class CreateDimensions extends Command
{
    protected $signature = 'dissemination:create-dimensions {id?}';

    protected $description = 'Create dimension tables (only if they do not already exist) for each of the entries in the dimensions table';

    public function handle()
    {
        $dimensionId = $this->argument('id');
        if (is_null($dimensionId)) {
            $dimensions = Dimension::all();
        } else {
            $dimensions = Dimension::whereId($dimensionId)->get();
        }
        foreach ($dimensions as $dimension) {
            $this->info('Creating dimension: ' . $dimension->name);
            $successful = (new CreateDimensionAction)->handle($dimension);
            if ($successful) {
                $this->info("{$dimension->name} created.");
            } else {
                $this->error("Error creating {$dimension->name}");
            }
        }
    }
}
