<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'user_id' => $this->user->id,
                'user_name' => $this->user->name,
                'total' => $this->total,
                'status' => $this->orderStatus->name,
            ]
        ];
    }
}
