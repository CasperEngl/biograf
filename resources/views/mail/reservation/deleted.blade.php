@component('mail::message')
# {{ trans('mail.reservation.deleted.greeting', compact('name')) }}

{{ trans('mail.reservation.deleted.content', compact('film', 'date')) }}

@endcomponent
