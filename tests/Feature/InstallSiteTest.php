<?php

namespace Mach3builders\PrivateLabel\Tests\Unit;

use Mockery\MockInterface;
use Mach3builders\PrivateLabel\Services\Forge;
use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\Tests\BaseTestCase;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;

class PrivateLabelTest extends BaseTestCase
{
    /** @test */
    public function will_start_installing_site()
    {
        $mock = $this->mock(Forge::class, function (MockInterface $mock) {
            $mock->shouldReceive('createSite')->andReturn((object) [
                'id' => 1
            ])->once()
            ->shouldReceive('updateNginx')->once()
            ->shouldReceive('createCertificate')->once();
        });

        $owner = Owner::factory()->create();
        $private_label = PrivateLabel::factory()->create([
            'owner_id' => $owner->id,
            'status' => 'dns_validated'
        ]);

        InstallSite::dispatch($private_label);
    }
}
