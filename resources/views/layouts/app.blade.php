<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <body>
        <div id="app">
            <nav class="bg-white shadow-sm">
                <div class="container mx-auto px-6 py-3">
                    <div class="flex justify-between items-center">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</a>
                        <div>
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
