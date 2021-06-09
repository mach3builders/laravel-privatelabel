<?php

namespace Mach3builders\PrivateLabel\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Tests\Fixtures\Owner;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PrivateLabelTest extends FeatureTestCase
{
    private function validData($data = []): array
    {
        return array_merge([
            'domain' => 'www.mach3builders.nl',
            'name' => 'Mach3Builders',
            'email' => 'info@mach3builders.nl',
            'logo_login_height' => 12,
            'logo_app_height' => 13,
            'logo_light' => UploadedFile::fake()->image('logo_light.png'),
            'logo_dark' => UploadedFile::fake()->image('logo_dark.png'),
            'favicon' => UploadedFile::fake()->image('favicon.png'),
        ], $data);
    }

    /** @test */
    public function can_visit_private_label()
    {
        $owner = Owner::factory()->create();

        $this->get('app/private-label/'. $owner->id)
            ->assertOk();
    }

    /** @test */
    public function can_create_private_label()
    {
        Queue::fake();
        Storage::fake();

        $owner = Owner::factory()->create();

        $this->patch('app/private-label/'. $owner->id, $this->validData())
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('private_labels', [
            'domain' => 'www.mach3builders.nl',
            'name' => 'Mach3Builders',
            'email' => 'info@mach3builders.nl',
            'logo_login_height' => 12,
            'logo_app_height' => 13,
        ]);

        Queue::assertPushed(InstallSite::class);

        // @TODO
        // $private_label = $owner->privateLabel()->first();

        // $this->assertTrue($private_label->hasMedia('logo_light'));
        // $this->assertTrue($private_label->hasMedia('logo_dark'));
        // $this->assertTrue($private_label->hasMedia('favicon'));
    }

    /** @test */
    public function can_update_private_label()
    {
        Queue::fake();
        Storage::fake();

        $owner = Owner::factory()->create();
        PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->patch('app/private-label/'. $owner->id, $this->validData())
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('private_labels', [
            'name' => 'Mach3Builders',
            'email' => 'info@mach3builders.nl',
            'logo_login_height' => 12,
            'logo_app_height' => 13,
        ]);

        Queue::assertNotPushed(InstallSite::class);

        // @TODO
        // $private_label = PrivateLabel::latest()->first();

        // $this->assertTrue($private_label->hasMedia('logo_light'));
        // $this->assertTrue($private_label->hasMedia('logo_dark'));
        // $this->assertTrue($private_label->hasMedia('favicon'));
    }

    /** @test */
    public function cant_manage_others_media()
    {
        Storage::fake();

        $owner = Owner::factory()->create();
        $private_label = PrivateLabel::factory()->state(['owner_id' => $owner->id])->create();

        $this->patch('app/private-label/'. $owner->id, $this->validData())
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $media = Media::create();
        // $media = $private_label->addMedia(UploadedFile::fake()->create('dark.jpg', 500))->toMediaCollection('logo_dark');

        $this->get("app/private-label/delete-media/{$media->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function can_delete_media()
    {
        Storage::fake();

        $private_label = PrivateLabel::factory()->create(['account_id' => account()->id]);
        $media = $private_label->addMedia(UploadedFile::fake()->create('dark.jpg', 500))->toMediaCollection('logo_dark');

        $this->get("app/private-label/delete-media/{$media->id}")
            ->assertRedirect();

        $this->assertFalse($private_label->hasMedia('logo_dark'));
    }
}
