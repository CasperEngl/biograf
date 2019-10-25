@component('mail::message')
# {{ trans('mail.reservation.paid.greeting', compact('name')) }}

{{ trans('mail.reservation.paid.content') }}

@foreach ($reservation->seats as $seat)
<div class="my-1 col w-1/3">
  <figure class="p-5 bg-white">
    <img src="{{ url(DNS2D::getBarcodePNGPath($reservation->getTransactionId() . '|' . $seat->label, 'QRCODE', 20, 20)) }}" alt="qr code" style="max-width: 100%;">
  </figure>
</div>
@endforeach

@endcomponent
