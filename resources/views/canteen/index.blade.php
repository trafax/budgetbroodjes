@extends('layouts.app')

@section('content')

    @include('partials.slider')

    <div class="container">
        <div class="row">
            <div class="col">
                @include('partials.categories')
            </div>

            @include('partials.short_cart')

        </div>
    </div>

@endsection
