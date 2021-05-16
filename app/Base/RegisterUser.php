<?php


namespace App\Base;


use App\Events\NewUserCreated;
use App\Events\UserUpdated;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use phpDocumentor\Reflection\Types\This;

class RegisterUser
{

    private $userData, $userRole, $foundUser;


    private $allowedMeta=[
        'gender',
        'phone',
    ];
    private $alwaysLowerMeta=[
        'gender',
    ];

    private $meta=[];
    public function __construct($user=null)
    {

        if(!auth()->check())switch (gettype($user)){
            case null;
            break;

            case 'integer';
            $this->setUser(User::findOrFail($user));
            break;

            case 'object';
            if(is_a($user,User::class))$this->setUser($user);
            break;

            default:

        }else{
            $this->setUser(auth()->user());
        }

}

    public static function getOptions()
    {
        return [];
    }

    public function create($type, $user)
    {
        $this->filter__create($type, $user);
        $this->setRole($type);
        $this->setUserData($user);
        $this->setUser(User::findOrCreate($user, 'email'));
        $this->getUser()->fill($user)->save();
        $this->getUser()->roles()->attach($type);
        if(count($this->meta))$this->getUser()->syncMeta($this->meta);
        NewUserCreated::dispatch($this->getUser());
        return $this->chain();
    }
    public function update($data)
    {
        $this->filter__user($data);
        $this->getUser()->update($data);
        UserUpdated::dispatch($this->foundUser);
        return $this->chain();
    }

    private function filter__create(&$type, &$user):void
    {
       $this->filter__user($user);
    }

    private function filter__user(&$user):void {
        foreach ($user as $k=>$v){
            if(in_array(strtolower($k), $this->allowedMeta, true)){
                $this->meta[$k]=(in_array(strtolower($k), $this->allowedMeta, true))?strtolower($v):$v;
                unset($user[$k]);
            }
        }
    }


    public function chain():self{
        return $this;
    }
    public function getUser():User{
        return $this->foundUser;
    }
    private function setUser(User $user):void{
        $this->foundUser=$user;
    }
    private function setRole(Role $role):void{
        $this->userRole = $role;
    }
    private function getRole(){
        return $this->userRole;
    }

    private function setUserData(array $data):void{
        $this->userData=$data;
    }
    private function getUserData():array{
        return $this->userData??[];
    }




}