<?php

namespace Mach3builders\PrivateLabel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Mach3builders\PrivateLabel\Jobs\InstallSite;
use Mach3builders\PrivateLabel\Jobs\InstallDomain;
use Mach3builders\PrivateLabel\PrivateLabelFacade;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Mach3builders\PrivateLabel\Events\EmailDomainVerified;
use Mach3builders\PrivateLabel\Http\Requests\UpdatePrivateLabelRequest;

class PrivateLabelMailController extends Controller
{
    public function index(int $owner_id)
    {
        $owner = PrivateLabelFacade::findOwnerById($owner_id);
        $private_label = PrivateLabelFacade::findByOwnerId($owner_id);

        return view('privatelabel::mail', compact('private_label', 'owner'));
    }

    public function update(Request $request, int $owner_id)
    {
        $attributes = $request->validate([
            'email' => 'required|email:rfc'
        ]);

        $label = PrivateLabelFacade::findByOwnerId($owner_id);

        $label->update([
            'email' => $attributes['email'],
            'email_verified' => false
        ]);

        InstallDomain::dispatch($label);

        return back();
    }

    public function verify(int $owner_id)
    {
        $label = PrivateLabelFacade::findByOwnerId($owner_id);
        $dns_records = collect();

        $response = Http::withBasicAuth('api', config('private-label.mailgun.api_token'))
            ->put('https://api.eu.mailgun.net/v3/domains/'.$label->email_domain.'/verify');
        if ($response->status() == 200) {
            if ($response->json('domain.state') == 'verified') {
                $label->setEmailVerified();
            } else {
                $dns_records->push(...$response->json('receiving_dns_records', []));
                $dns_records->push(...$response->json('sending_dns_records', []));
            }
        }

        return back()->with([
            'dns_records' => $dns_records
        ]);
    }
}
