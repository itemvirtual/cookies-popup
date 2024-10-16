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
     * Check if user consent recaptcha cookies
     *
     * @return bool
     */
    public static function allowedPreferencesCookies()
    {
        return Cookie::get('preferences_cookies') == 'true';
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
        $noJqueryScripts = config('cookies-popup.no_jquery_scripts');

        $styles = self::getStubContents(__DIR__ . '/../stubs/styles.stub', self::getStylesReplacements());
        if ($noJqueryScripts) {
            $scripts = self::getStubContents(__DIR__ . '/../stubs/no-jquery-script.stub', self::getScriptReplacements());
        } else {
            $scripts = self::getStubContents(__DIR__ . '/../stubs/script.stub', self::getScriptReplacements());
        }

        return view('cookiesPopup::cookies-popup', ['styles' => $styles, 'scripts' => $scripts, 'translationsFile' => $translationsFile])->render();
    }

    private static function getStylesReplacements()
    {
        return [
            'overlayZIndex' => config('cookies-popup.custom_styles.overlay_z_index'),
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
        $noJqueryScripts = config('cookies-popup.no_jquery_scripts');

        if (config('cookies-popup.google_consent_mode')) {
            $setConsentGranted = 'setAnalyticalConsent(\'granted\'); setAdvertisingConsent(\'granted\');';
            $setConsentDenied = 'setAnalyticalConsent(\'denied\'); setAdvertisingConsent(\'denied\');';
            if ($noJqueryScripts) {
                $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/no-jquery-analytical-change-listener-with-consent.stub', []);
                $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/no-jquery-advertising-change-listener-with-consent.stub', []);
            } else {
                $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/analytical-change-listener-with-consent.stub', []);
                $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/advertising-change-listener-with-consent.stub', []);
            }
        } else {
            $setConsentGranted = '';
            $setConsentDenied = '';
            if ($noJqueryScripts) {
                $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/no-jquery-analytical-change-listener.stub', []);
                $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/no-jquery-advertising-change-listener.stub', []);
            } else {
                $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/analytical-change-listener.stub', []);
                $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/advertising-change-listener.stub', []);
            }
        }
        return [
            'localStorageKeyName' => config('cookies-popup.local_storage_key_name'),
            'cookiesPopupDismissible' => config('cookies-popup.cookies_popup_dismissible') ? 1 : 0,
            'cookiesPopupReloadOnClose' => config('cookies-popup.cookies_popup_reload_on_close') ? 1 : 0,
            'cookiesConfigureUrl' => route('cookies-popup-save-configuration'),
            'showCookiesTimeoutMilliseconds' => (int)config('cookies-popup.show_cookies_popup_timeout', 1000),
            'hideCookiesTimeoutMilliseconds' => (int)config('cookies-popup.hide_cookies_popup_timeout', 1000),
            'analyticalChangeListener' => $analyticalChangeListener,
            'advertisingChangeListener' => $advertisingChangeListener,
            'setConsentGranted' => $setConsentGranted,
            'setConsentDenied' => $setConsentDenied,
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
    public static function getHeadStyles()
    {
        $styles = self::getStubContents(__DIR__ . '/../stubs/styles.stub', self::getStylesReplacements());
        return view('cookiesPopup::head-styles', ['styles' => $styles])->render();
    }

    /**
     * Get ga.js script
     *
     * @return string
     */
    public static function getAnalyticsJs($measurementIds = null)
    {
        if ($measurementIds) {
            $arMeasurementIds = array_map('trim', explode(',', $measurementIds));
        } else {
            $arMeasurementIds = array_map('trim', explode(',', config('cookies-popup.ga_measurement_id')));
        }
        $firstMeasurementId = $arMeasurementIds[0];

        if (!self::allowedAnalyticalCookies()) {
            return '';
        }

        // only put the real GA_MEASUREMENT_ID in production, or the GA_MEASUREMENT_ID provided by the user
        if (env('APP_ENV') != 'production' && !$measurementIds) {
            $arMeasurementIds = ['UA-XXXXXXXX-X'];
            $firstMeasurementId = 'UA-XXXXXXXX-X';
        }

        return view('cookiesPopup::analytics-js', ['measurementIds' => $arMeasurementIds, 'firstMeasurementId' => $firstMeasurementId])->render();
    }

    /**
     * Get ga.js script
     *
     * @return string
     */
    public static function getGtagJs($measurementIds = null)
    {
        if ($measurementIds) {
            $arMeasurementIds = array_filter(array_map('trim', explode(',', $measurementIds)));
        } else {
            $arMeasurementIds = array_filter(array_map('trim', explode(',', config('cookies-popup.ga_measurement_id'))));
        }
        $firstMeasurementId = array_key_exists(0, $arMeasurementIds) ? $arMeasurementIds[0] : null;

        if (!self::allowedAnalyticalCookies() && !config('cookies-popup.google_consent_mode')) {
            return '';
        }

        // only put the real GA_MEASUREMENT_ID in production, or the GA_MEASUREMENT_ID provided by the user
        if (env('APP_ENV') != 'production' && !$measurementIds) {
            $arMeasurementIds = ['G-XXXXXXXXXX'];
            $firstMeasurementId = 'G-XXXXXXXXXX';
        }

        return view('cookiesPopup::gtag-js', ['measurementIds' => $arMeasurementIds, 'firstMeasurementId' => $firstMeasurementId])->render();
    }

}
