<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function index()
    {

        $cartContent = Cart::content();
        return Inertia::render('Cart/CartIndex',compact('cartContent'));
    }
    
    
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
        

        //return redirect()->route('productsClient.index')->with('info', 'Producto agregado al carrito de compras');
        return Redirect::route('productsClient.index')->with('info', 'Producto agregado al carrito de compras');

    }

    public function destroy($rowId)
    {
        //dd($rowId);
        $item = Cart::get($rowId);
        if($item->qty==1){
            Cart::remove($rowId);
            return Redirect::route('cart-content.index');
        }else{
            $item->qty= $item->qty - 1;
            return Redirect::route('cart-content.index');
        }
       
    }
}
