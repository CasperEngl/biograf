@extends('layouts.app')

@section('content')
<section class="py-48 container">
  <h2 class="mb-4 text-4xl uppercase font-black tracking-wide">{{ trans('showing.when_to_watch') }}</h2>
  <div class="mb-4 row-tight">
    @foreach ($days as $day)
      <div class="my-1 col w-full sm:w-1/3">
        <a href="{{ route('showing.index', ['date' => $day->toDateString()]) }}" class="group p-0 w-full h-full btn inline-flex flex-col items-center text-center">
          @if ($day->startOfDay()->eq(now()->startOfDay()))
            <div class="py-6 text-3xl tracking-wide uppercase">{{ trans('showing.today') }}</div>
          @endif
          @if ($day->startOfDay()->eq(now()->add(1, 'day')->startOfDay()))
            <div class="py-6 text-3xl tracking-wide uppercase">{{ trans('showing.tomorrow') }}</div>
          @endif
          @if ($day->startOfDay()->diffInDays(now()))
            <div class="py-6 text-3xl tracking-wide uppercase">{{ $day->isoFormat('dddd') }}</div>
          @endif
          <div class="py-2 w-full bg-gray-300 group-hover:bg-gray-300 rounded-b text-xl tracking-tighter uppercase">{{ $day->isoFormat('D. MMMM') }}</div>
        </a>
      </div>
    @endforeach
  </div>
  <div class="text-center">
    <error-message key="page"></error-message>
  </div>
  <div class="row-tight items-center">
    <div class="col w-1/3 flex justify-start">
      @if ($previous > 0)
      <a href="{{ route('showing.pick', ['page' => $previous]) }}" class="btn btn-lg btn-ghost uppercase">{!! trans('showing.pick.previous') !!}</a>
      @endif
    </div>
    <div class="col w-1/3 flex flex-col items-center">
      <h4 class="mb-2 text-2xl">{{ trans('showing.pick.between', ['start' => $days->first()->toDateString(), 'end' => $days->last()->toDateString()]) }}</h4>
      <p>({{ trans('showing.pick.page', ['page' => $previous + 1]) }})</p>
    </div>
    <div class="col w-1/3 flex justify-end">
      <a href="{{ route('showing.pick', ['page' => $next]) }}" class="btn btn-lg btn-ghost uppercase">{!! trans('showing.pick.next') !!}</a>
    </div>
  </div>
</section>
@endsection