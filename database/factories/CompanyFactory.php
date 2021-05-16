<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    private $random=[];
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'tan'=>$this->getRandomTan(),
            'pan'=>$this->getRandomPan(),
            'gst'=>$this->getRandomGst()
        ];
    }

    private function getRandomTan(){
        $data=[
            $this->faker->randomLetter,
            $this->faker->randomLetter,
            $this->faker->randomLetter,
            $this->faker->randomLetter,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomLetter,
        ];
        return $this->random['tan']=implode('',$data);
    }

//"P" stands for Individual
//"C" stands for Company
//"H" stands for Hindu Undivided Family (HUF)
//"A" stands for Association of Persons (AOP)
//"B" stands for Body of Individuals (BOI)
//"G" stands for Government Agency
//"J" stands for Artificial Juridical Person
//"L" stands for Local Authority
//"F" stands for Firm/ Limited Liability Partnership
//"T" stands for Trust
    private function getRandomPan(){
        $type=['p','c','h','a','b','g','j','l','f','t'];
        $data=[
            $this->faker->randomLetter,
            $this->faker->randomLetter,
            $this->faker->randomLetter,
            array_random($type),
            $this->faker->randomLetter,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomLetter,
        ];
        return $this->random['pan']=implode('',$data);
    }

    private function getRandomGst(){
        $data=[
            sprintf("%02d", array_random(range(1,37))),
            $this->random['pan'],
            $this->faker->randomDigit,
            $this->faker->randomLetter,
            $this->faker->randomDigit,
        ];
        return $this->random['gst']=implode('',$data);

    }
}
