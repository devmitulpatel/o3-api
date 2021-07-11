<?php

namespace App\Http\Resources;

use App\Models\Measurement;
use App\Models\Rate;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


       // return parent::toArray($request);


        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'meta'=>MetaResource::collection($this->meta),
            'measurements'=>MeasurementResource::collection($this->measurements),
            'rates'=>RateResource::collection($this->getRates()),
        ];


    }
    private function getRates():array{
        $rates=[];
        $this->measurements->each(function ($array)use(&$rates){
            if($array->rates->count()>0){
                foreach ($array->rates as $rate){
                    $key=count($rates)+1;
                    $rates[$key]=$rate;
                    $rates[$key]['unit']=$array->unit;
                    $rates[$key]['qt']=$array->value;
                    $rates[$key]['cost']=$rate->rate*$array->value;

                }
            }
        });
        return$rates;
    }
}
