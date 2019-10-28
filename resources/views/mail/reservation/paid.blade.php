@component('mail::message')
# {{ trans('mail.reservation.paid.greeting', compact('name')) }}

@if (is_array(trans('mail.reservation.paid.body')))
@foreach (trans('mail.reservation.paid.body') as $body)

{{ $body }}

@endforeach
@else

{{ trans('mail.reservation.paid.body') }}

@endif

<div class="row-tight">
    @foreach ($barcodes as $barcode)
    <div class="my-5 col w-1/2">
        <figure class="p-5 bg-white">
            <img src="{{ asset('img/barcode/' . $barcode) }}" alt="qr code" class="mx-auto w-full max-w-48">
        </figure>
    </div>
    @endforeach
</div>

@endcomponent