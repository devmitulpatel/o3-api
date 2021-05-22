<?php

namespace Database\Factories;

use App\Models\Company;
use App\Traits\CompanyTestHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    use CompanyTestHelper;
    private $random=[];
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    public function definition()
    {
        return [
            //
            'tan'=>$this->getRandomTan(),
            'pan'=>$this->getRandomPan(),
            'gst'=>$this->getRandomGst(),
            'ref_code'=>Str::random(12),
        ];
    }


}
