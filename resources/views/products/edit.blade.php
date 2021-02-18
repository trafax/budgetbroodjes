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
                        <li class="breadcrumb-item active" aria-current="page">Artikel bewerken</li>
                    </ol>
                </nav>
                <hr>

                @include('partials.alerts')

                <form method="post" action="{{ route('product.update', $product) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Titel</label>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}" class="form-control" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prijs</label>
                        <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-control" autocomplete="off">
                    </div>

                    <nav class="mt-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#attributes" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Attributen</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#image" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Afbeelding</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#offers" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Aanbiedingen</button>
                        </div>
                    </nav>
                    <div class="tab-content bg-white border-bottom p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="attributes" role="tabpanel" aria-labelledby="nav-home-tab">

                                @if ($product->foodticket_id != NULL)
                                    <div class="row row-cols-1 row-cols-md-2 g-4 {{ $product->extras->count() > 0 ? 'grid' : '' }}">
                                        @forelse ($product->extras->groupBy('id') as $extra => $options)
                                            <div class="col grid-item">
                                                <div class="card">
                                                    <div class="card-header">{{ \App\Models\Extra::find($extra)->title }}</div>
                                                    <div class="card-body">
                                                        @foreach ($options as $option)
                                                            <div class="small">
                                                                {{ $option->pivot->title }}
                                                                @if ($option->pivot->price > 0)
                                                                    (€ {{ number_format($option->pivot->price, 2, ',', '.') }})
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p>Er zijn geen attributen aan dit product gekoppeld.</p>
                                        @endforelse
                                    </div>
                                @endif
                        </div>
                        <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <img class="w-100" src="{{ asset('storage/'. $product->image) }}">
                        </div>
                        <div class="tab-pane fade" id="offers" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <p>Hier komen de aanbiedingen</p>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
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
