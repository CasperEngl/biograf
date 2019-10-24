<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    <script src="/js/lang.js"></script>
    @routes
</head>
<body class="bg-gray-900 text-white h-screen antialiased leading-none">
    <div id="app">
        <nav class="z-50 fixed w-full py-6" style="background: rgba(0,0,0,0.75);">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                            @svg('logo', 'inline-block h-10 w-10 mr-2')
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex-1 flex items-center justify-end">
                        <a href="{{ route('showing.pick') }}" class="p-3 border-t-2 border-b-2 border-red-600 hover:border-red-700 focus:bg-red-700 rounded-none uppercase font-bold">{{ trans('showing.pick') }}</a>
                        <a href="{{ route('film.pick') }}" class="p-3 border-t-2 border-b-2 border-red-600 hover:border-red-700 focus:bg-red-700 rounded-none uppercase font-bold">{{ trans('film.pick') }}</a>
                        @guest
                            <a class="no-underline hover:underline text-gray-300 text-sm font-bold uppercase p-3" href="{{ route('login') }}">{{ trans('auth.login') }}</a>
                            @if (Route::has('register'))
                                <a class="no-underline hover:underline text-gray-300 text-sm font-bold uppercase p-3" href="{{ route('register') }}">{{ trans('auth.register') }}</a>
                            @endif
                        @else
                            <span class="ml-2 p-2 text-gray-300 font-bold">{{ Auth::user()->name }}</span>

                            <a href="{{ route('logout') }}" class="p-2 text-gray-300 hover:text-white font-bold" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ trans('auth.logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>
        
        <footer class="py-16 min-h-md flex items-center" style="background: rgba(0,0,0,0.75);">
            <div class="container">
                <div class="row">
                    <div class="col w-full md:w-1/3">
                        <h3 class="mb-4 text-3xl uppercase font-black">{{ trans('footer.upcoming') }}</h3>
                        <nav>
                            @foreach (App\Film::where('categories', 'like', '%"upcoming"%')->latest()->take(5)->get() as $film)
                                <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="py-3 block text-xl hover:text-gray-300">{{ $film->title }}</a>
                            @endforeach
                        </nav>
                    </div>
                    <div class="col w-full md:w-1/3">
                        <h3 class="mb-4 text-3xl uppercase font-black">{{ trans('footer.now-playing') }}</h3>
                        <nav>
                            @foreach (App\Film::where('categories', 'like', '%"now-playing"%')->take(5)->get() as $film)
                                <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="py-3 block text-xl hover:text-gray-300">{{ $film->title }}</a>
                            @endforeach
                        </nav>
                    </div>
                    <div class="col w-full md:w-1/3">
                        <h3 class="mb-4 text-3xl uppercase font-black">{{ trans('footer.quicklinks') }}</h3>
                        <nav>
                            <a href="{{ route('register') }}" class="py-3 block text-xl hover:text-gray-300">{{ trans('auth.register') }}</a>
                            <a href="{{ route('login') }}" class="py-3 block text-xl hover:text-gray-300">{{ trans('auth.login') }}</a>
                            <a href="{{ route('showing.index', ['date' => now()->toDateString()]) }}" class="py-3 block text-xl hover:text-gray-300">{{ trans('showing.all') }}</a>
                            <a href="{{ route('film.index') }}" class="py-3 block text-xl hover:text-gray-300">{{ trans('film.all') }}</a>
                            <a href="https://www.themoviedb.org/" class="py-3 block text-xl hover:text-gray-300">themoviedb.org</a>
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
