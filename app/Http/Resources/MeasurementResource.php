<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementResource extends JsonResource
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
            'unit'=>UnitResource::make($this->unit),
           // 'rates'=>RateResource::make($this->rate??collect([])),
            'value'=>$this->value,

        ];
        return parent::toArray($request);
    }
}
