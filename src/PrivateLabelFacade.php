<?php

namespace Mach3builders\PrivateLabel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mach3builders\PrivateLabel\PrivateLabel
 */
class PrivateLabelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mach3builders\PrivateLabel\PrivateLabel::class;
    }
}
