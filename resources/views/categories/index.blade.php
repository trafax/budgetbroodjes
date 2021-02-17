@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Categorieën</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categorieën</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <div class="d-flex">
                    <a href="{{ route('category.create') }}" class="btn btn-red">Categorie toevoegen</a>
                    <form class="ms-auto" method="get" action="{{ route('category.search') }}">
                        @csrf
                        <input type="text" name="search" placeholder="Zoeken..." class="form-control">
                    </form>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mb-0">
                            @foreach ($categories as $category)
                                <tr>
                                    <td><a href="{{ route('category.edit', $category) }}">{{ $category->title }}</a></td>
                                    <td class="small">{{ $category->slug }}</td>
                                    <td><div class="badge bg-primary"> {{$category->products()->count() }}</div></td>
                                    <td class="text-end"><a href="{{ route('category.destroy', $category) }}" onclick="return confirm('Categorie verwijderen?')"><i class="bi bi-x"></i></a></td>
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
