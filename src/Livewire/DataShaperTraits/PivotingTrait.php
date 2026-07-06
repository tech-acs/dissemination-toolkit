<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

trait PivotingTrait
{
    public bool $pivotingNotPossible = false;

    public array $pivotableDimensions = [];

    public ?int $pivotColumn = null;

    public ?int $pivotRow = null;

    public ?int $nestingPivotColumn = null;
}
