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
 //   protected $hidden = ['rates','unit','measurementable_type','measurementable_id','unit_id','created_at','updated_at'];
//    protected $appends=[
//        'unit_name',
//        'unit_symbol'
//    ];
    protected $casts=[
        'status'=>'boolean'
    ];
    public function unit(){
        return $this->hasOne(Unit::class,'id','unit_id');
    }


    public function getUnitNameAttribute(){

        return $this->unit->name;
    }
    public function getUnitSymbolAttribute(){

        return $this->unit->symbol;
    }

}
