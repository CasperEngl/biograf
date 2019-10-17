@extends('layouts.app')

@section('content')
<div class="py-32 border-b-2 border-gray-800"
  style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $featured->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($featured->colors)->get(0) }};">
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
          <a class="btn btn-lg" href="{{ route('film.show', ['slug' => $featured->slug]) }}">
            {{ trans('film.read_more') }}
          </a>
        </div>
      </div>
      <div class="col md:w-1/2 max-w-md">
        <play-trailer video-key="{{ (new App\Actions\FilmActions)->trailerKey($featured) }}"
          title="{{ $featured->title }}" poster="{{ $featured->getFirstMediaUrl('poster', 'medium') }}"
          background="{{ optional($featured->colors)->get(0) }}" class="border-2 border-gray-800"
          style="border-color: {{ optional($featured->colors)->get(0) }};"></play-trailer>
      </div>
    </div>
  </div>
</div>
<div class="container my-16">
  <h2 class="mb-4 text-4xl uppercase font-black text-white text-center">{{ trans('home.dates') }}</h2>
  <div class="row-tight">
    @foreach ($dates as $date)
    <div class="col w-1/2 sm:w-1/3 md:w-1/6 my-1">
      <a href="{{ route('showing.index', ['date' => $date->toDateString()]) }}"
        class="btn btn-ghost h-full w-full inline-flex flex-col items-center text-center">
        <div class="text-sm">{{ $date->format('D') }}</div>
        <div class="text-3xl my-2">{{ $date->format('m-d') }}</div>
        <div class="text-sm">{{ $date->format('M') }}</div>
      </a>
    </div>
    @endforeach
  </div>
</div>
<div class="container my-16 mb-64">
  <div class="row-tight">
    <div class="relative col w-full md:w-2/3 min-h-xs flex items-center">
      <div class="absolute w-full h-full" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $films->get(0)->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover;"></div>
      <div class="relative p-10">
        <h4 class="mb-6 max-w-md text-4xl uppercase font-black">{{ $films->get(0)->title }}</h4>
        <a href="{{ route('film.show', ['slug' => $films->get(0)->slug]) }}" class="btn btn-ghost">{{ trans('film.read_more') }}</a>
      </div>
    </div>
    <div class="relative col w-full md:w-1/3 min-h-xs flex items-center">
      <div class="absolute w-full h-full" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $films->get(1)->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover;"></div>
      <div class="relative p-10">
        <h4 class="mb-6 max-w-md text-4xl uppercase font-black">{{ $films->get(1)->title }}</h4>
        <a href="{{ route('film.show', ['slug' => $films->get(1)->slug]) }}" class="btn btn-ghost">{{ trans('film.read_more') }}</a>
      </div>
    </div>
  </div>
  <div class="row-tight">
    <div class="relative col w-full md:w-1/3 min-h-xs flex items-center">
      <div class="absolute w-full h-full" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $films->get(2)->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover;"></div>
      <div class="relative p-10">
        <h4 class="mb-6 max-w-md text-4xl uppercase font-black">{{ $films->get(2)->title }}</h4>
        <a href="{{ route('film.show', ['slug' => $films->get(2)->slug]) }}" class="btn btn-ghost">{{ trans('film.read_more') }}</a>
      </div>
    </div>
    <div class="relative col w-full md:w-1/3 min-h-xs flex items-center">
      <div class="absolute w-full h-full" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $films->get(3)->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover;"></div>
      <div class="relative p-10">
        <h4 class="mb-6 max-w-md text-4xl uppercase font-black">{{ $films->get(3)->title }}</h4>
        <a href="{{ route('film.show', ['slug' => $films->get(3)->slug]) }}" class="btn btn-ghost">{{ trans('film.read_more') }}</a>
      </div>
    </div>
    <div class="relative col w-full md:w-1/3 min-h-xs flex items-center">
      <div class="absolute w-full h-full" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $films->get(4)->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover;"></div>
      <div class="relative p-10">
        <h4 class="mb-6 max-w-md text-4xl uppercase font-black">{{ $films->get(4)->title }}</h4>
        <a href="{{ route('film.show', ['slug' => $films->get(4)->slug]) }}" class="btn btn-ghost">{{ trans('film.read_more') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection