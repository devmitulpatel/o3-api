<?php

namespace App\Models;

use App\Traits\HasCompany;
use App\Traits\Measurmentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Measurmentable;
    use HasCompany;
    protected $hidden = ['measurements'];

    public $fillable=['name', 'description', 'company_id'];

    public $appends=['price'];

    public function getPriceAttribute():array{
        $data=[];
        foreach ($this->measurements as $measurement){
            $data[]=[
                'unit'=>$measurement->unit->name,
                'unit_symbol'=>$measurement->unit->symbol,
                'price'=>$measurement->rates->rate,
                'currency'=>$measurement->rates->currency->name,
                'currency_symbol'=>$measurement->rates->currency->symbol,
            ];
        }
        return $data;
    }
}
