@extends('layouts.app')

@section('content')
<div class="pt-48 pb-32 border-b-2 border-gray-800" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $film->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($film->colors)->get(0) }};">
    <div class="container">
        <h1 class="text-6xl italic uppercase font-black mb-4 text-white text-center md:text-left">
            {{ trans('profile.title') }}
        </h1>
    </div>
</div>
<section class="py-32 container">
    <div class="row">
        <div class="col w-full md:w-1/2">
            <form action="{{ route('profile.store') }}" method="POST" class="mb-4 p-10 rounded bg-gray-800">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="my-3 col w-full md:w-1/2">
                        <input-label for="firstname">{{ trans('profile.firstname') }}</input-label>
                        <input-field id="firstname" type="text" :class="$errors->has('firstname') ? ' border-red-500' : ''" name="firstname" :value="old('firstname', auth()->user()->firstname)"></input-field>
                        <error-message key="firstname"></error-message>
                    </div>
                    <div class="my-3 col w-full md:w-1/2">
                        <input-label for="lastname">{{ trans('profile.lastname') }}</input-label>
                        <input-field id="lastname" type="text" :class="$errors->has('lastname') ? ' border-red-500' : ''" name="lastname" :value="old('lastname', auth()->user()->lastname)"></input-field>
                        <error-message key="lastname"></error-message>
                    </div>
                </div>
                <div class="row">
                    <div class="my-3 col w-full">
                        <input-label for="">{{ trans('profile.email') }}</input-label>
                        <input-field id="email" type="email" :class="$errors->has('email') ? ' border-red-500' : ''" name="email" :value="old('email', auth()->user()->email)"></input-field>
                        <error-message key="email"></error-message>
                    </div>
                    <div class="my-3 col w-full">
                        <input-label for="">{{ trans('profile.phonenumber') }}</input-label>
                        <input-field id="phonenumber" type="tel" :class="$errors->has('phonenumber') ? ' border-red-500' : ''" name="phonenumber" :value="old('phonenumber', auth()->user()->phonenumber)"></input-field>
                        <error-message key="phonenumber"></error-message>
                    </div>
                </div>

                <button type="submit" class="mt-6 btn btn-primary">{{ trans('profile.save') }}</button>
            </form>
            <form action="{{ route('profile.password') }}" method="POST" class="mb-4 p-10 rounded bg-gray-800">
                @csrf
                @method('POST')

                <div class="row">
                    <div class="my-3 col w-full md:w-1/2">
                        <input-label for="old_password">{{ trans('profile.password.old') }}</input-label>
                        <input-field id="old_password" type="password" class-name="{{ $errors->has('old_password') ? ' border-red-500' : '' }}" name="old_password" required></input-field>
        
                        <error-message key="old_password"></error-message>
                    </div>
                </div>
                <div class="row">
                    <div class="my-3 col w-full md:w-1/2">
                        <input-label for="password">{{ trans('profile.password.default') }}</input-label>
                        <input-field id="password" type="password" class-name="{{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required></input-field>
        
                        <error-message key="password"></error-message>
                    </div>
                    <div class="my-3 col w-full md:w-1/2">
                        <input-label for="password-confirm">{{ trans('profile.password.confirm') }}</input-label>
                        <input-field id="password-confirm" type="password" name="password_confirmation" required></input-field>
                    </div>
                </div>

                <button type="submit" class="mt-6 btn btn-primary">{{ trans('profile.password.save') }}</button>
            </form>
        </div>
        <div class="col w-full md:w-1/2">
            @foreach ((new \App\Actions\ReservationActions)->reservations(auth()->user()) as $reservation)
            <div class="p-5 rounded bg-gray-800">
                <h3 class="mb-2 text-3xl uppercase font-black">{{ $reservation->film->title }}</h3>
                <p class="text-xl text-gray-300 uppercase leading-normal">{{ $reservation->showing->end->isPast() ? $reservation->showing->end->isoFormat('dddd DD. MMM') : $reservation->showing->start->isoFormat('dddd DD. MMM hh:mm') }}</p>
                <p class="mb-4 text-xl text-gray-300 uppercase leading-normal">{{ trans('reservation.price') }} {{ $reservation->getPaymentAmount() / 100 }},-</p>
                <h4 class="text-3xl uppercase font-black text-gray-600 tracking-wider">Status <span class="text-white">{{ trans('reservation.status.' . $reservation->status) }}</span></h4>

            </div>
                
            @endforeach
        </div>
    </div>
</section>
@endsection