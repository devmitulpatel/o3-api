<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use App\Traits\ListenerHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NewUserCreatedFromApi implements ShouldQueue
{
    use ListenerHelper;
    public $event;
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
     * @param  NewUserCreated  $event
     * @return void
     */
    public function handle(NewUserCreated $event)
    {
        $this->setEvent($event);
        $this->sendWelcomeEmail();
        $this->sendWelcomeSMS();
    }


    private function sendWelcomeEmail(){
        $this->user()->update(['email_verified_at'=>now()]);
        $this->log('Welcome','email');
    }
    private function sendWelcomeSMS(){
        $this->log('Welcome','sms');
    }

}
