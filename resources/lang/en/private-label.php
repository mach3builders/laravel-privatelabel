<?php

return [
    'domain' => 'Domain',
    'domain_form_text' => 'Enter the domain name for your Private Label environment here. This domain name must be in your possession. Enter the full name with "www". It may also be a subdomain (subdomain.yourdomainname.nl) of your website.',
    'email' => 'E-mail address',
    'email_form_text' => 'Enter the e-mail address that will be shown as the sender address to your customers with all e-mails that are sent from your Private Label environment.',
    'favicon' => 'Favicon',
    'favicon_form_text' => 'Upload hier het icoon dat getoond wordt in het browservenster tabblad.',
    'images' => 'Images',
    'info' => '<strong> Attention! </strong> <br>
        We recommend that you first create the CNAME record in the DNS of your domain name. <br>
        Create a CNAME record for the chosen (sub) domain with the value: <strong>'.config('private-label.domain').'</strong>. <br>
        Then your Private Label environment will be active faster. <br>
        If you need help setting the CNAME record, please contact your domain name provider.',
    'logo_app_height' => 'Hoogte logo in navigatiebalk',
    'logo_dark' => 'Dark logo',
    'logo_dark_form_text' => 'Upload hier het logo dat getoond wordt op de witte schermen van '.config('app.name').'.',
    'logo_light' => 'Light logo',
    'logo_login_height' => 'Hoogte logo op loginscherm',
    'logo_light_form_text' => 'Upload hier het logo dat getoond wordt op de donkere schermen van '.config('app.name'),
    'name' => 'Name',
    'name_form_text' => 'Enter the domain name for your Private Label environment here. This domain name must be in your possession. Enter the full name with "www". It may also be a subdomain (subdomain.yourdomainname.nl) of your website. ',
    'private-label' => 'Private label',
    'your_platform' => 'Your platform',

    'checking_dns' => 'Controleren DNS',
    'checking_dns_info' => 'Zorg ervoor dat het CNAME-record voor :domain verwijst naar '.config('private-label.domain').' Let op: Het kan maximaal 24 uur duren voordat een gewijzigde DNS instelling zichtbaar is.',
    'activating_ssl' => 'SSL certificaat activeren',
];
