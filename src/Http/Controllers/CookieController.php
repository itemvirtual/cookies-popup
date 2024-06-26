<?php

namespace Itemvirtual\CookiesPopup\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $cookieLifetime;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function configureCookies(Request $request)
    {
        $this->cookieLifetime = (60 * 24 * 365 * 5); // 5 años en minutos

        switch ($request->get('type')) {
            case 'analytical':
                return $this->configureAnalytical($request->get('value'));
                break;
            case 'preferences':
                return $this->configurePreferences($request->get('value'));
                break;
            case 'advertising':
                return $this->configureAdvertising($request->get('value'));
                break;
            case 'recaptcha':
                return $this->configureRecaptcha($request->get('value'));
                break;
            default:
                return $this->configureAll($request->get('value'));
                break;
        }
    }

    private function deleteCookies($arCookies)
    {
        $cookiesDomain = config('cookies-popup.cookies_domain') ?: '.' . request()->getHost();

        // If google_consent_mode is true and google_consent_delete_cookie is false, cookies should not be deleted
        if (config('cookies-popup.google_consent_mode') && !config('cookies-popup.google_consent_delete_cookie', true)) {
            return;
        }

        foreach ($arCookies as $cookie) {
            if (is_array($cookie)) {
                $cookieName = key($cookie);
                $domain = $cookie[$cookieName];

                setcookie($cookieName, '', time() - 1000);
                setcookie($cookieName, '', time() - 1000, '/');
                setcookie($cookieName, '', time() - 1000, '/', $domain);
            } else {
                setcookie($cookie, '', time() - 1000);
                setcookie($cookie, '', time() - 1000, '/');
                setcookie($cookie, '', time() - 1000, '/', $cookiesDomain);
            }
        }
    }

    private function configureAnalytical($value)
    {
        if ($value == 'false') {
            // Delete Google analytics
            $arCookies = config('cookies-popup.analytical_cookies');
            $this->deleteCookies($arCookies);
        }

        return response()
            ->json(['success' => true, 'message' => ''])
            ->cookie('analytical_cookies', $value, $this->cookieLifetime);
    }

    private function configurePreferences($value)
    {
        if ($value == 'false') {
            // Delete Preferences
            $arCookies = config('cookies-popup.preferences_cookies');
            $this->deleteCookies($arCookies);
        }

        return response()
            ->json(['success' => true, 'message' => ''])
            ->cookie('preferences_cookies', $value, $this->cookieLifetime);
    }

    private function configureAdvertising($value)
    {
        if ($value == 'false') {
            // Delete Advertising
            $arCookies = config('cookies-popup.advertising_cookies');
            $this->deleteCookies($arCookies);
        }

        return response()
            ->json(['success' => true, 'message' => ''])
            ->cookie('advertising_cookies', $value, $this->cookieLifetime);
    }

    private function configureRecaptcha($value)
    {
        if ($value == 'false') {
            // Delete Recaptcha
            $arCookies = config('cookies-popup.recaptcha_cookies');
            $this->deleteCookies($arCookies);
        }

        return response()
            ->json(['success' => true, 'message' => ''])
            ->cookie('recaptcha_cookies', $value, $this->cookieLifetime);
    }

    private function configureAll($value)
    {
        if ($value == 'false') {
            // Delete all cookies
            $arCookiesAnalytical = config('cookies-popup.analytical_cookies');
            $this->deleteCookies($arCookiesAnalytical);

            $arCookiesPreferences = config('cookies-popup.preferences_cookies');
            $this->deleteCookies($arCookiesPreferences);

            $arCookiesAdvertising = config('cookies-popup.advertising_cookies');
            $this->deleteCookies($arCookiesAdvertising);

            $arCookiesRecaptcha = config('cookies-popup.recaptcha_cookies');
            $this->deleteCookies($arCookiesRecaptcha);
        }

        $response = response()->json(['success' => true, 'message' => '']);

        if (config('cookies-popup.configure_preferences')) {
            $response->cookie('preferences_cookies', $value, $this->cookieLifetime);
        }
        if (config('cookies-popup.configure_analytical')) {
            $response->cookie('analytical_cookies', $value, $this->cookieLifetime);
        }
        if (config('cookies-popup.configure_advertising')) {
            $response->cookie('advertising_cookies', $value, $this->cookieLifetime);
        }
        if (config('cookies-popup.configure_recaptcha')) {
            $response->cookie('recaptcha_cookies', $value, $this->cookieLifetime);
        }

        return $response;
    }

}