<?php

namespace Mach3builders\PrivateLabel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;

class OwnerFactory extends Factory
{
    protected $model = Owner::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
