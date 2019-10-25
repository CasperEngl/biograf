@component('mail::message')
# {{ trans('mail.reservation.canceled.greeting', compact('name')) }}

@if (is_array(trans('mail.reservation.canceled.body')))
@foreach (trans('mail.reservation.canceled.body') as $body)

{{ $body }}

@endforeach
@else

{{ trans('mail.reservation.canceled.body') }}

@endif

@endcomponent
