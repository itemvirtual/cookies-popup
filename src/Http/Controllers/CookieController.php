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

    private $cookieLiveTime;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function configureCookies(Request $request)
    {
        $this->cookieLiveTime = (60 * 24 * 365 * 5); // 5 años en minutos

        switch ($request->get('type')) {
            case 'analytical':
                return $this->configureAnalytical($request->get('value'));
                break;
            case 'advertising':
                return $this->configureAdvertising($request->get('value'));
                break;
            case 'recaptcha':
                return $this->configureRecaptcha($request->get('value'));
                break;
            default:
                return $this->configureAll();
                break;
        }
    }

    private function deleteCookies($arCookies)
    {
        $cookiesDomain = config('cookies-popup.cookies_domain') ? : '.' . request()->getHost();

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
            ->cookie(
                'analytical_cookies', $value, $this->cookieLiveTime
            );
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
            ->cookie(
                'advertising_cookies', $value, $this->cookieLiveTime
            );
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
            ->cookie(
                'recaptcha_cookies', $value, $this->cookieLiveTime
            );
    }

    private function configureAll()
    {

        return response()
            ->json(['success' => true, 'message' => ''])
            ->cookie(
                'analytical_cookies', 'true', $this->cookieLiveTime
            )
            ->cookie(
                'advertising_cookies', 'true', $this->cookieLiveTime
            )
            ->cookie(
                'recaptcha_cookies', 'true', $this->cookieLiveTime
            );
    }

}