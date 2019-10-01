@extends('layouts.app')

@section('content')
<div class="container py-32">
    <div class="row py-6">
        <div class="col w-1/2">
            <h1 class="text-5xl mb-4 uppercase font-bold">{{ trans('auth.register.title') }}</h1>
            <h2 class="text-2xl text-gray-600">{{ trans('auth.login.subtitle') }}</h2>
        </div>
        <div class="col w-1/2">
            <form class="w-full" method="POST" action="{{ route('register') }}">
                @csrf
    
                <div class="row my-3">
                    <div class="col w-1/2">
                        <input-label for="firstname">{{ trans('auth.register.firstname') }}</input-label>
                        <input-field id="firstname" type="text" class="{{ $errors->has('firstname') ? ' border-red-500' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus></input-field>
    
                        <error-message key="firstname"></error-message>
                    </div>
                    <div class="col w-1/2">
                        <input-label for="lastname">{{ trans('auth.register.lastname') }}</input-label>
                        <input-field id="lastname" type="text" class="{{ $errors->has('lastname') ? ' border-red-500' : '' }}" name="lastname" value="{{ old('lastname') }}" required autofocus></input-field>
    
                        <error-message key="lastname"></error-message>
                    </div>
                </div>
    
                <div class="row my-3">
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
    
                <div class="row my-3">
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
    
                <div class="row my-3">
                    <div class="col w-full">
                        <button type="submit" class="btn btn-primary">{{ trans('auth.register.submit') }}</button>
    
                        <p class="w-full text-xs text-center text-gray-700 mt-8 -mb-4">
                            {{ trans('auth.register.already-registered') }}
                            <a class="text-blue-500 hover:text-blue-700 no-underline" href="{{ route('login') }}">{{ trans('auth.register.login') }}</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
