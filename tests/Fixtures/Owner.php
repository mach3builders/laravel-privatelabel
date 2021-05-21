<?php

namespace Mach3builders\PrivateLabel\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mach3builders\PrivateLabel\Traits\HasPrivateLabel;
use Mach3builders\PrivateLabel\Interfaces\OwnsPrivateLabel;

class Owner extends Model implements OwnsPrivateLabel
{
    use HasFactory;
    use HasPrivateLabel;
}
