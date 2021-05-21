<?php

namespace Mach3builders\PrivateLabel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mach3builders\PrivateLabel\Models\PrivateLabel;

class PrivateLabelFactory extends Factory
{
    protected $model = PrivateLabel::class;

    public function definition(): Array
    {
        return [
            'domain' => $this->faker->domainName,
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];
    }
}
