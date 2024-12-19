<?php

namespace Mach3builders\PrivateLabel\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Tests\BaseTestCase;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;

class InstallSiteTest extends BaseTestCase
{
    /** @test */
    public function will_start_installing_site()
    {
        Http::fake([
            'localhost*' => Http::response([], 200),
            'https://mach3builders.nl/' => Http::response([], 200),
        ]);

        $owner = Owner::factory()->create();
        $private_label = PrivateLabel::factory()->create([
            'domain' => 'mach3builders.nl',
            'owner_id' => $owner->id,
            'status' => 'dns_validated',
        ]);

        (new InstallSite(($private_label)))->handle();
    }

    /** @test */
    public function will_retry_if_dns_is_not_validated()
    {
        Http::fake([
            'localhost*' => Http::response([], 200),
            'https://mach3builders.nl/' => Http::response([], 200),
        ]);

        $owner = Owner::factory()->create();
        $private_label = PrivateLabel::factory()->create([
            'domain' => 'mach3builders.nl',
            'owner_id' => $owner->id,
            'status' => 'dns_pending',
        ]);

        (new InstallSite(($private_label)))->handle();

        $this->assertDatabaseHas('private_labels', [
            'id' => $private_label->id,
            'status' => 'dns_pending',
        ]);
    }

    /** @test */
    public function will_update_status_to_site_installing()
    {
        Http::fake([
            'localhost*' => Http::response([], 200),
            'https://mach3builders.nl/' => Http::response([], 404),
        ]);

        $owner = Owner::factory()->create();
        $private_label = PrivateLabel::factory()->create([
            'domain' => 'mach3builders.nl',
            'owner_id' => $owner->id,
            'status' => 'dns_validated',
        ]);

        (new InstallSite(($private_label)))->handle();

        $this->assertDatabaseHas('private_labels', [
            'id' => $private_label->id,
            'status' => 'site_installing',
        ]);
    }

    /** @test */
    public function will_update_status_to_site_installed()
    {
        Http::fake([
            'localhost*' => Http::response([], 200),
            'https://mach3builders.nl/' => Http::response([], 200),
        ]);

        $owner = Owner::factory()->create();
        $private_label = PrivateLabel::factory()->create([
            'domain' => 'mach3builders.nl',
            'owner_id' => $owner->id,
            'status' => 'dns_validated',
        ]);

        (new InstallSite(($private_label)))->handle();

        $this->assertDatabaseHas('private_labels', [
            'id' => $private_label->id,
            'status' => 'site_installed',
        ]);
    }
}
