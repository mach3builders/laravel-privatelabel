<?php

return [
    'domain' => 'Domain',
    'domain_form_text' => 'Vul hier de domeinnaam in voor jouw Private Label omgeving. Deze domeinnaam moet in jouw bezit zijn. Vul de volledige naam in met "www". Het mag ook een subdomein (subdomein.jouwdomeinnaam.nl) zijn van jouw website.',
    'email' => 'E-mailadres',
    'email_form_text' => 'Vul hier het e-mailadres in dat als afzender adres wordt getoond aan jouw klanten bij alle mailtjes, welke verzonden worden vanuit jouw Private Label omgeving.',
    'favicon' => 'Favicon',
    'favicon_form_text' => 'Upload hier het icoon dat getoond wordt in het browservenster tabblad.',
    'images' => 'Afbeeldingen',
    'info' => '<strong>Let op!</strong><br>
        Wij raden aan om eerst het CNAME-record aan te maken in de DNS van jouw domeinnaam.<br>
        Maak een CNAME-record aan voor het gekozen (sub)domein met als waarde: <strong>'.config('private-label.domain').'</strong>.<br>
        Dan zal jouw Private Label omgeving sneller actief zijn.<br>
        Heb je hulp nodig bij het instellen van het CNAME-record, neem dan contact op met je domeinnaamleverancier.',
    'logo_app_height' => 'Height logo navbar',
    'logo_dark' => 'Donker logo',
    'logo_dark_form_text' => 'Upload hier het logo dat getoond wordt op de witte schermen van '.config('app.name').'.',
    'logo_light' => 'Licht logo',
    'logo_login_height' => 'Height logo login screen',
    'logo_light_form_text' => 'Upload hier het logo dat getoond wordt op de donkere schermen van '.config('app.name'),
    'name' => 'Naam',
    'name_form_text' => 'Vul hier de domeinnaam in voor jouw Private Label omgeving. Deze domeinnaam moet in jouw bezit zijn. Vul de volledige naam in met "www". Het mag ook een subdomein (subdomein.jouwdomeinnaam.nl) zijn van jouw website.',
    'private-label' => 'Private label',
    'your_platform' => 'Jouw platform',

    'checking_dns' => 'Controleren DNS',
    'checking_dns_info' => 'Zorg ervoor dat het CNAME-record voor :domain verwijst naar '.config('private-label.domain').' Let op: Het kan maximaal 24 uur duren voordat een gewijzigde DNS instelling zichtbaar is.',
    'activating_ssl' => 'SSL certificaat activeren',
];
