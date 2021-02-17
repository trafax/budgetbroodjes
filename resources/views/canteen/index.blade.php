@extends('layouts.app')

@section('content')

    @include('partials.slider')

    <div class="container">
        @include('partials.categories')

        <div class="row">
            <div class="col"></div>
            <div class="col-3">
                @include('partials.short_cart')
            </div>
        </div>
    </div>

@endsection
