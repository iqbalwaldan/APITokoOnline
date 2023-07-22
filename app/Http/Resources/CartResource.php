<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'qty' => $this->qty,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'user_id' => (string)$this->user->id,
                'user_name' => $this->user->name,
                'product_id' => (string)$this->product->id,
                'product_name' => $this->product->name,
                'product_price' => $this->product->price,
            ],
        ];
    }
}
