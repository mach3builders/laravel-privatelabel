<?php

return [
    'activating_ssl' => 'Activate SSL certificate',
    'checking_dns_info' => 'Make sure the CNAME record for :domain points to '.config('private-label.domain').' Note: It can take up to 24 hours before a changed DNS setting is visible.',
    'checking_dns' => 'Checking DNS',
    'choose_file' => 'Choose file',
    'domain_form_text' => 'Enter here the domain name for your Private Label environment. This domain name must be in your possession. Enter the full name with "www". It can also be a subdomain (subdomain.yourdomain.nl) of your website.',
    'domain' => 'Domain',
    'email_form_text' => 'Enter here the e-mail address that will be shown as the sender address to your customers for system mails, which are sent from your Private Label environment.',
    'email' => 'Email address',
    'favicon_form_text' => 'Upload here the icon shown in the browser window tab.',
    'favicon' => 'favicon',
    'images' => 'images',
    'info' => '<strong>Caution!</strong><br>
        We recommend that you first create the CNAME record in the DNS of your domain name.<br>
        Create a CNAME record for the chosen (sub)domain with the value: <strong>'.config('private-label.domain').'</strong>.<br>
        Then your Private Label environment will be active faster.<br>
        If you need help setting up the CNAME record, please contact your domain name provider.',
    'logo_app_height' => 'Height logo navbar',
    'logo_dark_form_text' => 'Upload here the logo shown on the login page of the tool. We recommend using a PNG with transparent background.',
    'logo_dark' => 'Dark logo',
    'logo_light_form_text' => 'Upload here the logo shown in the top left corner of the tool. We recommend using a PNG with transparent background.',
    'logo_light' => 'Light logo',
    'logo_login_height' => 'Height logo login screen',
    'name_form_text' => 'Enter here the name that will be shown as sender to your customers with all system mails, which are sent from your Private Label environment.',
    'name' => 'Name',
    'private label' => 'Private label',
    'save' => 'Save',
    'your_platform' => 'Your platform',
];
