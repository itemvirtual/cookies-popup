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
        if (is_array(config('cookies-popup.excluded-routes')) && request()->route()) {
            foreach (config('cookies-popup.excluded-routes') as $excluded) {
                if (Str::is($excluded, request()->route()->getName())) {
                    return '';
                }
            }
        }

        $styles = self::getStubContents(__DIR__ . '/../stubs/styles.stub', self::getStylesReplacements());
        $scripts = self::getStubContents(__DIR__ . '/../stubs/script.stub', self::getScriptReplacements());
        return view('cookies-popup::cookies-popup', ['styles' => $styles, 'scripts' => $scripts])->render();
    }

    private static function getStylesReplacements()
    {
        return [
            'overlayBackgroundColor' => config('cookies-popup.styles.overlay-background-color'),
            'popupBoxShadow' => config('cookies-popup.styles.popup-box-shadow'),
            'popupBackgroundColor' => config('cookies-popup.styles.popup-background-color'),
            'popupTextColor' => config('cookies-popup.styles.popup-text-color'),
            'popupFontSize' => config('cookies-popup.styles.popup-font-size'),
            'popupLineHeight' => config('cookies-popup.styles.popup-line-height'),
            'popupMaxWidth' => config('cookies-popup.styles.popup-max-width'),

            'popupTitleTextColor' => config('cookies-popup.styles.popup-title-text-color'),
            'popupTitleFontSize' => config('cookies-popup.styles.popup-title-font-size'),
            'popupTitleLineHeight' => config('cookies-popup.styles.popup-title-line-height'),
            'popupTitleFontWeight' => config('cookies-popup.styles.popup-title-font-weight'),

            'buttonBorderRadius' => config('cookies-popup.styles.button-border-radius'),
            'buttonMargin' => config('cookies-popup.styles.button-margin'),
            'buttonPadding' => config('cookies-popup.styles.button-padding'),
            'buttonBackgroundColor' => config('cookies-popup.styles.button-background-color'),
            'buttonBorderColor' => config('cookies-popup.styles.button-border-color'),
            'buttonTextColor' => config('cookies-popup.styles.button-text-color'),
            'buttonFontSize' => config('cookies-popup.styles.button-font-size'),

            'configurationLabelFontWeight' => config('cookies-popup.styles.configuration-label-font-weight'),
            'configurationToggleControlColor' => config('cookies-popup.styles.configuration-toggle-control-color'),
            'configurationToggleInactiveColor' => config('cookies-popup.styles.configuration-toggle-inactive-color'),
            'configurationToggleActiveColor' => config('cookies-popup.styles.configuration-toggle-active-color'),
            'popupCloseButtonMargin' => config('cookies-popup.styles.popup-close-button-margin'),
        ];
    }

    private static function getScriptReplacements()
    {
        if (config('cookies-popup.google-consent-mode')) {
            $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/analytical-change-listener-with-consent.stub', []);
            $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/advertising-change-listener-with-consent.stub', []);

        } else {
            $analyticalChangeListener = self::getStubContents(__DIR__ . '/../stubs/analytical-change-listener.stub', []);
            $advertisingChangeListener = self::getStubContents(__DIR__ . '/../stubs/advertising-change-listener.stub', []);
        }
        return [
            'localStorageKeyName' => config('cookies-popup.localStorage-key-name'),
            'cookiesPopupDismissible' => config('cookies-popup.cookies-popup-dismissible') ? 1 : 0,
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
        $measurementIds = array_map('trim', explode(',', env('GA_MEASUREMENT_ID')));
        $firsMeasurementId = $measurementIds[0];

        // only put the real GA_MEASUREMENT_ID in production
        if (env('APP_ENV') != 'production') {
            $measurementIds = ['UA-XXXXX-Y'];
            $firsMeasurementId = 'UA-XXXXX-Y';
        }

        return view('cookies-popup::analytics-js', ['measurementIds' => $measurementIds, 'firsMeasurementId' => $firsMeasurementId])->render();
    }

    /**
     * Get ga.js script
     *
     * @return string
     */
    public static function getGtagJs()
    {
        $measurementIds = array_map('trim', explode(',', env('GA_MEASUREMENT_ID')));
        $firsMeasurementId = $measurementIds[0];

        if (!self::allowedAnalyticalCookies() && !config('cookies-popup.google-consent-mode')) {
            return '';
        }

        // only put the real GA_MEASUREMENT_ID in production
        if (env('APP_ENV') != 'production') {
            $measurementIds = ['UA-XXXXX-Y'];
            $firsMeasurementId = 'UA-XXXXX-Y';
        }

        return view('cookies-popup::gtag-js', ['measurementIds' => $measurementIds, 'firsMeasurementId' => $firsMeasurementId])->render();
    }

}
