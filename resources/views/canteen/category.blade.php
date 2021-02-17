@extends('layouts.app')

@section('content')

    @include('partials.slider')

    <div class="container">
        <div class="row">
            <div class="col">

                @include('partials.categories')

                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach ($category->products as $product)
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h4>{{ $product->title }}</h4>
                                            <div class="small">
                                                @foreach ($product->extras->groupBy('id') as $extra => $options)
                                                    @if (preg_match('(brood soorten)', strtolower(\App\Models\Extra::find($extra)->title)))
                                                        <strong>{{ \App\Models\Extra::find($extra)->title }}</strong>:
                                                        @foreach ($options as $option)
                                                            {{ $option->pivot->title }}
                                                        @endforeach
                                                        <br>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <a href="" class="btn btn-red btn-sm mt-2">€ {{ number_format($product->price, 2, ',', '.') }} <i class="bi bi-plus"></i></a>
                                        </div>
                                        <div class="col-4">
                                            @if ($product->image)
                                                <img style="object-fit: scale-down; height: 150px; width: 100%;" src="{{ asset('storage/'. $product->image) }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @include('partials.short_cart')
        </div>
    </div>

@endsection
