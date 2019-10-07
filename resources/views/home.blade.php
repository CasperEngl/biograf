@extends('layouts.app')

@section('content')
<div class="py-32 border-b-2 border-gray-800" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $featured->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($featured->colors)->get(0) }};">
    <div class="container">
      <div class="row items-center justify-center md:justify-between">
        <div class="col flex-1">
          <div class="flex-1 md:max-w-xs lg:max-w-lg xl:max-w-3xl">
            <h1 class="text-6xl italic uppercase font-black mb-4 text-white text-center md:text-left">
              {{ $featured->title }}
            </h1>
            @if ($featured->genres->count())
            <div class="row-tight mb-4">
                @foreach ($featured->genres as $genre)
                <div class="col my-1">
                    <span class="tag">{{ $genre->name }}</span>
                </div>
                @endforeach
            </div>
            @endif
            <h3 class="max-w-3xl text-2xl mb-8 text-gray-200 leading-normal">
                {{ Str::limit($featured->overview, 150) }}
            </h3>
            <a class="btn btn-lg" href="{{ route('film.show', ['film' => $featured]) }}">
                {{ trans('film.read-more') }}
            </a>
          </div>
        </div>
        <div class="col md:w-1/2 max-w-md">
          <play-trailer video-key="{{ (new App\Actions\FilmActions)->trailerKey($featured) }}" title="{{ $featured->title }}" poster="{{ $featured->getFirstMediaUrl('poster', 'medium') }}" background="{{ optional($featured->colors)->get(0) }}" class="border-2 border-gray-800" style="border-color: {{ optional($featured->colors)->get(0) }};"></play-trailer>
        </div>
      </div>
    </div>
  </div>
<div class="container">
    <calendar-slider></calendar-slider>
</div>
<div class="container py-16">
    <div class="row">
        <div class="col w-full md:w-1/3 flex items-center">
            <div class="px-5">@svg('ud_awards')</div>
        </div>
        <div class="col w-full md:w-1/3 flex items-center">
            <div class="px-5">@svg('ud_horror_movie')</div>
        </div>
        <div class="col w-full md:w-1/3 flex items-center">
            <div class="px-5">@svg('ud_movie_night')</div>
        </div>
    </div>
</div>
@endsection