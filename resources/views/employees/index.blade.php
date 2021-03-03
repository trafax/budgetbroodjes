@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Werknemers</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Werknemers</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <div class="d-flex">
                    <a href="{{ route('employee.create') }}" class="btn btn-red">Werknemer toevoegen</a>
                    <form class="ms-auto" method="get" action="{{ route('employee.search') }}">
                        @csrf
                        <input type="text" name="search" placeholder="Zoeken..." class="form-control">
                    </form>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mb-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td><a href="{{ route('employee.edit', $user) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->company->title ?? '-' }}</td>
                                    <td class="text-end"><a href="{{ route('employee.destroy', $user) }}" onclick="return confirm('Werknemer verwijderen?')"><i class="bi bi-x"></i></a></td>
                                </div>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                @include('partials.owner_bar')
            </div>
        </div>
    </div>

@endsection
