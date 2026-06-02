<?php

namespace Uneca\DisseminationToolkit\Components;

use Illuminate\View\Component;
use Uneca\DisseminationToolkit\Services\SmartTableData;

class SmartTable extends Component
{
    public array $pageSizeOptions = [10, 20, 30, 40, 50, 75, 100, 200, 500, 1000];

    public function __construct(public SmartTableData $smartTableData, public ?string $customActionSubView = null) {}

    public function render()
    {
        return view('dissemination::components.smart-table');
    }
}
