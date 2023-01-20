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
    'email_info' => 'Via the email settings you can send the email within your account via the specified email address.
    After entering the email address, you can verify the domain. You will see a number of DNS records that must be set in the domain of the specified email address.
    If the DNS records have been entered correctly, the settings will be completed and from that moment on, email will be sent with the specified email address.',
    'favicon_form_text' => 'Upload here the icon shown in the browser window tab.',
    'favicon' => 'favicon',
    'general' => 'General',
    'images' => 'images',
    'info_email' => 'Please add the following dns records to:',
    'info_email_verified' => 'Domain is verified',
    'logo_app_height' => 'Height logo navbar',
    'logo_dark_form_text' => 'Upload here the logo shown on the login page of the tool. We recommend using a PNG with transparent background.',
    'logo_dark' => 'Dark logo',
    'logo_light_form_text' => 'Upload here the logo shown in the top left corner of the tool. We recommend using a PNG with transparent background.',
    'logo_light' => 'Light logo',
    'logo_login_height' => 'Height logo login screen',
    'name_form_text' => 'Enter here the name that will be shown as sender to your customers with all system mails, which are sent from your Private Label environment.',
    'name' => 'Name',
    'mail' => 'Email settings',
    'priority' => 'Priority',
    'private-label' => 'Private label',
    'save' => 'Save',
    'value' => 'Value',
    'verify' => 'Verify domain',
    'your_platform' => 'Your platform',
    'saved_and_installing_email' => 'Settings saved',

    'info' => '<strong> Attention! </strong> <br>
        We recommend that you first create the CNAME record in the DNS of your domain name. <br>
        Create a CNAME record for the chosen (sub) domain with the value: <strong>'.config('private-label.domain').'</strong>. <br>
        Then your Private Label environment will be active faster. <br>
        If you need help setting the CNAME record, please contact your domain name provider.',
];
