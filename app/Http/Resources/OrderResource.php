<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    private $productsFlag = false;

    public function withProducts()
    {
        $this->productsFlag = true;
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

        if ($this->productsFlag) {
            $response['products'] = ProductResource::collection($this->products);
        }

        return $response;
    }
}
