<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    private $reviewFlag = false;

    public function withReviews() {
        $this->reviewFlag = true;
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
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
        ];

        if ($this->reviewFlag) {
            $response['reviews'] = ReviewResource::collection($this->reviews);
        }

        return $response;
    }
}
