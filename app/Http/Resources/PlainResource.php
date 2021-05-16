<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlainResource extends JsonResource
{

    public static $wrap="data";
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        $base=parent::toArray($request);

        $withPagination=[
            'data'=>array_get($base,'data'),
           'meta'=>[
               'current_page'=>$base['current_page'],
               'per_page'=>$base['per_page'],
               'from'=>$base['from'],
               'to'=>$base['to'],
               'total'=>$base['total'],
               'last_page'=>$base['last_page'],
           ]
           ];
        return $withPagination;
    }
}
