@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col mb-4">
                <h1>Gebruikers</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Gebruikers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gebruiker bewerken</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <form method="post" action="{{ route('user.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Bedrijf</label>
                        <select name="company_id" class="form-select search-select">
                            <option value="">Koppel aan bedrijf</option>
                            @foreach (\App\Models\Company::orderBy('title', 'ASC')->get() as $company)
                                <option {{ $user->company_id == $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Naam</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mailadres</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="role" class="form-select">
                            <option value="user">Medewerker</option>
                            <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Kantine beheerder</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Website beheerder</option>
                        </select>
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
