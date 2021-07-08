<?php

namespace Mach3builders\PrivateLabel\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasPrivateLabel
{
    public function privateLabel(): HasOne
    {
        return $this->hasOne(\Mach3builders\PrivateLabel\Models\PrivateLabel::class, 'owner_id');
    }
}
