<?php


namespace App\Traits;


use App\Models\Reversible as ReversibleModel;
use App\Models\ReversibleLog;

trait Reversible
{
    public static $isolated;

    public static function bootReversible():void{


        static::deleting(function ($row) {

            if(get_class($row)!=ReversibleModel::class || get_class($row)!=ReversibleLog::class)
                ReversibleModel::create([
                'reversible_type'=>get_class($row),
                'reversible_id'=>$row->id,
                'user_id'=>user()->id(),
                'company_id'=>company()->id(),
                'data'=>collect($row->getRawOriginal())->toJson(),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);


            if(get_class($row)==ReversibleModel::class)
                ReversibleLog::create([
                    'reversible_type'=>get_class($row),
                    'reversible_id'=>$row->id,
                    'user_id'=>user()->id(),
                    'company_id'=>company()->id(),
                    'data'=>collect($row->getRawOriginal())->toJson(),
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        });

    }

    public function scopeIsolated($query,$isolated=null){
        if($isolated==null||($isolated!=null && !$isolated))return $query;
        return $query
            ->where('user_id',auth()->id())
            ->where('company_id',company()->id());
    }

    public static function magicRestore(ReversibleModel $reversible){

        $class=$reversible->reversible_type;
        $model=new $class();
        $model->fill(json_decode($reversible->data,true));
        $model->save();
        dd($reversible->delete());
    }

    public static function availableForRestore(){
        return ReversibleModel::query()
            ->Isolated(static::$isolated)
            ->where('reversible_type',static::class);
    }

    public static function availableForRestoreLog(){
        return ReversibleLog::query()-Isolated(static::$isolated);
    }


}