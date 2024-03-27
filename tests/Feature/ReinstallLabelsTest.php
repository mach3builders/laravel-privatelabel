<?php

namespace Mach3builders\PrivateLabel\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Tests\BaseTestCase;

class ReinstallLabelsTest extends BaseTestCase
{
    /** @test */
    public function can_run_command_for_all(): void
    {
        Queue::fake();

        PrivateLabel::factory()->count(3)->create();

        Artisan::call('label:reinstall');

        Queue::assertPushed(InstallSite::class, 3);
    }

    /** @test */
    public function can_run_command_for_specific_label(): void
    {
        Queue::fake();

        $labels = PrivateLabel::factory()->count(3)->create();

        Artisan::call('label:reinstall', ['--label' => $labels->first()->id]);

        Queue::assertPushed(InstallSite::class, function ($job) use ($labels) {
            return $job->private_label->is($labels->first());
        });
    }
}
