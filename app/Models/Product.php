<?php

namespace App\Models;

use App\Http\Resources\MetasResource;
use App\Traits\HasCompany;
use App\Traits\Measurmentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Metable\Metable;


class Product extends Model
{
    use HasFactory;
    use Measurmentable;
    use HasCompany;
    use Metable;
   // protected $hidden = ['measurements','created_at','updated_at','company_id','status','meta'];

    public $fillable=['name', 'description', 'company_id'];


    //public $appends=['price','measurement','metas'];



    public function getMetasAttribute(){
        return MetasResource::collection($this->meta);
    }

    public function getPriceAttribute():array{
        $data=[];
       $k=0;

        foreach ($this->measurements as $measurement){
//            $data[$k]=[
//                'unit'=>$measurement->unit->name,
//                'unit_symbol'=>$measurement->unit->symbol,
//
//            ];

            if($measurement->rates!==null){
                $data[$k]=[];
                $data[$k]=array_merge($data[$k],[
                    'price'=>$measurement->rates->rate,
                    'currency'=>$measurement->rates->currency->name,
                    'currency_symbol'=>$measurement->rates->currency->symbol,
                ]);
            }
            $k++;
        }
        return $data;
    }

    public function getMeasurementAttribute(){
        return $this->measurements;
    }
}
