@extends('layouts.app')

@section('content')

    <script>
        function syncData(object, url){

            $.ajax({
                url: url,
                data: '',
                type: 'GET',
                beforeSend: function(){
                    $(object).closest('div').find('.spinner-border').removeClass('d-none');
                },
                success: function(response){
                    $(object).closest('div').find('.spinner-border').addClass('d-none');
                    window.location.reload();
                },
                dataType: 'json'
           });

            return false;
        };
    </script>

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1>API Foodticket</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">API Foodticket</li>
                    </ol>
                </nav>
                <hr>
                <p>Via deze pagina kunt u zelf de categorieën, producten en attributen uit de kassa's importeren in de website.</p>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Categorieën ({{ \App\Models\Category::count() }})</h5>
                                <p class="card-text">
                                    <p class="small">
                                        De categorieën zijn het laatst bijgewerkt op:
                                        {{ date('d-m-Y H:i', strtotime(\App\Models\Category::where('foodticket_id', '!=', NULL)->orderBy('updated_at', 'DESC')->pluck('updated_at')->first())) }}
                                    </p>
                                    <div class="spinner-border me-2 d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <a href="#" onclick="return syncData($(this), '{{ route('foodticket.sync_categories') }}')" class="text-danger">Synchroniseer categorieën</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Artikelen ({{ \App\Models\Product::count() }})</h5>
                                <p class="card-text">
                                    <p class="small">
                                        De artikelen zijn het laatst bijgewerkt op:
                                        {{ date('d-m-Y H:i', strtotime(\App\Models\Product::where('foodticket_id', '!=', NULL)->orderBy('updated_at', 'DESC')->pluck('updated_at')->first())) }}
                                    </p>
                                    <div class="spinner-border me-2 d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <a href="#" onclick="return syncData($(this), '{{ route('foodticket.sync_products') }}')" class="text-danger">Synchroniseer artikelen</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Attributen ({{ \App\Models\Extra::count() }})</h5>
                                <p class="card-text">
                                    <p class="small">
                                        De attributen zijn het laatst bijgewerkt op:
                                        {{ date('d-m-Y H:i', strtotime(\App\Models\Extra::where('foodticket_id', '!=', NULL)->orderBy('updated_at', 'DESC')->pluck('updated_at')->first())) }}
                                    </p>
                                    <div class="spinner-border me-2 d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <a href="#" onclick="return syncData($(this), '{{ route('foodticket.sync_extras') }}')" class="text-danger">Synchroniseer attributen</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Afbeeldingen</h5>
                                <p class="card-text">
                                    <p class="small">
                                        Koppel de kassa afbeeldingen aan de producten
                                    </p>
                                    <div class="spinner-border me-2 d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <a href="#" onclick="return syncData($(this), '{{ route('foodticket.sync_images') }}')" class="text-danger">Koppel afbeeldingen</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                @include('partials.admin_bar')
            </div>
        </div>
    </div>

@endsection
