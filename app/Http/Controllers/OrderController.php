<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'per_page' => ['sometimes', 'required', 'integer'],
            'name' => ['sometimes', 'required', 'string'],
            'phone' => ['sometimes', 'required', 'string'],
            'address' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'string'],
            'user_id' => ['sometimes', 'required', 'integer'],
        ]);

        $order = Order::with('product');
        if ($request->has('user_id')) $order->where('user_id', $request->user_id);
        if ($request->has('name')) $order->where('name', 'like', "%{$request->name}%");
        if ($request->has('phone')) $order->where('phone', 'like', "%{$request->phone}%");
        if ($request->has('address')) $order->where('address', 'like', "%{$request->address}%");
        if ($request->has('email')) $order->where('email', 'like', "%{$request->email}%");
        if ($request->has('product_id'))  $order->where('product_id',$request->product_id);;

        $order = $order->orderBy('id' , 'DESC')->paginate($request->per_page??Order::PerPage);

        return response()->json($order);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'per_page' => ['required', 'integer'],
            'name' => [ 'required', 'string'],
            'phone' => ['required', 'string'],
            'address' => ['sometimes', 'required', 'string'],
            'email' => ['nullable', 'string'],
            'product_id' => ['required' , 'integer']
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        Order::create($data);
        return response()->json('ok');

    }

    public function delete($id){
       $order = Order::findOrFail($id);
       $order->delete();
       return response()->json('ok');
    }
}
