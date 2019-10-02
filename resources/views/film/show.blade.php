@extends('layouts.app')

@section('content')
<div class="py-32 border-b-2 border-gray-800" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $film->getFirstMediaUrl('backdrop') }}') no-repeat center center; background-size: cover; border-color: {{ $film->colors->get(0) }};">
  <div class="container">
    <div class="row items-center justify-center md:justify-between">
      <div class="col flex-1">
        <div class="flex-1 md:max-w-xs lg:max-w-lg xl:max-w-3xl">
          <h1 class="text-6xl italic uppercase font-black mb-4 text-white text-center md:text-left">
            {{ $film->title }}
          </h1>
        </div>
      </div>
      <div class="col md:w-1/2 max-w-md">
        <play-trailer video-key="{{ (new FilmActions)->trailerKey($film) }}" title="{{ $film->title }}" poster="{{ $film->getFirstMediaUrl('poster') }}" class="border-2 border-gray-800" style="border-color: {{ $film->colors->get(0) }};"></play-trailer>
      </div>
    </div>
  </div>
</div>
{{-- @if ($film->colors)    
  @foreach ($film->colors as $color)
  <div class="w-20 h-20" style="background: {{ $color }}"></div>
  @endforeach
@endif --}}
<div class="container">
  <div class="mt-48 md:-mt-32">
    <div class="row">
      <div class="col flex-1">
        <div class="p-10 bg-gray-800 shadow-lg">
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.premiere') }}</h3>
            <h3 class="text-xl text-white">{{ $film->title }}</h3>
          </div>
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.director') }}</h3>
            <h3 class="text-xl text-white">{{ $film->title }}</h3>
            
          </div>
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.genre') }}</h3>
            @if ($film->genres->count())
            <div class="row-tight">
                @foreach ($film->genres as $genre)
                <div class="col my-1">
                    <span class="tag">{{ $genre->name }}</span>
                </div>
                @endforeach
            </div>
            @endif
          </div>
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.cast') }}</h3>
            @if ($film->casts->count())
            <div class="row">
                @foreach ($film->casts->take(4) as $cast)
                <div class="col my-1 inline-flex flex-col items-center">
                    <figure class="mb-1">
                      <img src="{{ $cast->getFirstMediaUrl('profile', 'thumb') }}" alt="{{ $cast->name }}" class="rounded-full border-2 border-gray-800">
                    </figure>
                    <h4 class="mb-2 text-gray-400 font-black">{{ $cast->name }}</h4>
                    <h5 class="text-gray-400">{{ $cast->character }}</h5>
                </div>
                @endforeach
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="mt-25 col md:w-1/2 max-w-md inline-flex justify-between items-start">
        <div class="row-tight">
          <div class="col w-1/2">
            @if (App\Film::where('id', '<', $film->id)->max('id'))
              <a href="{{ route('film.show', ['film' => App\Film::where('id', '<', $film->id)->max('id')]) }}" class="w-full btn btn-primary btn-lg text-center" style="background: {{ $film->colors->get(0) }}; color: {{ $film->colors->get(2) }};">{{ trans('film.previous') }}</a>
            @else
              <div></div>
            @endif
          </div>
          <div class="col w-1/2">
            @if (App\Film::where('id', '>', $film->id)->min('id'))
              <a href="{{ route('film.show', ['film' => App\Film::where('id', '>', $film->id)->min('id')]) }}" class="w-full btn btn-primary btn-lg text-center" style="background: {{ $film->colors->get(0) }}; color: {{ $film->colors->get(2) }};">{{ trans('film.next') }}</a>
            @else
              <div></div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container mt-8 md:mt-24 mb-64">
  <div class="p-10 bg-gray-800 shadow-lg">
    <h2 class="mb-4 text-3xl uppercase font-black text-gray-500">{{ trans('film.overview') }}</h2>
    <p class="text-2xl text-gray-200 leading-normal">{{ $film->overview }}</p>
  </div>
</div>
@endsection