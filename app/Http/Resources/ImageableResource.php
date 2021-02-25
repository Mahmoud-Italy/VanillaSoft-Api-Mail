<?php

namespace App\Http\Resources;

use App\Models\Imageable;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageableResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'url'  => Imageable::getImagePath('inbox', $this->url),
            'name' => $this->name
        ];
    }
}
