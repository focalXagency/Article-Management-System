<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
class MailController extends Controller
{
 public function index(){
    $mailData =[
        'title' =>'Mail from Articles site',
        'body' => 'Thanke you to use our site'
    ];
    Mail::to('mmm380616@gmail.com')->send(new DemoMail($mailData));
    
 } 
}
