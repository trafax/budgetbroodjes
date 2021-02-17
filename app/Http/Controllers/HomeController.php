<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function canteen()
    {
        return view('canteen.index');
    }
}
