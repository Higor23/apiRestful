<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateCategoryFormRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }


    public function index(Category $category, Request $request)
    {
        $categories = $this->category->where('name', 'LIKE', "%{$request->name}%")->get();

        return response()->json($categories);
    }

    public function store(StoreUpdateCategoryFormRequest $request)
    {
        $category = $this->category->create($request->all());

        return response()->json($category, 201);
    }

    public function update(StoreUpdateCategoryFormRequest $request, $id)
    {
        $category = $this->category->find($id);

        if (!$category)
            return response()->json(['error' => 'Not found'], 404);

        $category->update($request->all());

        return response()->json($category);
    }

    public function delete($id)
    {
        $category = $this->category->find($id);

        if (!$category)
            return response()->json(['error' => 'Not found'], 404);

        $category->delete();

        return response()->json([], 204);
        return response()->json(['success' => true], 204);
    }

    public function show($id)
    {
        $category = $this->category->find($id);

        if (!$category)
            return response()->json(['error' => 'Not found'], 404);

        return response()->json($category);
    }

    public function products($id)
    {
        $category = $this->category->find($id);
        // dd($category);

        if (!$category)
            return response()->json(['error' => 'Not found'], 404);

        $products = $category->products()->paginate();

        return response()->json([
            'category' => $category,
            'products' => $products,
        ]);
    }

    
}
