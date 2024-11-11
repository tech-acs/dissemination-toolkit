<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('images/favicon.svg', config('dissemination.secure'))}}" />
        <title>{{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @stack('styles')

        @stack('scripts')
    </head>
    <body class="antialiased min-h-screen">
        {{ $slot }}

        @stack('late-scripts')
    </body>
</html>
