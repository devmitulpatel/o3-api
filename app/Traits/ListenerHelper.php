<?php


namespace App\Traits;


use App\Models\User;

trait ListenerHelper
{
    public function setEvent($event): void
    {
        $this->event = $event;
    }

    public function get($key){
        return $this->event->$key;
    }
    private function user():User{return $this->get('user');}
    private function log($action,$type){
        logger()->debug(implode(' ',[$action,$type,'Sent for User ID:',$this->user()->id,'on',$this->user()->email]));
    }
}