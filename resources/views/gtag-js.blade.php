@if($firstMeasurementId)
    @if(config('cookies-popup.google_consent_mode'))
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        
        gtag('consent', 'default', {
            'ad_storage': 'denied',
            'ad_user_data': 'denied',
            'ad_personalization': 'denied',
            'analytics_storage': 'denied'
        });
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