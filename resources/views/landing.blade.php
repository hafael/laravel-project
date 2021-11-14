<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- CSS
        ================================================== -->
        <link rel="stylesheet" href="{{ asset('css/base.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <!-- script
        ================================================== -->
        @routes
        <script src="{{ asset('js/modernizr.js') }}"></script>
        <script src="{{ asset('js/pace.min.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>

        <!-- favicons
        ================================================== -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        
    </head>
    <body id="top">
        @inertia

        <!-- Java Script
        ================================================== -->
        <script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>

        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
