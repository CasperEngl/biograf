<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @routes
</head>
<body class="bg-gray-900 text-white h-screen antialiased leading-none">
    <div id="app">
        <nav class="z-50 fixed w-full py-6" style="background: rgba(0,0,0,0.75);">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                            @svg('logo', 'inline-block max-h-12')
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex-1 text-right">
                        @guest
                            <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('login') }}">{{ trans('auth.login') }}</a>
                            @if (Route::has('register'))
                                <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('register') }}">{{ trans('auth.register') }}</a>
                            @endif
                        @else
                            <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }}</span>

                            <a href="{{ route('logout') }}"
                               class="no-underline hover:underline text-gray-300 text-sm p-3"
                               onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ trans('auth.logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
        
        <footer class="py-16 min-h-md flex items-center" style="background: rgba(0,0,0,0.75);">
            <div class="container">
                <h2 class="mb-8 text-6xl uppercase text-center font-black">{{ config('app.name') }}</h2>
                <div class="row items-center">
                    <div class="col w-full md:w-1/3">
                        <nav>
                            <a href="{{ route('showing.index', ['date' => now()->toDateString()]) }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('showing.all') }}</a>
                            <a href="{{ route('film.index') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('film.all') }}</a>
                            <a href="{{ route('register') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('auth.register') }}</a>
                            <a href="{{ route('login') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('auth.login') }}</a>
                        </nav>
                    </div>
                    <div class="col w-full md:w-1/3">
                        <nav>
                            <a href="{{ route('showing.index', ['date' => now()->toDateString()]) }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('showing.all') }}</a>
                            <a href="{{ route('film.index') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('film.all') }}</a>
                            <a href="{{ route('register') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('auth.register') }}</a>
                            <a href="{{ route('login') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('auth.login') }}</a>
                        </nav>
                    </div>
                    <div class="col w-full md:w-1/3">
                        <nav>
                            <a href="{{ route('showing.index', ['date' => now()->toDateString()]) }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('showing.all') }}</a>
                            <a href="{{ route('film.index') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('film.all') }}</a>
                            <a href="{{ route('register') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('auth.register') }}</a>
                            <a href="{{ route('login') }}" class="py-3 block text-xl hover:text-gray-300"><i class="fa fa-caret-right pr-2"></i>{{ trans('auth.login') }}</a>
                        </nav>
                    </div>
                    <div class="col w-full flex justify-center">
                        @svg('ud_movie_night', 'w-64 text-red-700')
                    </div>
                </div>
            </div>
        </footer>

        <div class="fixed flex flex-col" style="bottom: 2rem; left: 2rem;">
            @include('partials.status-boxes')
        </div>

        <portal-target name="modal"></portal-target>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
