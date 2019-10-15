@extends('layouts.app')

@section('content')
<div class="py-32 border-b-2 border-gray-800" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $film->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($film->colors)->get(0) }};">
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
        <play-trailer video-key="{{ (new App\Actions\FilmActions)->trailerKey($film) }}" title="{{ $film->title }}" poster="{{ $film->getFirstMediaUrl('poster', 'medium') }}" background="{{ optional($film->colors)->get(0) }}" class="border-2 border-gray-800 rounded" style="border-color: {{ optional($film->colors)->get(0) }};"></play-trailer>
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
  <div class="-mt-24">
    <div class="row flex-col-reverse md:flex-row">
      <div class="col flex-1">
        <div class="p-10 bg-gray-800 shadow-lg h-full rounded">
          <h2 class="mb-4 text-3xl uppercase font-black text-gray-500">{{ trans('film.overview') }}</h2>
          <p class="text-2xl text-gray-200 leading-normal">{{ $film->overview }}</p>
          @if ($film->premiere)
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.premiere') }}</h3>
            <h3 class="text-xl text-white">{{ $film->premiere->toFormattedDateString() }}</h3>
          </div>
          @endif
          @if ($film->genres->count())
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.genre') }}</h3>
            <div class="row-tight">
              @foreach ($film->genres as $genre)
              <div class="col my-1">
                <span class="tag">{{ $genre->name }}</span>
              </div>
              @endforeach
            </div>
          </div>
          @endif
          @if ($film->casts->count())
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.cast') }}</h3>
            <div class="row">
                @foreach ($film->casts->take(4) as $cast)
                <a href="{{ $cast->contributor->tmdbLink }}" class="col my-1 inline-flex flex-col items-center">
                  <figure class="mb-1">
                    <img src="{{ $cast->getFirstMediaUrl('profile', 'thumb') }}" onerror="this.src='{{ Avatar::create($cast->contributor->name)->toBase64() }}'" alt="{{ $cast->contributor->name }}" class="rounded-full border-2 border-gray-800">
                  </figure>
                  <h4 class="mb-2 text-gray-400 font-black">{{ $cast->contributor->name }}</h4>
                  <h5 class="text-gray-400">{{ $cast->character }}</h5>
                </a>
                @endforeach
            </div>
          </div>
          @endif
          @if ($film->crews->where('job', 'Director')->count())
          <div class="my-5">
            <h3 class="mb-2 text-2xl uppercase font-black text-gray-500">{{ trans('film.director') }}</h3>
            <div class="row">
                @foreach ($film->crews->where('job', 'Director')->take(4) as $director)
                <a href="{{ $director->contributor->tmdbLink }}" class="col my-1 inline-flex flex-col items-center">
                    <figure class="mb-1">
                      <img src="{{ $director->getFirstMediaUrl('profile', 'thumb') }}" onerror="this.src='{{ Avatar::create($director->contributor->name)->toBase64() }}'" alt="{{ $director->contributor->name }}" class="rounded-full border-2 border-gray-800">
                    </figure>
                    <h4 class="mb-2 text-gray-400 font-black">{{ $director->contributor->name }}</h4>
                    <h5 class="text-gray-400">{{ $director->job }}</h5>
                </a>
                @endforeach
            </div>
          </div>
          @endif
        </div>
      </div>
      <div class="col mx-auto mb-8 md:mb-0 md:w-1/2 max-w-md inline-flex flex-col items-start">
        @if ($siblings->get('previous')) {{-- Only show if there is a previous film --}}
          <a href="{{ route('film.show', ['slug' => $siblings->get('previous')->slug]) }}" class="my-1 w-full btn btn-md text-center uppercase shadow-md"><i class="fa fa-chevron-left mr-2 text-sm"></i> {{ App\Film::where('id', '<', $film->id)->orderBy('id', 'desc')->first()->title }}</a>
        @endif
        @if ($siblings->get('next')) {{-- Only show if there is a next film --}}
          <a href="{{ route('film.show', ['slug' => $siblings->get('next')->slug]) }}" class="my-1 w-full btn btn-md text-center uppercase shadow-md">{{ App\Film::where('id', '>', $film->id)->orderBy('id')->first()->title }} <i class="fa fa-chevron-right ml-2 text-sm"></i></a>
        @endif
        <a href="{{  }}" class="my-1 w-full btn btn-primary btn-lg text-center uppercase shadow-md" style="background: {{ optional($film->colors)->get(0) }}; color: {{ optional($film->colors)->get(2) }};">{{ trans('showing.order') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection