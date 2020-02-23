<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:255']
        ]);
        $category = Category::create();
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:255']
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return response()->json($category);
    }

    public function show(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'min:2', 'max:255']
        ]);
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function delete($id)
    {
        $category = Category::with([])->findOrFail($id);
        $category->delete();
        return response()->json('ok');
    }
}
