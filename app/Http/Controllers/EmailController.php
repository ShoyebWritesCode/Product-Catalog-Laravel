<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;

// class EmailController extends Controller
// {
//     public function sendEmail()
//     {
//         $name = auth()->user()->name;
//         $email = auth()->user()->email;
//         Mail::to($email)->send(new MyEmail($name));

//         return response()->json(['message' => 'Email sent successfully!']);
//     }
// }
