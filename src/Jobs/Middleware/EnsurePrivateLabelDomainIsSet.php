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

        if ($this->label && $this->label->email_verified) {
            app('mailer')->setSymfonyTransport(
                (new MailgunHttpTransport(config('services.mailgun.secret'), $this->label->email_domain))
                    ->setHost(config('services.mailgun.endpoint'))
            );
        } else {
            app('mailer')->setSymfonyTransport(
                (new MailgunHttpTransport(config('services.mailgun.secret'), config('services.mailgun.domain')))
                    ->setHost(config('services.mailgun.endpoint'))
            );
        }

        return $next($job);
    }
}
