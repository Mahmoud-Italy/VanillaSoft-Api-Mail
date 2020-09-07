<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'image'         => ($this->image) ? request()->root() . '/uploads/' . $this->image->url : NULL,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'short_body'    => $this->short_body,
            //'body'          => $this->body,


            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,

            'body1'         => $this->body1,
            'body2'         => $this->body2,
            'body3'         => $this->body3,
            'body4'         => $this->body4,
            'body5'         => $this->body5,
            'body6'         => $this->body6,
        ];
    }
}
