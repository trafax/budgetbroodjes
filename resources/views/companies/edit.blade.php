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
                        <li class="breadcrumb-item active" aria-current="page">Bedrijf bewerken</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <form method="post" action="{{ route('company.update', $company) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Bedrijfsnaam</label>
                        <input type="text" name="title" value="{{ old('title', $company->title) }}" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subdomeinnaam</label>
                        <input type="text" name="domain" value="{{ old('domain', $company->domain) }}" class="form-control" autocomplete="off">
                        <div class="form-text">Bijvoorbeeld naam.budgetbroodjes.nl</div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="canteen" value="0">
                            <input class="form-check-input" name="canteen" type="checkbox" value="1" id="canteen" {{ $company->canteen == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="canteen">
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
