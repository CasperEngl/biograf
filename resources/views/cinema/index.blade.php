@extends('layouts.app')

@section('content')
  <div class="container py-8">
    <div class="row py-8">
      <div class="col w-full">
        <cinema-maker></cinema-maker>
      </div>
    </div>
    <div class="row">
      @forelse ($cinemas as $cinema)
        <div class="col w-1/2 my-3">
          <div class="p-4 h-full border-2 border-gray-300 rounded">
            <h2 class="text-2xl mb-2">{{ $cinema->name }}</h2>
            <p class="text-gray-600 mb-2">{{ trans('cinema.seat.count') }} {{ count($cinema->seats) }}</p>
            <cinema-layout class="mb-4" cinema-name="{{ $cinema->name }}" :cinema-rows="{{ json_encode((new \App\Actions\CinemaActions)->rows($cinema)) }}"></cinema-layout>
            <a href="{{ route('cinema.edit', compact('cinema')) }}" class="btn btn-primary">{{ trans('cinema.edit') }}</a>
          </div>
        </div>
      @empty
        <div class="col w-full">
          <h1>{{ trans('cinema.nonefound') }}</h1>
        </div>
      @endforelse
    </div>
  </div>
@endsection