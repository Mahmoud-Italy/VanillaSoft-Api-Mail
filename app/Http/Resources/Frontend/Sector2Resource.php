<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class Sector2Resource extends JsonResource
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
            'subTitle'      => $this->subTitle,
            'body'          => $this->body,
            //'childs'        => count($this->childs)
        ];
    }
}