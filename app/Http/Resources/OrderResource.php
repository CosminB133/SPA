<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    protected $products;

    public function setProducts($products){
        $this->products = ProductResource::collection($products);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'contact' => $this->contact,
            'comments' => $this->comments,
            'price' => $this->price,
            'created_at' => $this->created_at,
        ];

        if ($this->products){
            $response += [
                'products' => $this->products,
            ];
        }

        return $response;
    }
}
