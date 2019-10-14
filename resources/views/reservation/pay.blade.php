@extends('layouts.app')

@section('content')
<section class="py-32 container">
  <pre>{{ json_encode($reservations, JSON_PRETTY_PRINT) }}</pre>
  @forelse ($reservations as $reservation)
    
  @empty
      
  @endforelse
</section>
@endsection