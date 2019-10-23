@extends('layouts.app')

@section('content')
<div class="min-h-lg pt-64 pb-32"
  style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ asset('resources/img/showing-hero.jpg') }}') no-repeat center center; background-size: cover;">
  <div class="container">
    <h1 class="text-6xl italic uppercase font-black mb-4 text-white text-center md:text-left">
      {{ trans('showing.now_playing') }}
    </h1>
  </div>
</div>
<div class="mt-16 mb-64 container">
  <div class="row">
    <div class="col w-2/3">
      <film-showings :films="{{ json_encode($films) }}" date="{{ $date . ' 00:00:00' }}"></film-showings>
      <div class="row">
        @foreach ($films as $film)
          <div class="col w-1/3 mb-6">
            <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="overflow-hidden relative block">
              {{-- <div class="absolute inset-0 z-10 w-full" style="background: linear-gradient(transparent 70%, rgba(26, 32, 44, 1) 90%); pointer-events: none;"></div> --}}
              <figure class="relative aspect-ratio-16/9 mb-2 block">
                <img src="{{ $film->getFirstMediaUrl('backdrop', 'small') }}" onerror="this.src = '/img/placeholder/backdrop-small.png'" alt="{{ $film->title }}" class="absolute">
              </figure>
              <h3 class="text-2xl uppercase font-black">{{ Str::limit($film->title, 16) }}</h3>
            </a>
            @if (count($film->showings))
            <div class="row-tight">
              @foreach ($film->showings as $showing)
              <div class="col w-1/2">
                <a href="{{ route('showing.show', compact('date', 'showing')) }}" class="relative my-1 h-12 bg-gray-700 hover:bg-gray-800 group flex">
                  <p class="p-1 pl-4 w-full flex items-center">{{ getNearestTimeRoundedUpWithMinimum($showing->start, 5)->format('H:i') }}</p>
                  <span class="absolute inset-y-0 right-0 text-center block overflow-hidden flex items-center justify-center flex-no-wrap h-8 text-sm bg-orange-500 group-hover:bg-orange-400 p-px w-12" style="transform: rotate(90deg) translate(8px, -7px);">{{ $showing->cinema()->name }}</span>
                </a>
              </div>
              @endforeach
            </div>
            @else
            <p class="my-4">{{ trans('showing.none') }}</p>
            @endif
            <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="my-1 w-full btn btn-ghost border-gray-500">{{ trans('film.read_more') }}</a>
            <a href="{{ route('showing.days', ['slug' => $film->slug]) }}" class="my-1 w-full btn btn-ghost border-gray-500">{{ trans('showing.all_days') }}</a>
          </div>
        @endforeach
      </div>
    </div>
    <div class="col w-1/3 bg-gray-800">
      <div class="p-6">
        <h3 class="text-2xl uppercase font-black">{{ trans('showing.time') }}</h3>
      </div>
    </div>
  </div>
</div>
@endsection