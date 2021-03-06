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


                    <nav class="mt-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#openingshours" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Openingstijden</button>
                        </div>
                    </nav>

                    <div class="tab-content bg-white border-bottom p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="openingshours" role="tabpanel" aria-labelledby="nav-home-tab">

                            <script>
                                function cloneRow() {

                                    $('.b-row').clone().insertAfter(".rows").removeClass('b-row').addClass('mt-2');

                                    return false;
                                }

                                function removeRow(object) {
                                    $(object).closest('.row').remove();

                                    return false;
                                }
                            </script>

                            <a href="#" onclick="return cloneRow($(this))" class="mb-3 d-block">Voeg een regel toe</a>

                            @foreach($company->openingtimes()->orderBy('day')->orderBy('time_open')->get() as $openingtime)
                                <div class="row mb-2">
                                    <div class="col-auto">
                                        <select name="openingtimes[day][]" class="form-select">
                                            <option value="0">Kies een dag</option>
                                            <option value="1" {{ $openingtime->pivot->day == 1 ? 'selected' : '' }}>Ma</option>
                                            <option value="2" {{ $openingtime->pivot->day == 2 ? 'selected' : '' }}>Di</option>
                                            <option value="3" {{ $openingtime->pivot->day == 3 ? 'selected' : '' }}>Wo</option>
                                            <option value="4" {{ $openingtime->pivot->day == 4 ? 'selected' : '' }}>Do</option>
                                            <option value="5" {{ $openingtime->pivot->day == 5 ? 'selected' : '' }}>Vr</option>
                                            <option value="6" {{ $openingtime->pivot->day == 6 ? 'selected' : '' }}>Za</option>
                                            <option value="0" {{ $openingtime->pivot->day == 0 ? 'selected' : '' }}>Zo</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" placeholder="00:00" name="openingtimes[time_open][]" class="form-control" value="{{ $openingtime->pivot->time_open }}">
                                    </div>
                                    <div class="col">
                                        <input type="text" placeholder="00:00" name="openingtimes[time_close][]" class="form-control" value="{{ $openingtime->pivot->time_close }}">
                                    </div>
                                    <div class="col-auto text-end">
                                        <a href="#" onclick="return removeRow($(this))">X</a>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row b-row">
                                <div class="col-auto">
                                    <select name="openingtimes[day][]" class="form-select">
                                        <option value="0">Kies een dag</option>
                                        <option value="1">Ma</option>
                                        <option value="2">Di</option>
                                        <option value="3">Wo</option>
                                        <option value="4">Do</option>
                                        <option value="5">Vr</option>
                                        <option value="6">Za</option>
                                        <option value="7">Zo</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" placeholder="00:00" name="openingtimes[time_open][]" class="form-control">
                                </div>
                                <div class="col">
                                    <input type="text" placeholder="00:00" name="openingtimes[time_close][]" class="form-control">
                                </div>
                                <div class="col-auto">&nbsp; &nbsp;</div>
                            </div>

                            <div class="rows"></div>




                        </div>
                    </div>


                    <div class="mb-3 mt-4">
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
