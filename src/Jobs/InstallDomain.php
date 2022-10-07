<?php

namespace Mach3builders\PrivateLabel\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mach3builders\PrivateLabel\Models\PrivateLabel;

class InstallDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    public function __construct(
        public PrivateLabel $private_label
    )
    {
    }

    public function handle()
    {
        Http::asForm()->withBasicAuth('api', config('private-label.mailgun.api_token'))
            ->post('https://api.eu.mailgun.net/v3/domains', [
                'name' => $this->private_label->email_domain,
                'smtp_password' => Str::random(30),
            ]);
    }
}
