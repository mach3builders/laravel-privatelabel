<?php

namespace Mach3builders\PrivateLabel;

class PrivateLabel
{
    public function findOwnerById($owner_id)
    {
        if ($owner_id === null) {
            return;
        }

        $model = config('private-label.owner_model');

        return (new $model)->where('id', $owner_id)->first();
    }
}
