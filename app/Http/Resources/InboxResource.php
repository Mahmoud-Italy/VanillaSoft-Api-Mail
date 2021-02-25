<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use App\Http\Resources\ImageableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'encrypt_id'    => encrypt($this->id),

            'to'            => $this->to,
            'to_array'      => explode(",", $this->to),
            'subject'       => $this->subject,
            'body'          => $this->body,
            'short_body'    => Str::limit(strip_tags($this->body), 20,'..'),

            'timestamp'     => $this->created_at,
            'diffForHumans' => $this->created_at->diffForHumans(),

            'attachments'   => ($this->attachments) ? ImageableResource::collection($this->attachments) : [],
            'loading'       => false,
        ];
    }
}
