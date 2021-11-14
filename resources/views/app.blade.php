<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @if(env('APP_ENV') === 'production')
        <script>
            // Check that service workers are supported
            if ('serviceWorker' in navigator) {
            // Use the window load event to keep the page load performant
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/service-worker.js');
                });
            }
        </script>
        <link rel="manifest" href="/manifest.webmanifest">
        @endif

        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

        
    </head>
    <body class="font-sans antialiased">
        @inertia
        <script>
            window._locale = '{{ app()->getLocale() }}';
            window._translations = {!! cache('translations') !!};
        </script>

        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
