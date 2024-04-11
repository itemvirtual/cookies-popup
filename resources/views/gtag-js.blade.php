@if($firstMeasurementId)
    @if(config('cookies-popup.google_consent_mode'))
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}

        gtag('consent', 'default', {
            'ad_storage': '{{ Cookie::get('advertising_cookies') == 'true' ? 'granted' : 'denied' }}',
            'ad_user_data': '{{ Cookie::get('advertising_cookies') == 'true' ? 'granted' : 'denied' }}',
            'ad_personalization': '{{ Cookie::get('advertising_cookies') == 'true' ? 'granted' : 'denied' }}',

            'analytics_storage': '{{ Cookie::get('analytical_cookies') == 'true' ? 'granted' : 'denied' }}',

            'functionality_storage': '{{ Cookie::get('preferences_cookies') == 'true' ? 'granted' : 'denied' }}',
            'personalization': '{{ Cookie::get('preferences_cookies') == 'true' ? 'granted' : 'denied' }}',
            'personalization_storage': '{{ Cookie::get('preferences_cookies') == 'true' ? 'granted' : 'denied' }}',

            'security_storage': '{{ Cookie::get('recaptcha_cookies') == 'true' ? 'granted' : 'denied' }}',

            'wait_for_update': '{{ config('cookies-popup.google_wait_for_update', 2000) }}',

        });

        @if(config('cookies-popup.google_url_passthrough'))
        gtag('set', 'url_passthrough', true);
        @endif

    </script>
    @endif


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $firstMeasurementId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){window.dataLayer.push(arguments);}
        gtag('js', new Date());

        @foreach($measurementIds AS $measurementId)
            gtag('config', '{{ $measurementId }}');
        @endforeach

    </script>
@else
    <!-- ***** No se ha definido la id de Google Analytics ***** -->
@endif

{{--Create one update function for each consent parameter--}}
@if(config('cookies-popup.google_consent_mode'))
    <script>
        function setAnalyticalConsent(value) {
            setConsentForAnalyticsStorage(value);
        }
        function setAdvertisingConsent(value) {
            setConsentForAdStorage(value);
            setConsentForAdUserData(value);
            setConsentForAdPersonalization(value);
        }

        /** ************************************ */

        function setConsentForAdStorage(value) {
            gtag('consent', 'update', {
                'ad_storage': value
            });
        }
        function setConsentForAdUserData(value) {
            gtag('consent', 'update', {
                'ad_user_data': value
            });
        }
        function setConsentForAdPersonalization(value) {
            gtag('consent', 'update', {
                'ad_personalization': value
            });
        }
        function setConsentForAnalyticsStorage(value) {
            gtag('consent', 'update', {
                'analytics_storage': value
            });
        }
    </script>
@endif