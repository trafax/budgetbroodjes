<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CanteenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('canteen.category')->with('category', $category);
    }
}
