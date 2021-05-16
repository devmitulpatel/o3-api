<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $base=[
            'id'=>$this->id,
            'name'=>$this->name,
            'company_type'=>$this->whenLoaded('companyType')->name,
            'pan'=>strtoupper($this->pan),
            'tan'=>strtoupper($this->tan),
            'gst'=>strtoupper($this->gst),
            'register_no'=>strtoupper($this->register_no),
            ];



       return $base;

    }

}
