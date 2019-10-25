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
        <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6 fixed w-full top-0 print:hidden" style="background: rgba(0,0,0,0.75);">
            <div class="flex-1 flex items-center flex-shrink-0 text-white mr-6">
                <a href="{{ url('/') }}" class="text-white no-underline hover:text-white hover:no-underline" href="#">
                    <span class="text-2xl pl-2">
                        @svg('logo', 'inline-block h-10 w-10 mr-2')
                        {{ config('app.name', 'Laravel') }}
                    </span>
                </a>
            </div>
    
            <div class="block md:hidden">
                <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-white hover:border-white">
                    @svg('burger', 'h-6 w-6')
                </button>
            </div>

            @auth
                <v-popover placement="left-start" offset="8" v-cloak popover-class="menu-dropdown" trigger="hover click focus" class="lg:order-last">
                    <figure class="cursor-pointer inline-block text-gray-600 no-underline hover:text-gray-200 hover:text-underline pl-4">
                        <img src="{{ auth()->user()->getFirstMediaUrl('profile', 'tiny-thumb') }}" alt="{{ auth()->user()->name }}" class="max-w-12 max-h-12">
                    </figure>
                    <span slot="popover">
                        <ul class="overflow-hidden rounded bg-white text-gray-700">
                            <a href="{{ route('profile.index') }}" class="p-3 flex items-center">
                                @svg('kontrolpanel-icon')
                                <div class="px-3">
                                    <strong class="font-semibold mt-px">Dit kontrolpanel</strong>
                                    <p class="text-sm text-grey-darker font-normal mt-1 flex">Få et overblik over din konto</p>
                                </div>
                                @svg('enter-icon', 'ml-3')
                            </a>
                            <a href="{{ route('profile.index') }}" class="p-3 flex items-center">
                                @svg('konto-icon')
                                <div class="px-3">
                                    <strong class="font-semibold mt-px">Rediger konto</strong>
                                    <p class="text-sm text-gray-700 font-normal mt-1 flex">Ret dine kontoinformationer</p>
                                </div>
                                @svg('enter-icon', 'ml-3')
                            </a>
                            <a href="{{ route('logout') }}" class="py-3 w-full flex items-center justify-center bg-gray-200 hover:bg-gray-300" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ trans('auth.logout.default') }} @svg('enter-icon', 'ml-2')
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </span>
                </v-popover>
            @endauth
    
            <div class="w-full flex-grow md:flex md:items-center md:w-auto hidden md:block pt-6 md:pt-0" id="nav-content">
                <ul class="list-reset md:flex justify-end flex-1 items-center">
                    <li class="mx-1">
                        <a class="inline-block text-gray-600 no-underline hover:text-gray-200 hover:text-underline py-2 px-4" href="{{ route('showing.pick') }}">{{ trans('showing.pick') }}</a>
                    </li>
                    <li class="mx-1">
                        <a class="inline-block text-gray-600 no-underline hover:text-gray-200 hover:text-underline py-2 px-4" href="{{ route('film.pick') }}">{{ trans('film.pick') }}</a>
                    </li>
                    @guest
                        <li class="mx-1">
                            <a class="inline-block text-gray-600 no-underline hover:text-gray-200 hover:text-underline py-2 px-4" href="{{ route('login') }}">{{ trans('auth.login.default') }}</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>
        
        <footer class="py-16 min-h-md flex items-center print:hidden" style="background: rgba(0,0,0,0.75);">
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
                            <a href="{{ route('register') }}" class="py-3 block text-xl hover:text-gray-300">{{ trans('auth.register.default') }}</a>
                            <a href="{{ route('login') }}" class="py-3 block text-xl hover:text-gray-300">{{ trans('auth.login.default') }}</a>
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

    <script>
        document.getElementById('nav-toggle').onclick = function(){
            document.getElementById("nav-content").classList.toggle("hidden");
        }
    </script>

    @stack('scripts')
</body>
</html>
