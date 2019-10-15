@extends('layouts.app')

@section('content')
<section class="container py-32 text-center">
  <h1 class="mb-8 text-4xl font-black uppercase text-gray-600 tracking-wider">Status <span class="text-white">{{ trans('reservation.status.' . $reservation->status) }}</span></h1>
  <p class="mx-auto max-w-3xl text-xl">{!! trans('reservation.text.' . $reservation->status, ['film' => $reservation->showing->film->title, 'link' => '<a class="text-blue-500 underline" href="' . route('showing.show', ['date' => $reservation->showing->start->toDateString(), 'showing' => $reservation->showing]) . '">her</a>']) !!}</p>
</section>
@endsection