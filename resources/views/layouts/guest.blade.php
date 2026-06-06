<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @php
            $favicon = $siteBranding['favicon'] ?? '/images/favicon.png';
        @endphp
        <link rel="icon" href="{{ $favicon }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            :root {
                --primary: {{ $siteBranding['primary_color_hex'] ?? $siteBranding['primary_color'] ?? '#F53003' }};
                --primary-dark: {{ $siteBranding['primary_color_dark'] ?? $siteBranding['primary_color'] ?? '#D42000' }};
                --primary-light: {{ $siteBranding['primary_color_light'] ?? $siteBranding['primary_color'] ?? '#FF6B4A' }};
                --primary-glow: {{ $siteBranding['primary_color_glow'] ?? 'rgba(245, 48, 3, 0.2)' }};
                --secondary: {{ $siteBranding['secondary_color_hex'] ?? $siteBranding['secondary_color'] ?? '#1B1B18' }};
                --secondary-light: {{ $siteBranding['secondary_color_light'] ?? $siteBranding['secondary_color'] ?? '#2A2A27' }};
                --accent: {{ $siteBranding['accent_color_hex'] ?? $siteBranding['accent_color'] ?? '#F8B803' }};
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    @php
                        $logo = $siteBranding['logo_light'] ?? $siteBranding['logo'] ?? null;
                    @endphp
                    @if($logo)
                        <img src="{{ $logo }}" alt="{{ config('app.name') }}" class="w-20 h-20" />
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    @endif
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
