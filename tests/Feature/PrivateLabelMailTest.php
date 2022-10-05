<?php

namespace Mach3builders\PrivateLabel\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Mach3builders\PrivateLabel\Jobs\InstallDomain;
use Mach3builders\PrivateLabel\Tests\BaseTestCase;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;
use Mach3builders\PrivateLabel\Events\EmailDomainVerified;

class PrivateLabelMailTest extends BaseTestCase
{
    private function validData($data = []): array
    {
        return array_merge([
            'email' => 'info@mach3builders.nl',
        ], $data);
    }

    /** @test */
    public function can_visit_private_label_mail()
    {
        $owner = Owner::factory()->create();

        $this->get('app/private-label/'. $owner->id.'/mail')
            ->assertOk();
    }

    /** @test */
    public function can_create_private_label_mail()
    {
        Queue::fake();

        $owner = Owner::factory()->create();
        PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->patch('app/private-label/'. $owner->id.'/mail', $this->validData())
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        Queue::assertPushed(InstallDomain::class);

        $this->assertDatabaseHas('private_labels', [
            'email' => 'info@mach3builders.nl',
            'email_verified' => false,
        ]);
    }

    /** @test */
    public function can_ask_for_verification_of_domain()
    {
        Event::fake();
        Http::fake([
            'https://api.eu.mailgun.net/*' => Http::response('ok'),
        ]);

        $owner = Owner::factory()->create();
        $label = PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->post('app/private-label/'. $owner->id.'/mail/verify')
            ->assertRedirect();

        Event::assertDispatched(EmailDomainVerified::class);

        $this->assertDatabaseHas('private_labels', [
            'id' => $label->id,
            'email_verified' => true,
        ]);
    }
}
