<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $categories = Category::orderBy('title', 'ASC');
        if ($request->get('search')) {
            $categories->where('title', 'LIKE', '%'. $request->get('search') .'%');
        }

        return view('categories.index')->with('categories', $categories->get());
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $category = new Category();
        $request->request->set('slug', Str::slug($request->get('title')));
        $category->fill($request->all());
        $category->save();

        return redirect()->route('category.index')->with('alert', ['type' => 'success', 'message' => 'Categorie succesvol toegevoegd.']);
    }

    public function edit(Category $category)
    {
        return view('categories.edit')->with('category', $category);
    }

    public function update(Category $category, Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $request->request->set('slug', Str::slug($request->get('title')));
        $category->fill($request->all());
        $category->save();

        return redirect()->route('category.index')->with('alert', ['type' => 'success', 'message' => 'Categorie succesvol aangepast.']);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')->with('alert', ['type' => 'success', 'message' => 'Categorie succesvol verwijderd.']);
    }
}
