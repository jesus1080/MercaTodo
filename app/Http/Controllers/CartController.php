<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrfail($request->input('productId'));
        $card = Cart::add(
            $product->id,
            $product->name,
            $request->input('quantity'),
            $product->price,
        );

        //dd(Cart::content());

        return redirect()->route('productsClient.index')->with('message', 'Producto agregado al carrito de compras');
    }
}
