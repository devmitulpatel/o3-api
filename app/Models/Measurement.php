<?php

namespace App\Models;

use App\Traits\HasRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;
    use HasRate;
    protected $guarded = [];

    protected $appends=['price'];

    public function unit(){
        return $this->hasOne(Unit::class,'id','unit_id');
    }

    public function getPriceAttribute():array{
        $data=[];
        foreach ($this->rates as $rate){
            $data= [
                    'price'=>$this->value*$rate->rate,
                    'rate'=>$rate->rate,
                    'qt'=>$this->value,
                    'currency'=>$rate->currency->name,
                    'currency_symbol'=>$rate->currency->symbol,
                ];
                $this->value*$rate->rate;
        }
        return $data;
    }

}
