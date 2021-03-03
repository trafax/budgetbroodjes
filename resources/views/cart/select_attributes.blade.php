<div class="modal" tabindex="-1">
    <div class="modal-dialog {{ $product->extras->count() > 0 ? 'modal-lg' : '' }}">
        <form method="post" action="{{ route('cart.insert', $product) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $product->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @if ($product->extras->count() > 0)
                            <div class="col">
                                <h3>Beschikbare extra's</h3>
                                <p>Pas uw product aan middels onderstaande opties.</p>
                                @forelse ($product->extras->groupBy('id') as $extra => $options)
                                    <div class="col mb-4">
                                        <div class="card" id="{{ \App\Models\Extra::find($extra)->id }}">
                                            <div class="card-header">{{ \App\Models\Extra::find($extra)->title }}</div>
                                            <div class="card-body">
                                                <select class="form-select form-select-sm" onchange="$('#{{ \App\Models\Extra::find($extra)->id }}').find('.extra_title').val($(this).val()); $('#{{ \App\Models\Extra::find($extra)->id }}').find('.extra_price').val($(this).find(':selected').data('price'))">
                                                    <option value="">Maak uw keuze</option>
                                                    @foreach ($options as $option)
                                                        <option value="{{ $option->pivot->title }}" data-price="{{ $option->pivot->price }}">
                                                            {{ $option->pivot->title }}
                                                            @if ($option->pivot->price > 0)
                                                                (€ {{ number_format($option->pivot->price, 2, ',', '.') }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" class="extra_title" name="extras[{{ $loop->index }}][title]" value="">
                                                <input type="hidden" class="extra_price" name="extras[{{ $loop->index }}][price]" value="">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>Er zijn geen attributen aan dit product gekoppeld.</p>
                                @endforelse
                            </div>
                        @endif
                        <div class="col">
                            <h3>Product informatie</h3>
                            <p>Maecenas congue metus augue, sed porttitor ante viverra ut. Pellentesque erat orci, scelerisque id viverra vel, malesuada eu mauris. Ut malesuada lacus at tellus rutrum eleifend.</p>
                            <hr>
                            <label class="form-label">Aantal</label>
                            <input type="number" name="qty" value="1" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluit</button>
                    <button type="submit" class="btn btn-red">Plaats in winkelwagen</button>
                </div>
            </div>
        </form>
    </div>
</div>
