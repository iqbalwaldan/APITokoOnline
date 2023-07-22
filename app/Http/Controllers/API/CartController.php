<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CartResource::collection(
            Cart::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        
        $request->validated($request->all());

        $product = Product::find($request->product_id);
        if ($request->qty <= $product->qty){
            $cart = Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
            ]);
    
            return new CartResource($cart);
        }
        return response()->json([
            'status' => 'Error has occured...',
            'message' => 'Product quantity is not enough',
            'data' => ''
        ], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        if(Auth::user()->id !== $cart->user_id){
            return response()->json([
                'status' => 'Error has occured...',
                'message' => 'You are not authorized to make this request',
                'data' => ''
            ], 403);
        }
        return new CartResource($cart);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
