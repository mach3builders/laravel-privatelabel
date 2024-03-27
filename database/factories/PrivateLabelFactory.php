<?php

namespace Mach3builders\PrivateLabel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;

class PrivateLabelFactory extends Factory
{
    protected $model = PrivateLabel::class;

    public function definition(): array
    {
        return [
            'owner_id' => function () {
                return Owner::factory();
            },
            'domain' => $this->faker->domainName,
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];
    }
}
