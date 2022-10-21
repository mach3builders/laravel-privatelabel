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
            return $next($job);
        }

        config(['services.mailgun.domain' => $this->label->email_domain]);

        $next($job);
    }
}
