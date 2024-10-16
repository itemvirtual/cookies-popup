@if($firstMeasurementId)
    @if(config('cookies-popup.use_async_analytics_js'))
        <!-- Google Analytics -->
        <script>
            window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
            @foreach($measurementIds AS $measurementId)
            ga('create', '{{ $measurementId }}', 'auto');
            @endforeach
            ga('send', 'pageview');
        </script>
        <script async src='https://www.google-analytics.com/analytics.js'></script>
    @else
        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            @foreach($measurementIds AS $measurementId)
            ga('create', '{{ $measurementId }}', 'auto');
            @endforeach

            ga('send', 'pageview');
        </script>
    @endif
@else
    <!-- ***** No se ha definido la id de Google Analytics ***** -->
@endif

{{--Create or update function for each consent parameter--}}
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
            @if($firstMeasurementId)
            gtag('consent', 'update', {
                'ad_storage': value
            });
            @endif
        }

        function setConsentForAdUserData(value) {
            @if($firstMeasurementId)
            gtag('consent', 'update', {
                'ad_user_data': value
            });
            @endif
        }

        function setConsentForAdPersonalization(value) {
            @if($firstMeasurementId)
            gtag('consent', 'update', {
                'ad_personalization': value
            });
            @endif
        }

        function setConsentForAnalyticsStorage(value) {
            @if($firstMeasurementId)
            gtag('consent', 'update', {
                'analytics_storage': value
            });
            @endif
        }
    </script>
@else
    <script>
        function setAnalyticalConsent(value) {
            return true;
        }

        function setAdvertisingConsent(value) {
            return true;
        }
    </script>
@endif