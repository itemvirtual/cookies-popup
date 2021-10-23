<?php


/*
|--------------------------------------------------------------------------
| Cookies Popup Routes
|--------------------------------------------------------------------------
|
| Route for ajax request that update the cookie status
|
*/

Route::post('/cookies-popup-save-configuration', ['as' => 'cookies-popup-save-configuration', 'uses' => 'Itemvirtual\CookiesPopup\Http\Controllers\CookieController@configureCookies']);