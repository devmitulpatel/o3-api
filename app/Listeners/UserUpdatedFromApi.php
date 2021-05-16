<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Traits\ListenerHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserUpdatedFromApi implements ShouldQueue
{
    use ListenerHelper;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        $this->setEvent($event);
        $this->sendEmail();
        $this->sendSMS();
    }

    private function sendEmail(){
        $this->log('Update','email');
    }
    private function sendSMS(){
        $this->log('Update','sms');
    }


}
