<?php


namespace App\Traits;


use App\Models\Currency;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Model;

trait HasRate
{

    public function rates(){
        return $this->morphOne(Rate::class,'rateable');
    }

    public function addRate($rate,$currency=null){
        if($currency===null)$currency=Currency::where('base_rate',1)->first()->id;
        if($currency!==null && !Currency::orWhere('name',$currency)->orWhere('symbol',$currency)->orWhere('id',$currency)->count())return;
        if($this->rates()->count()|| $this->rates()->where('rate',$rate)->count())return;
        $rateModel=new Rate();
        $rateModel->currency_id=$currency;
        $rateModel->rate=$rate;
        $this->rates()->save($rateModel);
    }

    public function removeRate($rate){
        $this->rates()->where('rate',$rate)->delete();
    }

}