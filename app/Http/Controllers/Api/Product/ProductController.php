<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::paginate(10);
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request): ProductResource
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
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->category_id = (int)$request->categoryId;

        if ($request->hasFile('image')) {

            Storage::delete('public/products_images/'.$product->getImageName());
            $image = $request->image;
            $imageName = (string)Str::uuid().'.'.$image->getClientOriginalExtension();
            $image->storeAS('public/products_images', $imageName);
            $product->image = 'public/storage/products_images/'.$imageName;
            
        }
        $product->save();
        return response()->json([
            'message' => 'producto actualizado'
        ]);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
                'message' => 'producto elimninado'
        ]);
    }
}
