<?php

namespace Mach3builders\PrivateLabel\Tests\Unit;

use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Services\Forge;
use Mach3builders\PrivateLabel\Tests\BaseTestCase;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;
use Mockery\MockInterface;

class CaddyTest extends BaseTestCase
{
    /** @test */
    public function existing_private_label_may_have_ssl()
    {
        $private_label = PrivateLabel::factory()->create();

        $this->get('/caddy/allowed-domains?domain='.$private_label->domain)
            ->assertOk();
    }

    /** @test */
    public function unknown_private_label_may_not_have_ssl()
    {
        $this->get('/caddy/allowed-domains?domain=nonexisting.com')
            ->assertForbidden();
    }
}
