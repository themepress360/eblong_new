<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralEmailMailable;

class SendPasswordResetEmail
{
    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     *
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        $user = $event->user;
        // print_r("<pre>");
        // print_r($user['email']);
        // exit();
        // Mail::to($user)->send(new GeneralEmailMailable(
        //         'reset_password_email',
        //         $template_data,
        //         $email_params
        //         )
        // );
        Mail::to($user)->send(new  GeneralEmailMailable('reset_password_email','',['name' => $user['first_name'],'email' => $user['email'],'password' => $user['password']]));
        // Mail::to($user)
        //     ->send(new PasswordResetEmail($user));
    }
}