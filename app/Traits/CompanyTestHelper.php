<?php


namespace App\Traits;


use Illuminate\Support\Str;

trait CompanyTestHelper
{


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