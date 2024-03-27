<?php

namespace Mach3builders\PrivateLabel\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Mach3builders\PrivateLabel\Events\EmailDomainVerified;
use Mach3builders\PrivateLabel\Jobs\InstallDomain;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Tests\BaseTestCase;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;

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
        PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->get('app/private-label/'.$owner->id.'/mail')
            ->assertOk();
    }

    /** @test */
    public function can_create_private_label_mail()
    {
        Queue::fake();

        $owner = Owner::factory()->create();
        PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->patch('app/private-label/'.$owner->id.'/mail', $this->validData())
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
            'https://api.eu.mailgun.net/*' => Http::response('{
                "domain": {
                    "created_at": "Thu, 06 Oct 2022 11:58:48 GMT",
                    "id": "633ec2f8dbae258dec2698e4",
                    "is_disabled": false,
                    "name": "mach3test.com",
                    "require_tls": false,
                    "skip_verification": false,
                    "smtp_login": "postmaster@mach3test.com",
                    "spam_action": "disabled",
                    "state": "unverified",
                    "type": "custom",
                    "web_prefix": "email",
                    "web_scheme": "http",
                    "wildcard": false
                },
                "message": "Domain DNS records have been updated",
                "receiving_dns_records": [
                    {
                        "cached": [],
                        "priority": "10",
                        "record_type": "MX",
                        "valid": "unknown",
                        "value": "mxa.eu.mailgun.org"
                    },
                    {
                        "cached": [],
                        "priority": "10",
                        "record_type": "MX",
                        "valid": "unknown",
                        "value": "mxb.eu.mailgun.org"
                    }
                ],
                "sending_dns_records": [
                    {
                        "cached": [],
                        "name": "mach3test.com",
                        "record_type": "TXT",
                        "valid": "unknown",
                        "value": "v=spf1 include:mailgun.org ~all"
                    },
                    {
                        "cached": [],
                        "name": "s1._domainkey.mach3test.com",
                        "record_type": "TXT",
                        "valid": "unknown",
                        "value": "k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDQCEfMUtoKgRMU/e4dvV5oe4hsc+jJfDFYKJZZ9OOa7ktM5ygeitambKCvLO2TiiZVW7kTVFy+rkdNl/3ov1XfjAnz70I35pe"
                    },
                    {
                        "cached": [],
                        "name": "email.mach3test.com",
                        "record_type": "CNAME",
                        "valid": "unknown",
                        "value": "eu.mailgun.org"
                    }
                ]
            }'),
        ]);

        $owner = Owner::factory()->create();
        $label = PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->get('app/private-label/'.$owner->id.'/mail');
        $this->post('app/private-label/'.$owner->id.'/mail/verify')
            ->assertRedirect();

        Event::assertNotDispatched(EmailDomainVerified::class);

        $this->assertFalse((bool) $label->refresh()->email_verified);
    }

    /** @test */
    public function can_ask_for_verification_of_domain_and_succeed()
    {
        Event::fake();
        Http::fake([
            'https://api.eu.mailgun.net/*' => Http::response('{
                "domain": {
                    "created_at": "Thu, 06 Oct 2022 11:58:48 GMT",
                    "id": "633ec2f8dbae258dec2698e4",
                    "is_disabled": false,
                    "name": "mach3test.com",
                    "require_tls": false,
                    "skip_verification": false,
                    "smtp_login": "postmaster@mach3test.com",
                    "spam_action": "disabled",
                    "state": "active",
                    "type": "custom",
                    "web_prefix": "email",
                    "web_scheme": "http",
                    "wildcard": false
                },
                "message": "Domain DNS records have been updated",
                "receiving_dns_records": [
                    {
                        "cached": [],
                        "priority": "10",
                        "record_type": "MX",
                        "valid": "unknown",
                        "value": "mxa.eu.mailgun.org"
                    },
                    {
                        "cached": [],
                        "priority": "10",
                        "record_type": "MX",
                        "valid": "unknown",
                        "value": "mxb.eu.mailgun.org"
                    }
                ],
                "sending_dns_records": [
                    {
                        "cached": [],
                        "name": "mach3test.com",
                        "record_type": "TXT",
                        "valid": "unknown",
                        "value": "v=spf1 include:mailgun.org ~all"
                    },
                    {
                        "cached": [],
                        "name": "s1._domainkey.mach3test.com",
                        "record_type": "TXT",
                        "valid": "unknown",
                        "value": "k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDQCEfMUtoKgRMU/e4dvV5oe4hsc+jJfDFYKJZZ9OOa7ktM5ygeitambKCvLO2TiiZVW7kTVFy+rkdNl/3ov1XfjAnz70I35pe"
                    },
                    {
                        "cached": [],
                        "name": "email.mach3test.com",
                        "record_type": "CNAME",
                        "valid": "unknown",
                        "value": "eu.mailgun.org"
                    }
                ]
            }'),
        ]);

        $owner = Owner::factory()->create();
        $label = PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->post('app/private-label/'.$owner->id.'/mail/verify')
            ->assertRedirect();

        Event::assertDispatched(EmailDomainVerified::class);

        $this->assertDatabaseHas('private_labels', [
            'id' => $label->id,
            'email_verified' => true,
        ]);
    }
}
