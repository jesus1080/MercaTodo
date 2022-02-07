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

class ProductController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request):Response
    {
        $products = Product::paginate(4);
        if(Arr::has($request->session()->all(),'info')){
            $info = $request->session()->all()['info'];
            return Inertia::render('Products',compact('products','info'));
        }else{
            return Inertia::render('Products',compact('products'));
        }
        
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('CreateProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|between:0,9999999',
            
            'description' => 'required|string|max:255',
            'stock' => 'required|between:0,9999999',
        ]);
        //dd($request);
        $image = $request->image;
        $imageName = (string)Str::uuid().'.'.$image->getClientOriginalExtension();
       
       
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => 'public/storage/products_images/'.$imageName,
            'description' => $request->description,
            'stock' => $request->stock,
        ]);
        //dd($product);
        event(new Registered($product));
        $image->storeAS('public/products_images',$imageName);
        $message = "Se creo el producto correctamente";
        return redirect(route('products.index'))->with('info',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //$products = Product::where("status","=",true)->paginate(5);
        $products = Product::name($request->input('name'))->where("status","=",true)->paginate(3);
        return Inertia::render('ProductsShow',compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return Inertia::render('EditProduct',['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
       
        //dd($request->parameters->name);
        dd( $request->input('name'));
        
        $product->update([

            'name' => $request['form']['name'],
           
            'stock' => $request['form']['stock'],
            'price' => $request['form']['price'],
            'description' => $request['form']['description'],
            'status' => $request['form']['status'],

        ]);

        if($request->hasFile('form')){
            //dd($product->getImageName());
            Storage::delete('public/products_images/'.$product->getImageName());
            $image = $request['form']['image'];  
            $imageName = (string)Str::uuid().'.'.$image->getClientOriginalExtension();
            $image->storeAS('public/products_images',$imageName);
            $product->update([
                'image' => 'public/storage/products_images/'.$imageName,
            ]);
            
        }
        return Redirect::route('products.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
