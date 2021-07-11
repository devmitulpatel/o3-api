<?php


namespace App\Traits;


use App\Models\Measurement;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;


trait Measurmentable
{

    private $indexedMeasurementsCollection;
    public static function bootMeasurmentable(){

        static::deleted(function (self $model) {
          
            $model->purgeMeasurement();
        });

    }

    public function measurements():MorphMany{
        return $this->morphMany(Measurement::class,'measurementable');
    }
    public function measurementable(){
        return $this->morphTo();
    }

    public function addMeasurement($value,$unit=null){

        $findUnit=Unit::orWhere('name',$unit)->orWhere('symbol',$unit)->orWhere('id',$unit);
        if($unit===null || !$findUnit->count())return;
        $findUnit=$findUnit->first()->id;
        if($this->measurements()->where('unit_id',$findUnit)->count())return;
        $this->makeMeasurement($findUnit,$value);
    }

    public function removeMeasurement($value){
        $this->measurements()->Where('unit_id',$value)->delete();
    }


    private function getMeasurementCollection()
    {
        if (!$this->relationLoaded('measurements')) {
            $this->setRelation('measurements', $this->measurements()->get());
        }

        return $this->indexedMeasurementsCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function setMeasurementRelation($relation, $value)
    {
        if ($relation == 'measurements') {
            $this->indexedMeasurementsCollection = $value;
        }
        return parent::setRelation($relation, $value);
    }

    /**
     * Set the entire relations array on the model.
     *
     * @param  array  $relations
     * @return $this
     */

    public function setMeasurementRelations(array $relations)
    {

        // keep the meta relation indexed by key.
        if (array_key_exists('measurements',$relations)) {
            $this->indexedMeasurementsCollection = (new Collection($relations['measurements']));
        } else {
            $this->indexedMeasurementsCollection = $this->makeMeasurement()->newCollection();
        }

        return parent::setRelations($relations);
    }

    protected function getMeasurementClassName():string{
        return Measurement::class;
    }

    protected function makeMeasurement(int $unit =0,float $value = 1): Measurement
    {
        $className = $this->getMeasurementClassName();

        $measurement = new $className([
            'unit_id' => $unit,
            'value' => $value,
        ]);
        $measurement->measurementable_type = $this->getMorphClass();
        $measurement->measurementable_id = $this->getKey();
        $measurement->save();
        return $measurement;
    }


    public function purgeMeasurement(): void
    {
        dd($this->measurements()->delete());
        $this->measurements()->delete();
        $this->setRelation('measurements', $this->makeMeasurement()->newCollection([]));
    }



}