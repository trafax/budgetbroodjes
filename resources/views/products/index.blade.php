@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Artikelen</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Artikelen</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <div class="d-flex">
                    <a href="{{ route('product.create') }}" class="btn btn-red">Product toevoegen</a>
                    <form class="ms-auto" method="get" action="{{ route('product.search') }}">
                        @csrf
                        <input type="text" name="search" placeholder="Zoeken..." class="form-control">
                    </form>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mb-0">
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.edit', $product) }}">{{ $product->title }}</a>
                                        <div class="small">{{ $product->categories->first()->title ?? '' }}</div>
                                    </td>
                                    <td class="text-nowrap">€ {{ $product->price }}</td>
                                    <td class="text-end"><a href="{{ route('product.destroy', $product) }}" onclick="return confirm('Product verwijderen?')"><i class="bi bi-x"></i></a></td>
                                </div>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                @include('partials.admin_bar')
            </div>
        </div>
    </div>

@endsection
