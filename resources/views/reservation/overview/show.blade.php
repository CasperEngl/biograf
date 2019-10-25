@extends('layouts.app')

@section('content')
<section class="container py-32 text-center">
  <h1 class="mb-8 text-4xl font-black uppercase text-gray-600 tracking-wider">Status <span class="text-white">{{ trans('reservation.status.' . $reservation->status) }}</span></h1>
  <p class="mx-auto max-w-3xl text-xl">{!! trans('reservation.text.' . $reservation->status, ['film' => $reservation->showing->film->title, 'link' => '<a class="text-blue-500 underline" href="' . route('showing.show', ['date' => $reservation->showing->start->toDateString(), 'showing' => $reservation->showing]) . '">her</a>']) !!}</p>
  <div class="my-8 row-tight max-w-3xl mx-auto">
    @foreach ($reservation->seats as $seat)
    <div class="my-5 md:my-1 col w-full md:w-1/3 print:w-1/2">
        <figure class="p-5 bg-white">
          <img src="{{ url(DNS2D::getBarcodePNGPath($reservation->getTransactionId() . '|' . $seat->label, 'QRCODE', 20, 20)) }}" alt="qr code" class="print:mx-auto print:w-full print:max-w-48">
        </figure>
      </div>
    @endforeach
  </div>
</section>
@endsection