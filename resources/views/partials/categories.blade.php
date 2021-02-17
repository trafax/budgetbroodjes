<div class="pt-4">

    @php
        $categories = \App\Models\Category::when('end_at', function($query, $date){
            return $query->where('end_at', NULL);
        })->get();
    @endphp

    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $category->title ?? 'Selecteer een categorie' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        @foreach ($categories as $obj)
                            <li><a class="dropdown-item" href="{{ route('canteen.category', $obj->slug) }}">{{ $obj->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h1>{{ $category->title ?? '' }}</h1>
                </div>
            </div>
            <hr class="mt-2">
        </div>
    </div>
</div>
