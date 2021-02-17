@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Bedrijven</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('company.index') }}">Bedrijven</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bedrijf toevoegen</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <form method="post" action="{{ route('company.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Bedrijfsnaam</label>
                        <input type="text" name="title" value="" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subdomeinnaam</label>
                        <input type="text" name="domain" value="" class="form-control" autocomplete="off">
                        <div class="form-text">Bijvoorbeeld naam.budgetbroodjes.nl</div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" name="canteen" type="checkbox" value="1" id="company">
                            <label class="form-check-label" for="company">
                                Gebruik als bedrijfskantine
                            </label>
                        </div>
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
