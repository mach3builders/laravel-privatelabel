<?php

namespace Mach3builders\PrivateLabel\Jobs\Middleware;

class EnsurePrivateLabelDomainIsSet
{
    public function __construct(
        public $label
    ) {}

    public function handle($job, $next)
    {
        if ($this->label && $this->label->email_verified) {
            config(['services.mailgun.domain' => $this->label->email_domain]);
        } else {
            config(['services.mailgun.domain' => config('private-label.owner_model')]);
        }

        $next($job);
    }
}
