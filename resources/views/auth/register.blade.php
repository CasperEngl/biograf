@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-5xl uppercase font-bold">{{ trans('auth.register.title') }}</h1>

        <form class="w-full p-6" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row">
                <div class="col w-1/2">
                    <input-label for="first_name">{{ trans('auth.register.first_name') }}</input-label>
                    <input-field id="first_name" type="text" class="{{ $errors->has('first_name') ? ' border-red-500' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus></input-field>

                    <error-message key="first_name"></error-message>
                </div>
                <div class="col w-1/2">
                    <input-label for="last_name">{{ trans('auth.register.last_name') }}</input-label>
                    <input-field id="last_name" type="text" class="{{ $errors->has('last_name') ? ' border-red-500' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus></input-field>

                    <error-message key="last_name"></error-message>
                </div>
            <div>

            <div class="row">
                <div class="col w-1/2">
                    <input-label for="email">{{ trans('auth.register.email') }}</input-label>
                    <input-field id="email" type="email" class="{{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" value="{{ old('email') }}" required></input-field>

                    <error-message key="email"></error-message>
                </div>
                <div class="col w-1/2">
                    <input-label for="phonenumber">{{ trans('auth.register.phonenumber') }}</input-label>
                    <input-field id="phonenumber" type="tel" class="{{ $errors->has('phonenumber') ? ' border-red-500' : '' }}" name="phonenumber" value="{{ old('phonenumber') }}" required></input-field>

                    <error-message key="phonenumber"></error-message>
                </div>
            </div>

            <div class="row">
                <div class="col w-1/2">
                    <input-label for="password">{{ trans('auth.register.password') }}</input-label>
                    <input-field id="password" type="password" class-name="{{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required></input-field>
    
                    <error-message key="password"></error-message>
                </div>
                <div class="col w-1/2">
                    <input-label for="password-confirm">{{ trans('auth.register.password.confirm') }}</input-label>
                    <input-field id="password-confirm" type="password" name="password_confirmation" required></input-field>
                </div>
            </div>

            <div class="row">
                <div class="col w-full">
                    <submit-button>{{ trans('auth.register.submit') }}</submit-button>

                    <p class="w-full text-xs text-center text-gray-700 mt-8 -mb-4">
                        {{ trans('auth.register.already-registered') }}
                        <a class="text-blue-500 hover:text-blue-700 no-underline" href="{{ route('login') }}">{{ trans('auth.register.login') }}</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection
