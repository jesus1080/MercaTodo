<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function index(): Response
    {
        $cartContent = Cart::content();
        $cartTotal = Cart::subtotal();
        $countCart = Cart::count();
        return Inertia::render('Cart/Cart', compact('cartContent', 'cartTotal','countCart'));
    }


    public function store(Request $request): RedirectResponse
    {
        $product = Product::findOrfail($request->input('productId'));
       

        if($product->stock > 1 && $product->stock >  $request->input('quantity')){
            $card = Cart::add(
                $product->id,
                $product->name,
                $request->input('quantity'),
                $product->price,
                0,
                ['image' => $product->image]
            );
        }
        
        return Redirect::route('productsClient.index');
    }

    public function destroy($rowId): RedirectResponse
    {
        $item = Cart::get($rowId);
        if ($item->qty==1) {
            Cart::remove($rowId);
            return Redirect::route('cart-content.index');
        } else {
            $item->qty= $item->qty - 1;
            return Redirect::route('cart-content.index');
        }
    }

    public function destroycart(): RedirectResponse
    {
        Cart::destroy();
        return Redirect::route('cart-content.index');
    }
    
    public function update(Request $request,String $rowId): RedirectResponse
    {
        Cart::update($rowId, $request->quantity);
        return Redirect::route('cart-content.index');
    }
}
