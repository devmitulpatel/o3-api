<?php


namespace App\Traits;


use App\Models\User;

trait PolicyHelper
{
    public function onlyAdmin(User $user){
        return $this->canDo($user,['admin']);
    }

    public function onlyUser(User $user){
        return $this->canDo($user,['user']);
    }

    public function onlySuperAdmin(User $user){
        return $this->canDo($user,['super_admin']);
    }

    public function aboveUser(User $user){
        return $this->canDo($user,['admin','super_admin']);
    }

    public function canDo(User $user,$roles=[]){
        return call_user_func([$user,'hasAnyRole'],$roles);
    }


}