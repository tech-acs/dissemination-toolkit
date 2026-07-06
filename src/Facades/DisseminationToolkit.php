<?php

namespace Uneca\DisseminationToolkit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Uneca\DisseminationToolkit\DisseminationToolkit
 */
class DisseminationToolkit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Uneca\DisseminationToolkit\DisseminationToolkit::class;
    }
}
