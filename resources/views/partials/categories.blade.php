<div class="pt-4">

    @php
        $categories = \App\Models\Category::when('end_at', function($query, $date){
            return $query->where('end_at', NULL);
        })->get();
    @endphp

    <div class="row">
        <div class="col">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Selecteer een categorie
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                    @foreach ($categories as $category)
                        <li><a class="dropdown-item" href="{{ route('canteen.category', $category->slug) }}">{{ $category->title }}</a></li>
                    @endforeach
                </ul>
            </div>

            <hr>
        </div>
    </div>
</div>
