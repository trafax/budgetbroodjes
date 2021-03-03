<div class="col-md-3 d-none d-md-block">
    <div class="position-relative">
        <div class="short-cart">
            <div class="bg-white border p-4 mb-4">
                Bedrijf: {{ $active_company->title }}<br>
                @if ($active_company->isOpen() == true)
                    De kantine sluit om {{ substr(($active_company->openingtime()->pivot->time_close ?? NULL), 0, 5) }}
                @endif
            </div>
            <div class="bg-white border p-4">
                @if ($active_company->isOpen() == true)
                    <h4>Je bestelling</h4>
                    <hr>
                    @foreach (\Cart::content() as $item)
                        <div class="row">
                            <div class="col">
                                {{ $item->name }}
                            </div>
                            <div class="col-auto text-end">
                                {{ $item->qty }}x<br>
                                € {{ number_format($item->price, 2, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="row">
                        <div class="col">
                            Grillburger (kip) met saus op een sesam bol
                        </div>
                        <div class="col-auto text-end">
                            1x<br>
                            € 2,55
                        </div>
                    </div>
                    <hr class="my-1">
                    <div class="row">
                        <div class="col">
                            Gebakken ei met ossenworst
                        </div>
                        <div class="col-auto text-end">
                            1x<br>
                            € 1,95
                        </div>
                    </div>
                    <hr class="my-1">
                    <div class="row">
                        <div class="col d-flex justify-content-between fw-bold mt-2">
                            <span>Totaal</span>
                            <span>€ 4,50</span>
                        </div>
                    </div> --}}

                    <div class="row">
                        <a href="" class="btn btn-warning mt-3">Afrekenen</a>
                    </div>
                @else
                    De kantine is gesloten.
                @endif
            </div>
        </div>
    </div>
</div>
