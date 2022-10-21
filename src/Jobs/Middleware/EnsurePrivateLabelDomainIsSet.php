<?php

namespace Mach3builders\PrivateLabel\Jobs\Middleware;

use Mach3builders\PrivateLabel\Models\PrivateLabel;

class EnsurePrivateLabelDomainIsSet
{
    public function __construct(
        public PrivateLabel $label
    ) {}

    public function handle($job, $next)
    {
        if (! $this->label || ! $this->label?->email_verified) {
            config(['services.mailgun.domain' => env('MAILGUN_DOMAIN')]);

            $next($job);
        } else {
            config(['services.mailgun.domain' => $this->label->email_domain]);

            $next($job);
        }
    }
}
