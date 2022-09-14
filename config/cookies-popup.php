<?php

return [

    /*
    |--------------------------------------------------------------------------
    | LocalStorage Key name
    |--------------------------------------------------------------------------
    |
    */

    'local_storage_key_name' => 'accepted-cookies-popup',

    /*
    |--------------------------------------------------------------------------
    | Available cookies configuration
    |--------------------------------------------------------------------------
    |
    */

    'configure_analytical' => true,
    'configure_advertising' => false,
    'configure_recaptcha' => false,
    'configure_preferences' => false,

    /*
    |--------------------------------------------------------------------------
    | Add decline all button
    |--------------------------------------------------------------------------
    |
    */

    'decline_all_button' => true,

    /*
    |--------------------------------------------------------------------------
    | Translations file
    |--------------------------------------------------------------------------
    |
    */

    'translations_file' => 'cookies-popup',

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    */

    'custom_styles' => [
        'overlay_background_color' => 'rgba(26, 26, 26, .82)',
        'popup_box_shadow' => '0 0 18px rgba(0, 0, 0, .2)',
        'popup_background_color' => '#FFF',
        'popup_text_color' => '#000',
        'popup_font_size' => '.95em',
        'popup_line_height' => '1.5',
        'popup_max_width' => '800px',

        'popup_title_text_color' => '#000',
        'popup_title_font_size' => '1.3em',
        'popup_title_line_height' => '1.4',
        'popup_title_font_weight' => '600',

        'button_border_radius' => '0',
        'button_margin' => '15px 10px',
        'button_padding' => '5px 7px',
        'button_background_color' => '#FFF',
        'button_border_color' => '#000',
        'button_text_color' => '#000',
        'button_font_size' => '0.9em',

        'popup_close_button_margin' => '30px 10px 15px',

        'configuration_label_font_weight' => '700',
        'configuration_toggle_control_color' => '#FFF',
        'configuration_toggle_inactive_color' => '#CCC',
        'configuration_toggle_active_color' => '#28A745',
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

    'custom_classes' => [
        'overlay' => '',
        'popup' => '',
        'popup_header' => '',
        'popup_title' => '',
        'popup_text' => '',
        'popup_buttons' => '',
        'btn' => '',
        'cookies_popup_configuration' => '',
        'accept_cookies_label' => '',
        'accept_cookies_info' => '',
        'cookies_popup_close' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cookies popup dismiss
    |--------------------------------------------------------------------------
    |
    | Possibility of hiding the popup when clicking outside, in the overlay
    |
    */

    'cookies_popup_dismissible' => true,

    /*
    |--------------------------------------------------------------------------
    | Cookie remove
    |--------------------------------------------------------------------------
    |
    */

    'cookies_domain' => '',

    'analytical_cookies' => ['_ga', '_gat', '_gid'],
    'advertising_cookies' => [
        '_fbp',
        ['IDE' => '.doubleclick.net']
    ],
    'recaptcha_cookies' => [],
    'preferences_cookies' => [],

    /*
    |--------------------------------------------------------------------------
    | Excluded routes
    |--------------------------------------------------------------------------
    |
    | Add the route name of the routes where you don't want to show the popup
    |
    */

    'excluded_routes' => [],

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    |
    */
    'ga_measurement_id' => env('GA_MEASUREMENT_ID', null),
    'use_async_analytics_js' => true,

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

    'google_consent_mode' => false,

];