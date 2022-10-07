<?php

namespace Mach3builders\PrivateLabel;

use Mach3builders\PrivateLabel\Models\PrivateLabel as Model;

class PrivateLabel
{
    private $label = null;

    public function getLabel()
    {
        if (empty($this->label)) {
            $this->label = Model::where('domain', request()->server('HTTP_HOST'))
                                                ->first();
        }

        return $this->label;
    }

    public function findOwnerById(int $owner_id)
    {
        if ($owner_id === null) {
            return;
        }

        $model = config('private-label.owner_model');

        return (new $model)->where('id', $owner_id)->first();
    }

    public function findByOwnerId(int $owner_id)
    {
        if ($owner_id === null) {
            return;
        }

        return Model::where('owner_id', $owner_id)->first();
    }
}
