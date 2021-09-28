<?php

return [
    'activating_ssl' => 'Activating SSL certificate',
    'checking_dns_info' => 'Make sure the CNAME record for :domain points to '.config('private-label.domain').' Note: It can take up to 24 hours before a changed DNS setting is visible.',
    'checking_dns' => 'Checking DNS',
    'domain_form_text' => 'Enter the domain name for your Private Label environment here. This domain name must be in your possession. Enter the full name with "www". It may also be a subdomain (subdomain.yourdomainname.nl) of your website.',
    'domain' => 'Domain',
    'email_form_text' => 'Enter the e-mail address that will be shown as the sender address to your customers with all e-mails that are sent from your Private Label environment.',
    'email' => 'Email address',
    'favicon_form_text' => 'Upload here the icon shown in the browser window tab.',
    'favicon' => 'favicon',
    'images' => 'images',
    'info' => '<strong> Attention! </strong> <br>
        We recommend that you first create the CNAME record in the DNS of your domain name. <br>
        Create a CNAME record for the chosen (sub) domain with the value: <strong>'.config('private-label.domain').'</strong>. <br>
        Then your Private Label environment will be active faster. <br>
        If you need help setting the CNAME record, please contact your domain name provider.',
    'logo_app_height' => 'Logo height in navigation bar',
    'logo_dark_form_text' => 'Upload here the logo shown on the white screens of '.config('app.name'),
    'logo_dark' => 'Dark logo',
    'logo_light_form_text' => 'Upload here the logo that will be shown on the dark screens of '.config('app.name'),
    'logo_light' => 'Light logo',
    'logo_login_height' => 'Login height logo on login screen',
    'name_form_text' => 'Enter the domain name for your Private Label environment here. This domain name must be in your possession. Enter the full name with "www". It may also be a subdomain (subdomain.yourdomainname.nl) of your website. ',
    'name' => 'name',
    'private label' => 'Private label',
    'save' => 'save',
    'your_platform' => 'Your platform',
];
