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
                --bg-light: #F8FAFC;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @hasSection('hideDefaultNavigation')
            @else
                @include('layouts.navigation')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
