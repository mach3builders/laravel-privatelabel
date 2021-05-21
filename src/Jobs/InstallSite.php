<?php

namespace Mach3builders\PrivateLabel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mach3builders\PrivateLabel\Models\PrivateLabel;

class InstallSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    public $private_label;

    public function __construct(PrivateLabel $private_label)
    {
        $this->private_label = $private_label;
    }

    /**
     * 2. Create site
     * 3. Update nginx
     * 4. Create certificate
     *
     * @return void
     */
    public function handle(Forge $forge)
    {
        if (! $this->private_label->checkDns()) {
            self::dispatch($this->private_label)
                    ->delay(now()->addMinute());

            return;
        } else {
            $this->private_label->update([
                'status' => 'dns_validated'
            ]);
        }

        if (! $this->private_label->forge_site_id) {
            $this->private_label->update([
                'status' => 'site_installing'
            ]);

            $site = $forge->createSite($this->private_label);

            $this->private_label->forge_site_id = $site->id;
            $this->private_label->save();
        }

        $forge->updateNginx($this->private_label);

        $forge->createCertificate($this->private_label);

        $this->private_label->update([
            'status' => 'site_installed'
        ]);
    }
}
