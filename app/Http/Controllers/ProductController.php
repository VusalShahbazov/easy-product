<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $this->validate($request , [
            'title' => ['nullable' , 'string'  , 'max:255'],
            'category_id' => ['nullable' , 'integer'],
            'per_page' => ['nullable' , 'integer']
        ]);
        $products = Product::with(['category']);
        if ($request->has('title')) $products->where('title' , 'like' , "{$request->title}%");
        if ($request->has('category_id')) $products->where('category_id'  , $request->category_id);

        $products = $products->orderBy('id','DESC')->paginate($request->per_page??Product::PerPage);

        return response()->json($products);
    }

    public function store(Request $request){
        $this->validate($request , [
            'title' => ['required' , 'string'  , 'max:255'],
            'category_id' => ['required' , 'integer'],
            'description' => ['nullable' , 'text'],
            'count' => ['required' , 'integer'],
        ]);
        $product = Product::create($request->all());
        return response()->json($product);

    }

    public function show($id){
        return Product::findOrFail($id);
    }

    public function update(Request $request , $id){
        $this->validate($request , [
            'title' => ['nullable' , 'string'  , 'max:255'],
            'category_id' => ['nullable' , 'integer'],
            'description' => ['nullable' , 'text'],
            'count' => ['nullable' , 'integer'],
            'is_active' => ['sometimes','required' , 'boolean']
        ]);
        $product = Product::findOrFail($id);

        $product->fill($request->all());

        if ($request->has('is_active')) $product->is_active = $request->is_avtive;

        if ($product->isClean()) return response()->json(trans('response.nothingToUpdate'));

        $product->save();

        return response()->json('ok');


    }

    public function delete($id){
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json('ok');
    }
}
