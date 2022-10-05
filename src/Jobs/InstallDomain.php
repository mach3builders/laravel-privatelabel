<?php

namespace Mach3builders\PrivateLabel\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mach3builders\PrivateLabel\Services\Forge;
use Mach3builders\PrivateLabel\Models\PrivateLabel;

class InstallDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    public function __construct(
        public PrivateLabel $private_label)
    { }

    public function handle()
    {
        $domain_name = substr(strrchr($this->private_label->email, "@"), 1);

        // curl -s --user 'api:key-3084c4562bb3a70642f8dea1128ea02f' \
        //     -X POST https://api.mailgun.net/v3/domains \
        //     -F name='watkanschaapwel.nl' \
        //     -F smtp_password='supersecretpassword'

        // curl -s --user 'api:key-3084c4562bb3a70642f8dea1128ea02f' -X DELETE \
        //         https://api.mailgun.net/v3/domains/mailinator.net
        $response = Http::asForm()->withBasicAuth('api', config('private-label.mailgun.api_token'))
            ->post('https://api.eu.mailgun.net/v3/domains', [
                'name' => $domain_name,
                'smtp_password' => Str::random(30),
            ]);

        dd($response->json(), $response->status());
    }
}
