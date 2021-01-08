<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreUpdateProductFormRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $product;
    protected $path = 'products';

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $products = $this->product->getResults($request->all(), 15);

        return response()->json($products);
    }


    public function store(StoreUpdateProductFormRequest $request)
    {

        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = kebab_case($request->name);
            $extension = $request->image->extension();

            $nameFile = "{$name}.{$extension}";

            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile);

            if (!$upload)
                return response(['error' => 'Fail_upload'], 500);
        }

        $product = $this->product->create($data);

        return response()->json($product, 201);
    }


    public function show($id)
    {
        $product = $this->product->with('category')->find($id);

        if (!$product)
            return response()->json(['error' => 'Not found'], 404);

        return response()->json($product);
    }


    public function update(StoreUpdateProductFormRequest $request, $id)
    {
        $product = $this->product->find($id);
        if (!$product)
            return response()->json(['error' => 'Not found'], 404);

        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            // Subistitui a imagem antiga pela atual

            if ($product->image) {
                
                if (Storage::exists("{$this->path}/{$product->image}")){
                    Storage::delete("{$this->path}/{$product->image}");
                }

            }

            $name = kebab_case($request->name);
            $extension = $request->image->extension();

            $nameFile = "{$name}.{$extension}";

            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile);

            if (!$upload)
                return response(['error' => 'Fail_upload'], 500);
            
        }

        $product->update($data);

        return response()->json($product);
    }


    public function destroy($id)
    {
        $product = $this->product->find($id);

        if (!$product)
            return response()->json(['error' => 'Not found'], 404);

        if ($product->image) {
            if (Storage::exists("{$this->path}/{$product->image}"))
                Storage::delete("{$this->path}/{$product->image}");
        }

        $product->delete();

        return response()->json(['success' => true], 204);
    }
}
