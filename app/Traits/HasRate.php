<?php


namespace App\Traits;


use App\Models\Currency;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Query\JoinClause;
use Plank\Metable\Metable;

trait HasRate
{

    private $indexedRateCollection;

    public static function bootHasRate(){
        static::deleted(function (self $model) {
            $model->purgeRate();
        });
    }
    public function rates(): MorphMany{
        return $this->morphMany(Rate::class,'rateable');
    }
   public function rate(): MorphOne{
        return $this->morphOne(Rate::class,'rateable');
    }

    public function rateable()
    {
        return $this->morphTo();
    }

    public function addRate($rate,$currency=null){
        if($currency===null)$currency=Currency::where('base_rate',1)->first()->id;
        if($currency!==null && !Currency::orWhere('name',$currency)->orWhere('symbol',$currency)->orWhere('id',$currency)->count())return;
        if (is_object($rate) && get_class($rate)==Rate::class){
            if($this->rates()->count()|| $this->rates()->where('rate',$rate->rate)->count())return;
            $this->rates()->save($rate);
            return;
        }
        if($this->rates()->count()|| $this->rates()->where('rate',$rate)->count())return;
        $rateModel=new Rate();
        $rateModel->currency_id=$currency;
        $rateModel->rate=$rate;
        $this->rates()->save($rateModel);
    }

    public function removeRate($rate){
        $this->rates()->where('rate',$rate)->delete();
    }

    public function removeAllRate(){
        $this->rates()->delete();
    }




    private function joinRatesTable(Builder $q, string $key, $type = 'left'): string
    {
        $relation = $this->rates();
        $table = $relation->getRelated()->getTable();

        // Create an alias for the join, to allow the same
        // table to be joined multiple times for different keys.
        $alias = $table . '__' . $key;

        // If no explicit select columns are specified,
        // avoid column collision by excluding meta table from select.
        if (!$q->getQuery()->columns) {
            $q->select($this->getTable() . '.*');
        }

        // Join the meta table to the query
        $q->join("{$table} as {$alias}", function (JoinClause $q) use ($relation, $key, $alias) {
            $q->on($relation->getQualifiedParentKeyName(), '=', $alias . '.' . $relation->getForeignKeyName())
                ->where($alias . '.key', '=', $key)
                ->where($alias . '.' . $relation->getMorphType(), '=', $this->getMorphClass());
        }, null, null, $type);

        // Return the alias so that the calling context can
        // reference the table.
        return $alias;
    }



    protected function getRateClassName():string{
        return Rate::class;
    }

    protected function makeRate(float $rate = 0.0,int $currency = 1): Rate
    {
        $className = $this->getRateClassName();

        $rate = new $className([
            'rate' => $rate,
            'currency_id' => $currency,
        ]);
        $rate->rateable_type = $this->getMorphClass();
        $rate->rateable_id = $this->getKey();

        return $rate;
    }


    public function purgeRate(): void
    {
        $this->removeAllRate();
        $this->setRelation('rate', $this->makeRate()->newCollection([]));
    }

}