<?php

namespace Mach3builders\PrivateLabel\Jobs\Middleware;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Mailgun\Transport\MailgunHttpTransport;

class EnsurePrivateLabelDomainIsSet
{
    public function __construct(
        public $label
    ) {
        //
    }

    public function handle($job, $next)
    {
        if (Mail::getDefaultDriver() != 'mailgun') {
            return $next($job);
        }

        $domain = $this->label?->email_verified
            ? $this->label?->email_domain
            : config('services.mailgun.domain');

        $transport = (new MailgunHttpTransport(
            config('services.mailgun.secret'),
            $domain
        ))->setHost(config('services.mailgun.endpoint'));

        app('mailer')->setSymfonyTransport($transport);

        return $next($job);
    }
}
