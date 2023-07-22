<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(
            Product::get()
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
    public function store(StoreProductRequest $request)
    {
        if(Auth::user()->role_id !== 1){
            return response()->json([
                'status' => 'Error has occured...',
                'message' => 'You are not authorized to make this request',
                'data' => ''
            ], 403);
        }

        $request->validated($request->all());

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->qty,
        ]);

        return new ProductResource($product);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
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
    public function update(Request $request, Product $product)
    {
        if(Auth::user()->role_id !== 1){
            return response()->json([
                'status' => 'Error has occured...',
                'message' => 'You are not authorized to make this request',
                'data' => ''
            ], 403);
        }

        $product->update($request->all());
        
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return $this->isNotAuthorized($product) ? $this->isNotAuthorized($product) : $product->delete();
    }

    private function isNotAuthorized($product) {
        if(Auth::user()->role_id !== 1){
            return response()->json([
                'status' => 'Error has occured...',
                'message' => 'You are not authorized to make this request',
                'data' => ''
            ], 403);
        }
    }
}
