<?php

namespace Mach3builders\PrivateLabel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Mach3builders\PrivateLabel\Models\PrivateLabel;
use Mach3builders\PrivateLabel\Services\Forge;

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
     * 1. Check DNS
     * 2. Request url so caddy can request ssl
     * 3. Enjoy
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->private_label->checkDns()) {
            self::dispatch($this->private_label)
                ->delay(now()->addMinute());

            return;
        } else {
            $this->private_label->update([
                'status' => 'dns_validated',
            ]);
        }

        // When the dns is validated we can install the site aka send a get request
        $this->private_label->update([
            'status' => 'site_installing',
        ]);

        $response = Http::timeout(30)->get('https://'.$this->private_label->domain.'/');

        if (! $response->successful()) {
            self::dispatch($this->private_label)
                ->delay(now()->addMinute());

            return;
        }

        $this->private_label->update([
            'status' => 'site_installed',
        ]);
    }
}
