@extends('layouts.app')

@section('content')
<section class="pt-64 pb-32 container max-w-3xl flex items-center justify-center tracking-wide leading-tight">
  <div class="row">
    <div class="col w-full">
      <h1 class="mb-8 text-4xl uppercase text-center font-black">{{ trans('reservation.update.title.default') }}</h1>
    </div>
    <div class="col w-1/2">
      <form class="h-full" action="{{ route('reservation.update.email.store', compact('reservation')) }}" method="POST">
        @csrf
        @method('POST')

        <div class="w-full h-full flex flex-col">
          <div class="main-content mb-2">
            <h2 class="text-2xl uppercase font-bold">{{ trans('reservation.update.title.with-email') }}</h2>
            <div class="my-3 w-full">
              <input-label for="email">{{ trans('reservation.update.email') }}</input-label>
              <input-field id="email" type="text" class="{{ $errors->has('email') ? ' border-red-500' : '' }}" name="email" :value="old('email')" required autofocus></input-field>
              <error-message key="email"></error-message>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">{{ trans('reservation.update.submit') }}</button>
        </div>
      </form>
    </div>
    <div class="col w-1/2">
      <form class="h-full" action="{{ route('reservation.update.email.store', compact('reservation')) }}" method="POST">
        @csrf
        @method('POST')

        <div class="w-full h-full flex flex-col">
          <div class="main-content mb-2">
            <h2 class="text-2xl uppercase font-bold">{{ trans('reservation.update.title.with-login') }}</h2>
            <div class="my-3 w-full">
              <input-label for="email">{{ trans('auth.login.only.email') }}</input-label>
              <input-field id="email" type="text" name="email" :value="old('email')" required autofocus></input-field>
              <error-message key="email"></error-message>
            </div>
            <div class="my-3 w-full">
              <input-label for="password">{{ trans('auth.login.password') }}</input-label>
              <input-field id="password" type="password" class="{{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required></input-field>
              <error-message key="password"></error-message>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">{{ trans('auth.login.submit') }}</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection