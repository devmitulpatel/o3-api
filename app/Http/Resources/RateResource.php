<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        //return parent::toArray($request);
        return [
            'currency'=>CurrencyResource::make($this->currency),
            'rate'=>$this->rate,
            'unit'=>UnitResource::make($this->unit),
            'qt'=>$this->qt,
            'cost'=>$this->cost

        ];
    }
}
