<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_slug' => $this->product_slug,
            'product_description' => $this->product_description,
            'product_status' => $this->product_status,
            'price' => $this->price,
            'weight' => $this->weight,
            'option1' => $this->option1,
            'value1' => $this->value1,
            'option2' => $this->option2,
            'value2' => $this->value2,
        ];
    }
}
