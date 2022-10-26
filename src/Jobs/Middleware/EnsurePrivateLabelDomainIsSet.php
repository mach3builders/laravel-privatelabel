<?php

namespace Mach3builders\PrivateLabel\Jobs\Middleware;

use Illuminate\Support\Facades\Mail;
class EnsurePrivateLabelDomainIsSet
{
    public function __construct(
        public $label
    ) {}

    public function handle($job, $next)
    {
        if ($this->label
            && $this->label->email_verified
            && Mail::getDefaultDriver() == 'mailgun') {
            app('mailer')
                ->getSwiftMailer()
                ->getTransport()
                ->setDomain($this->label->email_domain);
        }

        $next($job);
    }
}
