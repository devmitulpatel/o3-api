<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends PlainResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'token'      => $this->token,
            'type'       => $this->type,
            'name'       => $this->name,
            'os_version' => $this->os_version,
        ];
    }
}
