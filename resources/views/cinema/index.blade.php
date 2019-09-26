@extends('layouts.app')

@section('content')
  <div class="container py-8">
    <div class="row">
      @forelse ($cinemas as $cinema)
        <div class="col w-1/2">
          <div class="p-4 shadow rounded">
            <h2 class="text-2xl mb-2">{{ $cinema->name }}</h2>
            <p class="text-gray-600 mb-2">{{ trans('cinema.seat.count') }} {{ count($cinema->seats) }}</p>
            <cinema-layout class="mb-4" :cinema-rows="{{ json_encode($cinema->rows()) }}"></cinema-layout>
            <a href="{{ route('cinema.edit', ['cinema' => $cinema]) }}" class="btn btn-primary">{{ trans('cinema.edit') }}</a>
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