<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\Admin\Products\IndexProductRequest;
use App\Models\Category;

class ClientController extends Controller
{
    public function index(IndexProductRequest $request): Response
    {
        $filter = [
            'filterName' => $request->input('filterName'),
            'filterPriceMin' => $request->input('filterPriceMin'),
            'filterPriceMax' => $request->input('filterPriceMax'),
            'filterCategory' => $request->input('filterCategory'),
        ];
        $categories = Category::all();
        //dd($request->input('filterCategory'));
        $countCart = Cart::count();
        $products = Product::name($request->input('filterName'))
                                ->priceMin($request->input('filterPriceMin'))
                                ->priceMax($request->input('filterPriceMax'))
                                ->category($request->input('filterCategory'))
                                ->with(['category:id,name'])
                                ->where("status", "=", true)
                                ->paginate(8)->appends($request->only($filter));
        if ($filter===null) {
            return Inertia::render('Product/ProductsShow', compact('products', 'categories'));
        }
        return Inertia::render('Product/ProductsShow', compact('products', 'categories', 'filter', 'countCart'));
    }

    public function show(int $id): Response
    {
        $product = Product::find($id);
        return Inertia::render('Product/ProductShow', compact('product'));
    }
}
