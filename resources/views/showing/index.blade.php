@extends('layouts.app')

@section('content')
<div class="container py-32">
  <div class="row">
    @foreach ($films as $film)
      <div class="col w-1/4 my-3">
        <a href="{{ route('film.show', ['slug' => $film->slug]) }}" class="overflow-hidden relative py-3 block">
          {{-- <div class="absolute inset-0 z-10 w-full" style="background: linear-gradient(transparent 70%, rgba(26, 32, 44, 1) 90%); pointer-events: none;"></div> --}}
          <figure class="relative aspect-ratio-16/9 mb-2 block">
            <img src="{{ $film->getFirstMediaUrl('backdrop', 'small') }}" onerror="this.src = '/img/placeholder/backdrop-small.png'" alt="{{ $film->title }}" class="absolute">
          </figure>
          <h3 class="text-2xl uppercase font-black">{{ Str::limit($film->title, 18) }}</h3>
        </a>
        @if (count($film->showings))
          @foreach ($film->showings as $showing)
            <a href="{{ route('showing.show', compact('date', 'showing')) }}" class="relative my-1 h-12 bg-gray-700 flex justify-between">
              <p class="p-1 w-full flex items-center justify-center">{{ getNearestTimeRoundedUpWithMinimum($showing->start, 5)->format('H:i') }}</p>
              <span class="absolute inset-y-0 right-0 text-center block overflow-hidden flex items-center justify-center flex-no-wrap h-8 text-sm bg-orange-500 p-px w-12" style="transform: rotate(90deg) translate(8px, -7px);">{{ $showing->cinema->name }}</span>
            </a>
          @endforeach
        @else
          <p class="my-1">{{ trans('showing.none') }}</p>
        @endif
      </div>
    @endforeach
  </div>
</div>
@endsection