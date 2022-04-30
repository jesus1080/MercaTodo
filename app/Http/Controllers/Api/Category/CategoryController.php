<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::paginate(5);
        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = Category::create(
            [
                'name' => $request->name
            ]
        );
        event(new Registered($category));

        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category): CategoryResource
    {
       $category -> update([
            'name' => $request->input('name')
       ]); 
       $category->save();
       return new CategoryResource($category);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
                'message' => 'categoria elimninada'
        ]);
    }
}
