<?php

namespace App\Listeners;

use App\Mail\SendWelcomeAfterRegister;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail
{
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //$this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user->email)->send(new SendWelcomeAfterRegister($event->user));
    }
}
