@extends('layouts.app')

@section('content')
<div class="min-h-lg flex items-center border-b-2 border-gray-800" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $film->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($film->colors)->get(0) }};">
  <div class="container">
    <div class="row items-center justify-center md:justify-between">
      <div class="col flex-1">
        <div class="flex-1 md:max-w-xs lg:max-w-lg xl:max-w-3xl">
          <h1 class="text-6xl italic uppercase font-black mb-4 text-white text-center md:text-left">
            {{ $film->title }}
          </h1>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- @if ($film->colors)    
  @foreach ($film->colors as $color)
  <div class="w-20 h-20" style="background: {{ $color }}"></div>
  @endforeach
@endif --}}
<div class="container mb-32">
  <div class="row my-16">
    <div class="col w-full md:w-1/2">
      <figure class="sticky" style="top: 6rem;">
        {{ $film->getFirstMedia('poster') }}
      </figure>
    </div>
    <div class="col w-full md:w-1/2">
      <h2 class="mb-8 text-3xl text-center uppercase font-bold">{{ trans('showing.days') }}</h2>
      @forelse ($showingDays as $date => $showings)
      <div class="p-10 my-8 bg-gray-800">
        <div class="row-tight">
          <div class="col w-full">
            <h3 class="mb-4 text-2xl text-center uppercase">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->isoFormat('dddd D. MMMM') }}</h3>
          </div>
          @foreach ($showings as $showing)
          <div class="col w-1/2 sm:w-1/3 my-1">
            <a href="{{ route('showing.show', compact('date', 'showing')) }}" class="relative my-1 h-12 flex bg-gray-700 hover:bg-gray-600">
              <p class="p-1 pl-4 w-full flex items-center">{{ getNearestTimeRoundedUpWithMinimum($showing->start, 5)->format('H:i') }}</p>
              <span class="absolute inset-y-0 right-0 p-px w-12 text-center block overflow-hidden flex items-center justify-center flex-no-wrap h-8 text-sm bg-orange-500" style="transform: rotate(90deg) translate(8px, -7px);">{{ $showing->cinema->name }}</span>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @empty
      <p class="text-xl">{{ trans('showing.next.none') }}</p>
      @endforelse
    </div>
  </div>
</div>
@endsection