<?php


namespace App\Traits;


use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

trait TestHelper
{

    use CompanyTestHelper;
    public function createApplication()
    {
        $array=explode(DIRECTORY_SEPARATOR,__DIR__);
        array_pop($array);
        array_pop($array);
        $array[]='bootstrap';
        $array[]='app.php';

        $app = require implode(DIRECTORY_SEPARATOR,$array);

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function getTestUser($roleId, $hidden = []): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $user = [
            'email' => $this->faker->email,
            'first_name' => $this->faker->firstName($gender),
            'last_name' => $this->faker->lastName,
            'company_name' => $this->faker->company,
            'gender' => $gender,

        ];
        if ($roleId == 3 && !in_array('ref_code', $hidden)) {
            $this->seedFirst();
            $user['ref_code'] = Company::first()->ref_code;
        }
        return $user;
    }

    public function getValidUser($role=null):array{

        $user=$this->getUser();
        return [
            'email'=>$user->email,
            'password'=>'password'
        ];
    }


    public function getUser($id=null):User{
        $this->seedFirst();
        $user=User::all()->first()->load(['companyAssociates']);
        return $user;
    }


    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function signIn($user = null):self
    {
        $user = $user ?: User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        return $this;
    }

    protected function getUrl($path):string{
        $base='api/v1';
        return implode('/',[$base,(is_array($path))?implode('/',$path):$path]);
    }

    public function seedFirst():void{
    //    Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
    }

    public function getCompany($data=[],$hidden=[]){
        $newData= [
            'name'=>$this->optional_array('name',$data,$this->faker->company),
            'company_type'=>$this->optional_array('company_type',$data,1),
            'pan'=>$this->optional_array('pan',$data,$this->getRandomPan()),
            'tan'=>$this->optional_array('tan',$data,$this->getRandomTan()),
            'gst'=>$this->optional_array('gst',$data,$this->getRandomGst()),
            'register_no'=>$this->optional_array('register_no',$data),
        ];
        foreach ($hidden as $key){
            if(array_key_exists($key,$newData))unset($newData[$key]);
        }
        return $newData;

    }

    public function optional_array(String $key,Array $array,$default=null){

        return array_key_exists($key,$array)?$array[$key]:$default;
    }
}