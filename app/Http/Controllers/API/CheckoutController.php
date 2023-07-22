<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CheckoutResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        if(Auth::user()->role_id !== 2){
            return response()->json([
                'status' => 'Error has occured...',
                'message' => 'You are not authorized to make this request',
                'data' => ''
            ], 403);
        }
        
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        
        $order = Order::create([
            'user_id' => $user->id,
            'date' => now(),
            'order_status_id' => 1,
            'total' => 0,
            // Add other relevant data from the form or cart items.
        ]);
        
        $totalPrice = 0;
        
        foreach ($cartItems as $cartItem) {
            $orderLine = OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'qty' => $cartItem->qty,
                'price' => $cartItem->product->price,
            ]);
            $product = Product::find($cartItem->product_id);
            $product->update([
                'qty' => $cartItem->product->qty - $cartItem->qty,
            ]);
            $totalPrice += $cartItem->qty * $cartItem->product->price;
        }
        $order->update([
            'total' => $totalPrice,
        ]);
        Cart::where('user_id', $user->id)->delete();
        return new CheckoutResource($order);
    }
}
