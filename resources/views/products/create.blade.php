@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Artikelen</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Artikelen</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Artikel toevoegen</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <form method="post" action="{{ route('product.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Titel</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prijs</label>
                        <input type="text" name="price" value="{{ old('price') }}" class="form-control" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <input type="submit" name="submit" value="Opslaan" class="btn btn-red">
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                @include('partials.admin_bar')
            </div>
        </div>
    </div>

@endsection
