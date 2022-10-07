<?php

return [
    'activating_ssl' => 'SSL certificaat activeren',
    'checking_dns_info' => 'Zorg ervoor dat het CNAME-record voor :domain verwijst naar '.config('private-label.domain').' Let op: Het kan maximaal 24 uur duren voordat een gewijzigde DNS instelling zichtbaar is.',
    'checking_dns' => 'Controleren DNS',
    'choose_file' => 'Kies bestand',
    'domain_form_text' => 'Vul hier de domeinnaam in voor jouw Private Label omgeving. Deze domeinnaam moet in jouw bezit zijn. Vul de volledige naam in met "www". Het mag ook een subdomein (subdomein.jouwdomeinnaam.nl) zijn van jouw website.',
    'domain' => 'Domein',
    'email_form_text' => 'Vul hier het e-mailadres in dat als afzender adres wordt getoond aan jouw klanten bij systeem mails, welke verzonden worden vanuit jouw Private Label omgeving.',
    'email' => 'E-mailadres',
    'favicon_form_text' => 'Upload hier het icoon dat getoond wordt in het browservenster tabblad.',
    'favicon' => 'Favicon',
    'general' => 'Algemeen',
    'images' => 'Afbeeldingen',
    'info_email_verified' => 'Domein is geverifieerd',
    'info_email' => 'Voeg de volgende DNS records toe aan uw domein: ',
    'logo_app_height' => 'Height logo navbar',
    'logo_dark_form_text' => 'Upload hier het logo dat getoond wordt op de inlogpagina van de tool. We adviseren om een PNG met transparante achtergrond te gebruiken.',
    'logo_dark' => 'Donker logo',
    'logo_light_form_text' => 'Upload hier het logo dat getoond wordt in de linkerbovenhoek van de tool. We adviseren om een PNG met transparante achtergrond te gebruiken.',
    'logo_light' => 'Licht logo',
    'logo_login_height' => 'Height logo login screen',
    'name_form_text' => 'Vul hier de naam in dat als afzender wordt getoond aan jouw klanten bij alle systeem mails, welke verzonden worden vanuit jouw Private Label omgeving.',
    'mail' => 'Email instellingen',
    'name' => 'Naam',
    'private-label' => 'Private label',
    'save' => 'Opslaan',
    'value' => 'Waarde',
    'verify' => 'Verifieer domein',
    'your_platform' => 'Jouw platform',

    'info' => '<strong>Let op!</strong><br>
        Wij raden aan om eerst het CNAME-record aan te maken in de DNS van jouw domeinnaam.<br>
        Maak een CNAME-record aan voor het gekozen (sub)domein met als waarde: <strong>'.config('private-label.domain').'</strong>.<br>
        Dan zal jouw Private Label omgeving sneller actief zijn.<br>
        Heb je hulp nodig bij het instellen van het CNAME-record, neem dan contact op met je domeinnaamleverancier.',
];
