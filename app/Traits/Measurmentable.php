<?php


namespace App\Traits;


use App\Models\Measurement;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;

trait Measurmentable
{

    public static function bootMeasurmentable(){
        //$this->setAttribute('measurementable_type',$this->getMeasurementableTypeAttribute());
    }

    public function measurements(){
        return $this->morphMany(Measurement::class,'measurementable');
    }

    public function addMeasurement($value,$unit=null){
        $findUnit=Unit::orWhere('name',$unit)->orWhere('symbol',$unit)->orWhere('id',$unit);
        if($unit===null || !$findUnit->count())return;
        $findUnit=$findUnit->first()->id;
        if($this->measurements()->where('unit_id',$findUnit)->count())return;
        $measuremnts=new Measurement();
        $measuremnts->unit_id=$findUnit;
        $measuremnts->value=$value;
        $this->measurements()->save($measuremnts);
    }

    public function removeRate($value){
        $this->measurements()->orWhere('unit_id',$value)->orWhere('id')->delete();
    }


}