<?php

namespace Mach3builders\PrivateLabel\Tests\Fixtures;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mach3builders\PrivateLabel\Traits\HasPrivateLabel;

class Owner extends Model
{
    use HasFactory;
    use HasPrivateLabel;
}
