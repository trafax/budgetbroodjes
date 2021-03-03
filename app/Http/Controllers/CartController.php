<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {

    }

    public function add(Product $product)
    {
        //if ($product->extras->count() > 0) {
        return response()->json(['modal' => 'true', 'html' => view('cart.select_attributes')->with(['product' => $product])->render()]);
        //}
    }

    public function insert(Product $product, Request $request)
    {
        $additionalPrice = 0;
        $extras = ($request->get('extras') ?? []);

        // Loop door extra's heen om de vaste prijs te bepalen
        foreach ($extras as $extra) {
            $additionalPrice += $extra['price'];
        }

        // Prijs van product
        $price = ($product->price + $additionalPrice) * (int) $request->get('qty');

        // Product met extra's in winekwagen plaatsen
        \Cart::add(['id' => uniqid('1_'), 'name' => $product->title, 'qty' => $request->get('qty'), 'price' => $price, 'options' => $extras]);

        return redirect()->back();
    }
}
