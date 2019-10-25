@extends('layouts.app')

@section('content')
<section class="pt-32 mb-8" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $showing->film->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($showing->film->colors)->get(0) }};">
  <div class="container md:-mb-66">
    <div class="row items-center flex-col-reverse md:flex-row">
      <div class="col w-full md:w-1/3">
        <a href="{{ route('film.show', ['slug' => $showing->film->slug]) }}">
          <figure class="mb-4 shadow-2xl">
            <img src="{{ $showing->film->getFirstMediaUrl('poster', 'large') }}" alt="{{ $showing->film->title }}">
          </figure>
        </a>
      </div>
      <div class="col w-full md:w-2/3 md:mb-64">
        <a href="{{ route('film.show', ['slug' => $showing->film->slug]) }}">
          <h1 class="text-3xl md:text-6xl italic uppercase font-black my-4 text-white text-center md:text-left">{{ $showing->film->title }}</h1>
        </a>
      </div>
    </div>
  </div>
  <div class="bg-gray-800 py-8">
    <div class="container flex justify-end">
      <div class="row md:w-2/3">
        <div class="col my-3 w-full">
          <h4 class="mb-2 text-xl uppercase font-bold text-gray-500">{{ trans('showing.title.date') }}</h4>
          <h3 class="text-lg md:text-2xl uppercase font-black text-white">{{ $showing->start->isoFormat('dddd DD. MMM') }} {{ $showing->start->format('H:i') }}</h3>
        </div>
        @if ($showing->film->runtime)
        <div class="col my-3 w-full">
          <h4 class="mb-2 text-xl uppercase font-bold text-gray-500">{{ trans('showing.title.runtime') }}</h4>
          <h3 class="text-lg md:text-2xl uppercase font-black text-white">{{ trans_choice('showing.runtime.hours', $hours, compact('hours')) }} {{ trans_choice('showing.runtime.minutes', $minutes, compact('minutes')) }}</h3>
        </div>
        @endif
        @if ($showing->version)
        <div class="col my-3 w-full">
          <h4 class="mb-2 text-xl uppercase font-bold text-gray-500">{{ trans('showing.title.version') }}</h4>
          <h3 class="text-lg md:text-2xl uppercase font-black text-white">{{ $showing->version }}</h3>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
<section class="container my-16">
  <div class="row">
    <div class="col w-full" :class="{
      'md:w-1/3': $store.getters.ticketsCount,
    }">
      <cinema-ticket-controller price="{{ $showing->price }}" :multiplier="{{ json_encode($showing->multiplier) }}" class="h-full rounded"></cinema-ticket-controller>
    </div>
    <div class="col w-full md:w-2/3" v-if="$store.getters.ticketsCount">
      <cinema-layout class="mb-4" :showing="{{ json_encode($showing) }}" :cinema="{{ json_encode($showing->cinema()) }}" reserver-id="{{ auth()->id() ?? session()->getId() }}" :disabled="false"></cinema-layout>
    </div>
    <div class="my-8 col w-full">
      <div class="row">
        <div class="my-3 col w-1/2 flex md:justify-start">
          <a href="{{ url()->previous() }}" class="btn md:btn-lg btn-ghost rounded-full">{!! trans('pagination.back') !!}</a>
        </div>
        <div class="my-3 col w-1/2 flex md:justify-end">
          <a href="{{ route('reservation.finalize', $showing) }}" class="btn md:btn-lg btn-primary rounded-full" v-if="$store.getters.ticketsCount">{{ trans('showing.order') }}</a>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="container my-16">
  <h2 class="mb-4 text-2xl uppercase font-black text-center">{{ trans('showing.next.title') }}</h2>
  <div class="row-tight">
  @forelse ((new App\Actions\ShowingActions)->nextShowings($showing, 6) as $nextShowing)
  <div class="col w-1/2 sm:w-1/3 md:w-1/6 my-1">
    <a href="{{ route('showing.show', ['date' => $nextShowing->start->toDateString(), 'showing' => $nextShowing]) }}" class="btn btn-ghost h-full w-full inline-flex flex-col items-center text-center">
      <div class="text-sm mb-1">{{ ucwords($nextShowing->start->isoFormat('dddd')) }}</div>
      <div class="text-sm mb-2">{{ ucwords($nextShowing->start->isoFormat('D. MMMM')) }}</div>
      <div class="text-xl mb-1">{{ $nextShowing->start->format('H:i') }}</div>
    </a>
  </div>
  @empty
  <p class="text-xl">{{ trans('showing.next.none') }}</p>
  @endforelse
  </div>
</section>
@endsection