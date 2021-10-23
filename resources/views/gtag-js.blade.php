@if($firsMeasurementId)
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $firsMeasurementId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){window.dataLayer.push(arguments);}
        gtag('js', new Date());

        @if(config('cookies-popup.google-consent-mode'))
            gtag('consent', 'default', {
                'ad_storage': '{{ Cookie::get('advertising_cookies') == 'true' ? 'granted' : 'denied' }}',
                'analytics_storage': '{{ Cookie::get('analytical_cookies') == 'true' ? 'granted' : 'denied' }}'
            });
        @endif

        @foreach($measurementIds AS $measurementId)
            gtag('config', '{{ $measurementId }}');
        @endforeach

    </script>
@else
    <!-- ***** No se ha definido la id de Google Analytics ***** -->
@endif