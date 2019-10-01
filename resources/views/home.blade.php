@extends('layouts.app')

@section('content')
<div class="py-32" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('{{ $featured->getFirstMediaUrl('backdrop') }}') no-repeat center center; background-size: cover;">
    <div class="container">
        <div class="row items-center justify-between">
            <div class="col w-1/2">
                <h2 class="text-4xl font-bold mb-4 text-white">
                    {{ $featured->title }}
                </h2>
                <h3 class="max-w-3xl text-2xl mb-8 text-gray-200 leading-normal">
                    {{ Str::limit($featured->overview, 150) }}
                </h3>

                <a class="btn btn-primary" href="{{ $featured->homepage }}">
                    {{ trans('film.read-more') }}
                </a>
            </div>
            <figure class="col w-1/2 max-w-md">
                {{ $featured->getFirstMedia('poster') }}
            </figure>
        </div>
    </div>
</div>
@endsection