@component('mail::message')
# {{ trans('mail.reservation.deleted.greeting', compact('name')) }}

@if (is_array(trans('mail.reservation.paid.body')))
@foreach (trans('mail.reservation.paid.body') as $body)

{{ $body }}

@endforeach
@else

{{ trans('mail.reservation.paid.body') }}

@endif

@endcomponent
