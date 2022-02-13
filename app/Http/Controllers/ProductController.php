<?php

namespace App\Http\Controllers;

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

class ProductController extends Controller
{
    public function index(Request $request):Response
    {
        $products = Product::paginate(4);
        if(Arr::has($request->session()->all(),'info')){
            $info = $request->session()->all()['info'];
            return Inertia::render('Product/Products',compact('products','info'));
        }else{
            return Inertia::render('Product/Products',compact('products'));
        }
        
    }
  
    public function create():Response
    {
        return Inertia::render('Product/CreateProduct');
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
        ]);
        
        event(new Registered($product));
        $image->storeAS('public/products_images',$imageName);
        $message = "Se creo el producto correctamente";
        return redirect(route('products.index'))->with('info',$message);
    }

    
    public function show(Request $request):Response
    {
        $products = Product::name($request->input('name'))->where("status","=",true)->paginate(3);
        return Inertia::render('Product/ProductsShow',compact('products'));
    }

  
    public function edit(Product $product): Response
    {
        return Inertia::render('Product/EditProduct',['product'=>$product]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {   
        $product->update([

            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,

        ]);

        if($request->hasFile('image'))
        {
            Storage::delete('public/products_images/'.$product->getImageName());
            $image = $request->image;  
            $imageName = (string)Str::uuid().'.'.$image->getClientOriginalExtension();
            $image->storeAS('public/products_images',$imageName);
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
}
