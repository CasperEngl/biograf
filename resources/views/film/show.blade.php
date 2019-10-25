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
  <div class="-mt-18">
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
                    <img src="{{ $cast->getFirstMediaUrl('profile', 'thumb') }}" alt="{{ $cast->contributor->name }}" class="rounded-full border-2 border-gray-800">
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
                      <img src="{{ $director->getFirstMediaUrl('profile', 'thumb') }}" alt="{{ $director->contributor->name }}" class="rounded-full border-2 border-gray-800">
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
          <a href="{{ route('film.show', ['slug' => $siblings->get('previous')->slug]) }}" class="mb-2 w-full btn btn-md uppercase shadow-md"><i class="fa fa-chevron-left mr-2 text-sm"></i> {{ App\Film::where('id', '<', $film->getKey())->orderBy('id', 'desc')->first()->title }}</a>
        @endif
        @if ($siblings->get('next')) {{-- Only show if there is a next film --}}
          <a href="{{ route('film.show', ['slug' => $siblings->get('next')->slug]) }}" class="mb-2 w-full btn btn-md uppercase shadow-md">{{ App\Film::where('id', '>', $film->getKey())->orderBy('id')->first()->title }} <i class="fa fa-chevron-right ml-2 text-sm"></i></a>
        @endif
        <div class="w-full text-center" :class="{
          'my-4': {{ $siblings->count() }}
        }">
          @if ((new App\Actions\FilmActions)->nextShowing($film))
          <a href="{{ route('showing.show', ['date' => (new App\Actions\FilmActions)->nextShowing($film)->start->toDateString(), 'showing' => (new App\Actions\FilmActions)->nextShowing($film)]) }}" class="mb-2 w-full btn btn-primary btn-lg text-center uppercase shadow-md" style="background: {{ optional($film->colors)->get(0) }}; color: {{ optional($film->colors)->get(2) }};">{{ trans('showing.order') }}</a>
          <p class="rounded text-gray-500 text-sm">{{ trans('showing.order.description') }}</p>
          @endif
        </div>
        @if ($film->ratings->count())
          <div class="w-full h-full flex flex-col">
            <h3 class="text-3xl uppercase text-center font-black">{{ trans_choice('film_rating.review', $film->ratings->count()) }}</h3>
            @foreach ($film->ratings->take(4) as $rating)
              <div class="p-4 mt-4 h-full flex items-center bg-gray-800 rounded shadow-lg">
                <div class="row items-center">
                  @if ($rating->user->getFirstMediaUrl('profile'))
                    <div class="col w-1/6">
                      <figure class="max-w-12">
                        <img src="{{ $rating->user->getFirstMediaUrl('profile', 'thumb') }}" alt="{{ $rating->user->name }}">
                      </figure>
                    </div>
                  @endif
                  <div class="col w-5/6">
                    <h4 class="mb-2 text-lg uppercase font-bold">{{ Str::limit($rating->title, 50) }}</h4>
                    <read-more-text :max-length="80">{{ $rating->review }}</read-more-text>
                  </div>
                </div>
              </div>
            @endforeach
            @if ((new App\Actions\ReservationActions)->pastFilmReservations(auth()->user(), $film)->count())
              <a href="{{ route('film.rating.index', compact('film')) }}" class="mt-4 btn btn-ghost">{{ trans('film_rating.review.write') }}</a>
            @else
              
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection