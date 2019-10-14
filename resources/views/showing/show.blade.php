@extends('layouts.app')

@section('content')
<section class="pt-32 mb-24" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $showing->film->getFirstMediaUrl('backdrop', 'large') }}') no-repeat center center; background-size: cover; border-color: {{ optional($showing->film->colors)->get(0) }};">
  <div class="container md:-mb-48">
    <div class="row items-center flex-col-reverse md:flex-row">
      <div class="col w-full md:w-1/3">
        <figure class="mb-4 shadow-2xl">
          <img src="{{ $showing->film->getFirstMediaUrl('poster', 'large') }}" alt="">
        </figure>
      </div>
      <div class="col w-full md:w-2/3 md:mb-48">
        <h1 class="text-6xl italic uppercase font-black my-4 text-white text-center md:text-left">{{ $showing->film->title }}</h1>
      </div>
    </div>
  </div>
  <div class="bg-gray-800 py-8">
    <div class="container flex justify-end">
      <div class="md:w-1/3"></div>
      <div class="row md:w-2/3">
        <div class="col my-3 w-full md:w-1/4">
          <h4 class="mb-2 text-xl uppercase font-bold text-gray-500">{{ trans('showing.title.date') }}</h4>
          <h3 class="text-2xl uppercase font-black text-white">{{ $showing->date->toFormattedDateString() }}</h3>
        </div>
        @if ($showing->film->runtime)
        <div class="col my-3 w-full md:w-1/4">
          <h4 class="mb-2 text-xl uppercase font-bold text-gray-500">{{ trans('showing.title.runtime') }}</h4>
          <h3 class="text-2xl uppercase font-black text-white">{{ trans('showing.runtime', ['hours' => str_pad($hours, 2, 0, STR_PAD_LEFT), 'minutes' => str_pad($minutes, 2, 0, STR_PAD_LEFT)]) }}</h3>
        </div>
        @endif
        @if ($showing->version)
        <div class="col my-3 w-full md:w-1/4">
          <h4 class="mb-2 text-xl uppercase font-bold text-gray-500">{{ trans('showing.title.version') }}</h4>
          <h3 class="text-2xl uppercase font-black text-white">{{ $showing->version }}</h3>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
<div class="container">
  <form action="{{ route('reservation.store', compact('date', 'showing')) }}" method="POST">
    @csrf
    @method('POST')
    <div class="row">
      <div class="col w-full" :class="{
        'md:w-1/3': $store.getters.ticketsCount,
      }">
        <cinema-ticket-controller price="{{ $showing->price }}" class="h-full"></cinema-ticket-controller>
      </div>
      <div class="col w-full md:w-2/3" v-if="$store.getters.ticketsCount">
        <cinema-layout class="mb-4" :cinema="{{ json_encode($showing->cinema) }}" :seats="{{ $showing->cinema->seats }}" :reservations="{{ json_encode($showing->reservations) }}" :disabled="false"></cinema-layout>
      </div>
      <div class="my-8 col w-full flex justify-between">
        <a href="{{ url()->previous() }}" class="btn btn-lg btn-ghost">{!! trans('pagination.back') !!}</a>
        <button type="submit" class="btn btn-lg btn-primary rounded-full" v-if="$store.getters.ticketsCount">{!! trans('showing.purchase') !!}</button>
      </div>
    </div>
  </form>
</div>
@endsection