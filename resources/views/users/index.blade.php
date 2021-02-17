@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Gebruikers</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gebruikers</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <div class="d-flex">
                    <a href="{{ route('user.create') }}" class="btn btn-red">Gebruiker toevoegen</a>
                    <form class="ms-auto" method="get" action="{{ route('user.search') }}">
                        @csrf
                        <input type="text" name="search" placeholder="Zoeken..." class="form-control">
                    </form>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table mb-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td><a href="{{ route('user.edit', $user) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->company->title ?? NULL }}</td>
                                    <td class="text-end"><a href="{{ route('user.destroy', $user) }}" onclick="return confirm('Gebruiker verwijderen?')"><i class="bi bi-x"></i></a></td>
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
