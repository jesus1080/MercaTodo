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
        $filterName = $request->input('filterName');
        $products = Product::name($request->input('filterName'))
                                ->prices($request->input('filterPrice'))
                                ->where("status","=",true)
                                ->paginate(10)->appends($request->only('filterName'));
        if($filterName===null){
            return Inertia::render('Product/ProductsShow',compact('products'));
        }
        return Inertia::render('Product/ProductsShow',compact('products','filterName'));
    }

    public function show(int $id): Response
    {
        $product = Product::find($id);
        return Inertia::render('Product/ProductShow', compact('product'));
    }
}