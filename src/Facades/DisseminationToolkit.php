<?php

namespace UNECA\DisseminationToolkit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \UNECA\DisseminationToolkit\DisseminationToolkit
 */
class DisseminationToolkit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \UNECA\DisseminationToolkit\DisseminationToolkit::class;
    }
}
