<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        // Alle producten
        $products = Product::orderBy('title', 'ASC');

        // Gezochte producten
        if ($request->get('search')) {
            $products = Product::when($request->get('search'), function($query) use ($request) {
                return $query->orWhere(function($query) use ($request) {
                    return $query->orWhere('title', 'LIKE', '%'.$request->get('search').'%')
                    ->orWhereHas('categories', function($query) use ($request) {
                        $query->where('title', 'LIKE',  '%'.$request->get('search').'%');
                    });
                 });
            });
        }

        return view('products.index')->with('products', $products->get());
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $product = new Product();
        $request->request->set('slug', Str::slug($request->get('title')));
        $product->fill($request->all());
        $product->save();

        return redirect()->route('product.index')->with('alert', ['type' => 'success', 'message' => 'Artikel succesvol toegevoegd.']);
    }

    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    public function update(Product $product, Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $request->request->set('slug', Str::slug($request->get('title')));
        $product->fill($request->all());
        $product->save();

        return redirect()->route('product.index')->with('alert', ['type' => 'success', 'message' => 'Artikel succesvol aangepast.']);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')->with('alert', ['type' => 'success', 'message' => 'Artikel succesvol verwijderd.']);
    }
}
