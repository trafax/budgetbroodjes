@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Bedrijven</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bedrijven</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <div class="d-flex">
                    <a href="{{ route('company.create') }}" class="btn btn-red">Bedrijf toevoegen</a>
                    <form class="ms-auto" method="get" action="{{ route('company.search') }}">
                        @csrf
                        <input type="text" name="search" placeholder="Zoeken..." class="form-control">
                    </form>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mb-0">
                            @foreach ($companies as $company)
                                <tr>
                                    <td><a href="{{ route('company.edit', $company) }}">{{ $company->title }}</a></td>
                                    <td><a href="{{ config()->get('app.protocol') . $company->domain }}">{{ $company->domain }}</a></td>
                                    <td class="text-end"><a href="{{ route('company.destroy', $company) }}" onclick="return confirm('Bedrijf verwijderen?')"><i class="bi bi-x"></i></a></td>
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
