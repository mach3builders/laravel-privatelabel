<?php

if (! function_exists('label')) {
    /**
     * Return the current label based on the http host
     */
    function label()
    {
        return \Mach3builders\PrivateLabel\Models\PrivateLabel::where('domain', request()->server('HTTP_HOST'))->first();
    }
}
