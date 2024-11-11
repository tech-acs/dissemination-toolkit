<?php

namespace Uneca\DisseminationToolkit\Livewire\DataShaperTraits;

trait PivotingTrait {
    public bool $pivotingNotPossible = false;
    public array $pivotableDimensions = [];
    public int|null $pivotColumn = null;
    public int|null $pivotRow = null;
    public int|null $nestingPivotColumn = null;
}
