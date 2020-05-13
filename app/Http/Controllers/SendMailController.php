<?php
// HomeController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Illuminate\Http\Request;

class SendMailController extends Controller {

public function index(){

   return view('email');

}   

function send(Request $request)
    {
     $this->validate($request, [
      'name'     =>  'required',
      'email'  =>  'required|email',
      'message' =>  'required'
     ]);

        $data = array(
            'name'      =>  $request->name,
            'message'   =>   $request->message,
           
        );

     Mail::to($request->email)->send(new  SendMailable($data));
     return back()->with('success', 'Thanks for contacting us!');

    }


/* public function mail()
{
   $name = 'Themepress';
   Mail::to('muhammadalidanwar@gmail.com')->send(new SendMailable($name));
   
   return 'Email was sent';
} */

}