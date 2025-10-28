<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToUser
{
    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $user_name = $event->user->name;

        Mail::to('user@example.com')->send(new WelcomeUser($user_name));
    }
}
