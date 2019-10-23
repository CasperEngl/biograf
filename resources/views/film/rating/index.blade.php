@extends('layouts.app')

@section('content')
<div class="min-h-lg pt-64 pb-32" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $film->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($film->colors)->get(0) }};">
  <div class="container">
    <h1 class="text-6xl italic uppercase font-black mb-4 text-white text-center md:text-left">
      {!! trans('film_rating.title.hero', ['title' => $film->title]) !!}
    </h1>
  </div>
</div>
<section class="py-32 container">
  <form action="{{ route('film.rating.store', $film) }}" method="POST">
    @csrf
    @method('POST')

    <div class="my-4 p-10 bg-gray-800 rounded">
      <div class="row">
        <div class="my-3 col w-full">
          <input-label for="title">{{ trans('film_rating.title') }}</input-label>
          <input-field id="title" type="text" name="title" value="{{ old('title') }}" required autofocus></input-field>
          <error-message key="title"></error-message>
        </div>
        <div class="my-3 col w-full">
          <input-label for="rating">{{ trans('film_rating.rating') }}</input-label>
          <star-rating></star-rating>
        </div>
        <div class="my-3 col w-full">
          <input-label for="review">{{ trans_choice('film_rating.review', 1) }}</input-label>
          <text-field id="review" type="text" name="review" value="{{ old('review') }}" rows="8" cols="1" required autofocus></text-field>
          <error-message key="review"></error-message>
        </div>
        <div class="my-3 col w-full">
          <submit-button>{{ trans('film_rating.review.submit') }}</submit-button>
        </div>
      </div>
    </div>

  </form>
</section>
@endsection