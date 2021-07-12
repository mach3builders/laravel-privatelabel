<?php

use Mach3builders\PrivateLabel\PrivateLabelFacade;

if (! function_exists('label')) {
    /**
     * Return the current label based on the http host
     */
    function label()
    {
        return PrivateLabelFacade::getLabel();
    }
}
