@component('mail::message')
# {{ trans('reservation.canceled.greeting', compact('name')) }}

{{ trans('reservation.canceled.content', compact('film', 'date')) }}

@endcomponent
