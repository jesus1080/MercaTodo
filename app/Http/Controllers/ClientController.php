<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\Admin\Products\IndexProductRequest;

class ClientController extends Controller
{
    public function index(IndexProductRequest $request):Response
    {
        $filter = [
            'filterName' => $request->input('filterName'),
            'filterPriceMin' => $request->input('filterPriceMin'),
            'filterPriceMax' => $request->input('filterPriceMax'),
        ];
        $products = Product::name($request->input('filterName'))
                                ->priceMin($request->input('filterPriceMin'))
                                ->priceMax($request->input('filterPriceMax'))
                                ->where("status","=",true)
                                ->paginate(3)->appends($request->only($filter));
        if($filter===null){
            return Inertia::render('Product/ProductsShow',compact('products'));
        }
        return Inertia::render('Product/ProductsShow',compact('products','filter'));
    }

    public function show(int $id): Response
    {
        $product = Product::find($id);
        return Inertia::render('Product/ProductShow', compact('product'));
    }
}