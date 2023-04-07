<?php

namespace Mach3builders\PrivateLabel\Jobs\Middleware;

use Illuminate\Support\Facades\Mail;

class EnsurePrivateLabelDomainIsSet
{
    public function __construct(
        public $label
    ) {
    }

    public function handle($job, $next)
    {
        if (Mail::getDefaultDriver() != 'mailgun') {
            return $next($job);
        }

        if ($this->label && $this->label->email_verified) {
            app('mailer')
                ->getSwiftMailer()
                ->getTransport()
                ->setDomain($this->label->email_domain);
        } else {
            app('mailer')
                ->getSwiftMailer()
                ->getTransport()
                ->setDomain(config('private-label.mailgun.default_domain'));
        }

        $next($job);
    }
}
