# Changelog

All notable changes to `cookies-popup` will be documented in this file

## 1.1.9 - 2023-06-21

- Popup Timeouts

> Add `show_cookies_popup_timeout` and `hide_cookies_popup_timeout` in your `config/cookies-popup.php`

```php
/*
|--------------------------------------------------------------------------
| Timeouts
|--------------------------------------------------------------------------
|
*/

'show_cookies_popup_timeout' => 1000,
'hide_cookies_popup_timeout' => 1000,
```

## 1.1.8 - 2023-06-16

- cookiesPopupReloadOnClose

> Add `cookies_popup_reload_on_close` in your `config/cookies-popup.php`

```php
/*
|--------------------------------------------------------------------------
| Reload after hide cookies popup
|--------------------------------------------------------------------------
|
| use location.reload(); to refresh the page
|
*/

'cookies_popup_reload_on_close' => false,
```

## 1.1.7 - 2023-06-13

- Change popup-buttons a to button

## 1.1.6 - 2023-01-09

- Remove illuminate/support dependency

## 1.1.5 - 2022-09-14

- Add decline_all_button to config

## 1.1.4 - 2022-09-14

- Change cookies-popup buttons
- Add fr, it, eu translations

## 1.1.3 - 2022-09-12

- Add cookies-popup-decline button

## 1.1.2 - 2022-05-30

- Add $measurementIds parameter to getAnalyticsJs() and getGtagJs()

## 1.1.1 - 2021-10-26

- prevent show analytics script if not allowed cookies

## 1.1.0 - 2021-10-25

- add preferences cookies

## 1.0.6 - 2021-10-24

- config rename

## 1.0.5 - 2021-10-23

- remove ga-measurement-id config

## 1.0.4 - 2021-10-23

- revert config publish out of runningInConsole

## 1.0.3 - 2021-10-23

- move config publish out of runningInConsole

## 1.0.2 - 2021-10-23

- rename config.php file to cookies-popup.php

## 1.0.1 - 2021-10-23

- clean and document EncryptCookies except array

## 1.0.0 - 2021-10-23

- initial release
