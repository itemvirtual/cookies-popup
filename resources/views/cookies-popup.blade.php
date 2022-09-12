@php($analyticalCookies = false)
@php($preferencesCookies = false)
@php($advertisingCookies = false)
@php($recaptchaCookies = false)

@if(Cookie::get('analytical_cookies') && Cookie::get('analytical_cookies') == 'true')
    @php($analyticalCookies = true)
@endif

@if(Cookie::get('preferences_cookies') && Cookie::get('preferences_cookies') == 'true')
    @php($preferencesCookies = true)
@endif

@if(Cookie::get('advertising_cookies') && Cookie::get('advertising_cookies') == 'true')
    @php($advertisingCookies = true)
@endif

@if(Cookie::get('recaptcha_cookies') && Cookie::get('recaptcha_cookies') == 'true')
    @php($recaptchaCookies = true)
@endif

{{--Styles--}}
<style>
    {!! $styles !!}
</style>

{{--Cookies popup--}}
<div id="cookies-popup-overlay" class="overlay {{ config('cookies-popup.custom_classes.overlay') }}">
    <div id="cookies-popup" class="popup {{ config('cookies-popup.custom_classes.popup') }}">
        <div class="popup-header {{ config('cookies-popup.custom_classes.popup_header') }}">
            <div class="popup-title {{ config('cookies-popup.custom_classes.popup_title') }}">{{ trans($translationsFile . '.cookies-popup-title') }}</div>
        </div>

        <div class="popup-text {{ config('cookies-popup.custom_classes.popup_text') }}">{!! nl2br(trans($translationsFile . '.cookies-popup-text')) !!}</div>
        <div class="popup-buttons {{ config('cookies-popup.custom_classes.popup_buttons') }}">
            <a id="cookies-popup-configure" class="btn {{ config('cookies-popup.custom_classes.btn') }}">{{ trans($translationsFile . '.cookies-popup-configure') }}</a>
            <a id="cookies-popup-accept" class="btn {{ config('cookies-popup.custom_classes.btn') }}">{{ trans($translationsFile . '.cookies-popup-accept') }}</a>
            <a id="cookies-popup-decline" class="btn {{ config('cookies-popup.custom_classes.btn') }}">{{ trans($translationsFile . '.cookies-popup-decline') }}</a>
        </div>

        <div id="cookies-popup-configuration" class="{{ config('cookies-popup.custom_classes.cookies_popup_configuration') }}">

            {{--required--}}
            <div>
                <div class="accept-cookies-checkbox">
                    <div class="accept-cookies-label {{ config('cookies-popup.custom_classes.accept_cookies_label') }}">{{ trans($translationsFile . '.accept-required-cookies-label') }}</div>
                    <div>
                        <label class="toggle-control">
                            <input type="checkbox" id="required-cookies" checked disabled>
                            <span class="control"></span>
                        </label>
                    </div>

                </div>
                <div class="accept-cookies-info {{ config('cookies-popup.custom_classes.accept_cookies_info') }}">
                    {{ trans($translationsFile . '.accept-required-cookies-info') }}
                </div>
            </div>

            {{--preferences--}}
            @if(config('cookies-popup.configure_preferences'))
                <div>
                    <div class="accept-cookies-checkbox">
                        <div class="accept-cookies-label {{ config('cookies-popup.custom_classes.accept_cookies_label') }}">{{ trans($translationsFile . '.accept-preferences-cookies-label') }}</div>
                        <div>
                            <label class="toggle-control">
                                <input type="checkbox" id="preferences-cookies" @if($preferencesCookies) checked @endif>
                                <span class="control"></span>
                            </label>
                        </div>

                    </div>
                    <div class="accept-cookies-info {{ config('cookies-popup.custom_classes.accept_cookies_info') }}">
                        {{ trans($translationsFile . '.accept-preferences-cookies-info') }}
                    </div>
                </div>
            @endif

            {{--analytical--}}
            @if(config('cookies-popup.configure_analytical'))
                <div>
                    <div class="accept-cookies-checkbox">
                        <div class="accept-cookies-label {{ config('cookies-popup.custom_classes.accept_cookies_label') }}">{{ trans($translationsFile . '.accept-analytical-cookies-label') }}</div>
                        <div>
                            <label class="toggle-control">
                                <input type="checkbox" id="analytical-cookies" @if($analyticalCookies) checked @endif>
                                <span class="control"></span>
                            </label>
                        </div>

                    </div>
                    <div class="accept-cookies-info {{ config('cookies-popup.custom_classes.accept_cookies_info') }}">
                        {{ trans($translationsFile . '.accept-analytical-cookies-info') }}
                    </div>
                </div>
            @endif

            {{--advertising--}}
            @if(config('cookies-popup.configure_advertising'))
                <div>
                    <div class="accept-cookies-checkbox">
                        <div class="accept-cookies-label {{ config('cookies-popup.custom_classes.accept_cookies_label') }}">{{ trans($translationsFile . '.accept-advertising-cookies-label') }}</div>
                        <div>
                            <label class="toggle-control">
                                <input type="checkbox" id="advertising-cookies" @if($advertisingCookies) checked @endif>
                                <span class="control"></span>
                            </label>
                        </div>

                    </div>
                    <div class="accept-cookies-info {{ config('cookies-popup.custom_classes.accept_cookies_info') }}">
                        {{ trans($translationsFile . '.accept-advertising-cookies-info') }}
                    </div>
                </div>
            @endif

            {{--recaptcha--}}
            @if(config('cookies-popup.configure_recaptcha'))
                <div>
                    <div class="accept-cookies-checkbox">
                        <div class="accept-cookies-label {{ config('cookies-popup.custom_classes.accept_cookies_label') }}">{{ trans($translationsFile . '.accept-recaptcha-cookies-label') }}</div>
                        <div>
                            <label class="toggle-control">
                                <input type="checkbox" id="recaptcha-cookies" @if($recaptchaCookies) checked @endif>
                                <span class="control"></span>
                            </label>
                        </div>

                    </div>
                    <div class="accept-cookies-info {{ config('cookies-popup.custom_classes.accept_cookies_info') }}">
                        {{ trans($translationsFile . '.accept-recaptcha-cookies-info') }}
                    </div>
                </div>
            @endif

            <div class="popup-buttons {{ config('cookies-popup.custom_classes.popup_buttons') }}">
                <a id="cookies-popup-close" class="btn {{ config('cookies-popup.custom_classes.btn') }} {{ config('cookies-popup.custom_classes.cookies_popup_close') }}">{{ trans($translationsFile . '.cookies-popup-close') }}</a>
            </div>

        </div>
    </div>
</div>

{{--Scripts--}}
<script>
    {!! $scripts !!}
</script>