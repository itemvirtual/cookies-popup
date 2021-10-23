<?php

return [

    /*
    |--------------------------------------------------------------------------
    | LocalStorage Key name
    |--------------------------------------------------------------------------
    |
    */

    'localStorage-key-name' => 'accepted-cookies-popup',

    /*
    |--------------------------------------------------------------------------
    | Available cookies configuration
    |--------------------------------------------------------------------------
    |
    */

    'analytical' => true,
    'advertising' => false,
    'recaptcha' => false,

    /*
    |--------------------------------------------------------------------------
    | Translations file
    |--------------------------------------------------------------------------
    |
    */

    'translations-file' => 'labels',

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    */

    'styles' => [
        'overlay-background-color' => 'rgba(26, 26, 26, .82)',
        'popup-box-shadow' => '0 0 18px rgba(0, 0, 0, .2)',
        'popup-background-color' => '#FFF',
        'popup-text-color' => '#000',
        'popup-font-size' => '.95em',
        'popup-line-height' => '1.5',
        'popup-max-width' => '800px',

        'popup-title-text-color' => '#000',
        'popup-title-font-size' => '1.3em',
        'popup-title-line-height' => '1.4',
        'popup-title-font-weight' => '600',

        'button-border-radius' => '0',
        'button-margin' => '15px 10px',
        'button-padding' => '5px 7px',
        'button-background-color' => '#FFF',
        'button-border-color' => '#000',
        'button-text-color' => '#000',
        'button-font-size' => '0.9em',

        'popup-close-button-margin' => '30px 10px 15px',

        'configuration-label-font-weight' => '700',
        'configuration-toggle-control-color' => '#FFF',
        'configuration-toggle-inactive-color' => '#CCC',
        'configuration-toggle-active-color' => '#28A745',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom classes
    |--------------------------------------------------------------------------
    |
    | These custom classes will be added to the generic ones. If you need
    | to change the layout of the popup window
    | To avoid using !important concat your class with the generic one
    |
    | p. ex
    | .overlay.custom-overlay{background: red}
    |
    */

    'custom-classes' => [
        'overlay' => '',
        'popup' => '',
        'popup-header' => '',
        'popup-title' => '',
        'popup-text' => '',
        'popup-buttons' => '',
        'cookies-popup-configuration' => '',
        'accept-cookies-label' => '',
        'accept-cookies-info' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cookies popup dismiss
    |--------------------------------------------------------------------------
    |
    | Possibility of hiding the popup when clicking outside, in the overlay
    |
    */

    'cookies-popup-dismissible' => true,

    /*
    |--------------------------------------------------------------------------
    | Cookie remove
    |--------------------------------------------------------------------------
    |
    */

    'cookies-domain' => '.' . request()->getHost(),

    'analytical-cookies' => ['_ga', '_gat', '_gid'],
    'advertising-cookies' => [
        '_fbp',
        ['IDE' => '.doubleclick.net']
    ],
    'recaptcha-cookies' => [],

    /*
    |--------------------------------------------------------------------------
    | Excluded routes
    |--------------------------------------------------------------------------
    |
    | Add the route name of the routes where you don't want to show the popup
    |
    */

    'excluded-routes' => ['legal'],

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    |
    */

    'use-async-analytics-js' => true,

    /*
    |--------------------------------------------------------------------------
    | Google Consent Mode
    |--------------------------------------------------------------------------
    |
    | Google has a new consent mode (beta) to comply with the GDPR
    |
    | https://support.google.com/analytics/answer/9976101?hl=es
    |
    */

    'google-consent-mode' => false,

];