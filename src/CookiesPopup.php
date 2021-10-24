<?php

namespace Itemvirtual\CookiesPopup;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CookiesPopup
{

    /**
     * Check if user consent analytical cookies
     *
     * @return bool
     */
    public static function allowedAnalyticalCookies()
    {
        return Cookie::get('analytical_cookies') == 'true';
    }

    /**
     * Check if user consent advertising cookies
     *
     * @return bool
     */
    public static function allowedAdvertisingCookies()
    {
        return Cookie::get('advertising_cookies') == 'true';
    }

    /**
     * Check if user consent recaptcha cookies
     *
     * @return bool
     */
    public static function allowedRecaptchaCookies()
    {
        return Cookie::get('recaptcha_cookies') == 'true';
    }

    /**
     * Get cookies popup template, styles and scripts
     *
     * @return string
     */
    public static function addCookiesPopup()
    {
        // Excluded routes
        if (is_array(config('cookies-popup.excluded_routes')) && request()->route()) {
            foreach (config('cookies-popup.excluded_routes') as $excluded) {
                if (Str::is($excluded, request()->route()->getName())) {
                    return '';
                }
            }
        }

        $translationsFile = config('cookies-popup.translations_file');

        $styles = self::getStubContents(__DIR__ . '/../stubs/styles.stub', self::getStylesReplacements());
        $scripts = self::getStubContents(__DIR__ . '/../stubs/script.stub', self::getScriptReplacements());

        return view('cookiesPopup::cookies-popup', ['styles' => $styles, 'scripts' => $scripts, 'translationsFile' => $translationsFile])->render();
    }

    private static function getStylesReplacements()
    {
        return [
            'overlayBackgroundColor' => config('cookies-popup.custom_styles.overlay_background_color'),
            'popupBoxShadow' => config('cookies-popup.custom_styles.popup_box_shadow'),
            'popupBackgroundColor' => config('cookies-popup.custom_styles.popup_background_color'),
            'popupTextColor' => config('cookies-popup.custom_styles.popup_text_color'),
            'popupFontSize' => config('cookies-popup.custom_styles.popup_font_size'),
            'popupLineHeight' => config('cookies-popup.custom_styles.popup_line_height'),
            'popupMaxWidth' => config('cookies-popup.custom_styles.popup_max_width'),

            'popupTitleTextColor' => config('cookies-popup.custom_styles.popup_title_text_color'),
            'popupTitleFontSize' => config('cookies-popup.custom_styles.popup_title_font_size'),
            'popupTitleLineHeight' => config('cookies-popup.custom_styles.popup_title_line_height'),
            'popupTitleFontWeight' => config('cookies-popup.custom_styles.popup_title_font_weight'),

            'buttonBorderRadius' => config('cookies-popup.custom_styles.button_border_radius'),
            'buttonMargin' => config('cookies-popup.custom_styles.button_margin'),
            'buttonPadding' => config('cookies-popup.custom_styles.button_padding'),
            'buttonBackgroundColor' => config('cookies-popup.custom_styles.button_background_color'),
            'buttonBorderColor' => config('cookies-popup.custom_styles.button_border_color'),
            'buttonTextColor' => config('cookies-popup.custom_styles.button_text_color'),
            'buttonFontSize' => config('cookies-popup.custom_styles.button_font_size'),

            'configurationLabelFontWeight' => config('cookies-popup.custom_styles.configuration_label_font_weight'),
            'configurationToggleControlColor' => config('cookies-popup.custom_styles.configuration_toggle_control_color'),
            'configurationToggleInactiveColor' => config('cookies-popup.custom_styles.configuration_toggle_inactive_color'),
            'configurationToggleActiveColor' => config('cookies-popup.custom_styles.configuration_toggle_active_color'),
            'popupCloseButtonMargin' => config('cookies-popup.custom_styles.popup_close_button_margin'),
        ];
    }

    private static function getScriptReplacements()
    {
        if (config('cookies-popup.google_consent_mode')) {
            $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/analytical-change-listener-with-consent.stub', []);
            $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/advertising-change-listener-with-consent.stub', []);

        } else {
            $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/analytical-change-listener.stub', []);
            $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/advertising-change-listener.stub', []);
        }
        return [
            'localStorageKeyName' => config('cookies-popup.local_storage_key_name'),
            'cookiesPopupDismissible' => config('cookies-popup.cookies_popup_dismissible') ? 1 : 0,
            'cookiesConfigureUrl' => route('cookies-popup-save-configuration'),
            'analyticalChangeListener' => $analyticalChangeListener,
            'advertisingChangeListener' => $advertisingChangeListener,
        ];
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $replacements
     * @return bool|mixed|string
     */
    private static function getStubContents($stub, $replacements = [])
    {
        $contents = file_get_contents($stub);

        foreach ($replacements as $search => $replace) {
            $contents = str_replace('{{ ' . $search . ' }}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get ga.js script
     *
     * @return string
     */
    public static function getAnalyticsJs()
    {
        $measurementIds = array_map('trim', explode(',', config('cookies-popup.ga_measurement_id')));
        $firsMeasurementId = $measurementIds[0];

        // only put the real GA_MEASUREMENT_ID in production
        if (env('APP_ENV') != 'production') {
            $measurementIds = ['UA-XXXXX-Y'];
            $firsMeasurementId = 'UA-XXXXX-Y';
        }

        return view('cookiesPopup::analytics-js', ['measurementIds' => $measurementIds, 'firsMeasurementId' => $firsMeasurementId])->render();
    }

    /**
     * Get ga.js script
     *
     * @return string
     */
    public static function getGtagJs()
    {
        $measurementIds = array_map('trim', explode(',', config('cookies-popup.ga_measurement_id')));
        $firsMeasurementId = $measurementIds[0];

        if (!self::allowedAnalyticalCookies() && !config('cookies-popup.google_consent_mode')) {
            return '';
        }

        // only put the real GA_MEASUREMENT_ID in production
        if (env('APP_ENV') != 'production') {
            $measurementIds = ['UA-XXXXX-Y'];
            $firsMeasurementId = 'UA-XXXXX-Y';
        }

        return view('cookiesPopup::gtag-js', ['measurementIds' => $measurementIds, 'firsMeasurementId' => $firsMeasurementId])->render();
    }

}
