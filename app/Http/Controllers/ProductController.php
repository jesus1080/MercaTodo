<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Product;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Imports\ProductsImport;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $products = Product::paginate(4);
        if (Arr::has($request->session()->all(), 'info')) {
            $info = $request->session()->all()['info'];
            return Inertia::render('Product/Products', compact('products', 'info'));
        } else {
            return Inertia::render('Product/Products', compact('products'));
        }
    }

    public function create(): Response
    {
        $categories = Category::all();
        return Inertia::render('Product/CreateProduct', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $image = $request->image;
        $imageName = (string)Str::uuid().'.'.$image->getClientOriginalExtension();

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => 'public/storage/products_images/'.$imageName,
            'description' => $request->description,
            'stock' => $request->stock,
            'category_id' => (int)$request->categoryId,
        ]);

        event(new Registered($product));
        $image->storeAS('public/products_images', $imageName);
        $message = "Se creo el producto correctamente";
        return Redirect::route('products.index')->with('info', $message);
    }

    public function edit(Product $product): Response
    {
        $categories = Category::all();
        return Inertia::render('Product/EditProduct', ['product'=>$product,'categories'=>$categories]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update([

            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'category_id' => $request->categoryId,

        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/products_images/'.$product->getImageName());
            $image = $request->image;
            $imageName = (string)Str::uuid().'.'.$image->getClientOriginalExtension();
            $image->storeAS('public/products_images', $imageName);
            $product->update([
                'image' => 'public/storage/products_images/'.$imageName,
            ]);
        }
        return Redirect::route('products.index');
    }

    public function destroy($id)
    {
        //
    }

    public function import(Request $request): RedirectResponse
    {
        $file = $request->file;
        
        Excel::import(new ProductsImport(), $file);

        return Redirect::route('products.index');
    }

    public function export()
    {
        //dd(new ProductsExport);
        return Excel::download(new ProductsExport, 'products.xlsx');

        
    }
}
