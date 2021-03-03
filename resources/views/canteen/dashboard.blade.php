@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1>Dashboard</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <hr>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Aantal bestellingen vandaag</h5>
                                <p class="card-text">Er zijn vandaag 0 bestellingen geplaatst.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Totale omzet vandaag</h5>
                                <p class="card-text">Er is vandaag voor € 0,00 besteld.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                @include('partials.owner_bar')
            </div>
        </div>
    </div>

@endsection
