<?php

namespace Mach3builders\PrivateLabel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mach3builders\PrivateLabel\Models\PrivateLabel;

class CaddyAllowedDomainsController extends Controller
{
    public function index(Request $request)
    {
        $exists = PrivateLabel::where('domain', $request->domain)->exists();

        return response(
            content: $exists ? 'OK' : 'Forbidden',
            status: $exists ? 200 : 403
        );
    }
}
