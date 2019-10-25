@extends('layouts.app')

@section('content')
<div class="container py-32">
    <div class="row py-6">
        <div class="col w-1/2">
            <h1 class="text-5xl mb-4 uppercase font-bold">{{ trans('auth.login.title') }}</h1>
            <h2 class="text-2xl text-gray-600">{{ trans('auth.login.subtitle') }}</h2>
        </div>
        <div class="col w-1/2">
            <form class="w-full" method="POST" action="{{ route('login') }}">
                @csrf
    
                <div class="row my-3">
                    <div class="col w-full">
                        <input-label for="email">{{ trans('auth.login.email') }}</input-label>
                        <input-field id="email" type="text" name="email" :value="old('email')" required autofocus></input-field>
                        <error-message key="email"></error-message>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col w-full">
                        <input-label for="password">{{ trans('auth.login.password') }}</input-label>
                        <input-field id="password" type="password" class="{{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required></input-field>
                        <error-message key="password"></error-message>
                    </div>
                </div>
    
                <div class="flex mb-6">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                    <label class="text-sm text-gray-700 ml-3" for="remember">
                        {{ trans('auth.login.remember') }}
                    </label>
                </div>
    
                <div class="flex flex-wrap items-center">
                    <button type="submit" class="btn btn-primary">{{ trans('auth.login.submit') }}</button>
    
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-500 hover:text-blue-700 whitespace-no-wrap no-underline ml-auto" href="{{ route('password.request') }}">
                            {{ trans('auth.login.forgot') }}
                        </a>
                    @endif
    
                    @if (Route::has('register'))
                        <p class="w-full text-xs text-center text-gray-700 mt-8 -mb-4">
                            {{ trans('auth.login.no-account') }}
                            <a class="text-blue-500 hover:text-blue-700 no-underline" href="{{ route('register') }}">
                                {{ trans('auth.login.register') }}
                            </a>
                        </p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
