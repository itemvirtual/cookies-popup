@if($firsMeasurementId)
    @if(config('cookies-popup.use-async-analytics-js'))
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