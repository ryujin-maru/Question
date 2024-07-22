<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\T_user;

class MailController extends Controller
{
    public function send_mail(Request $request)
    {
        $idno = $request->session()->get('idno');
        $user = T_user::where('idno',$idno)->orderBy('id','desc')->first();
        $data = [
            'name' => $user->name,
            'name_kana' => $user->name_kana,
            'email' => $user->email,
        ];
        return view('mail.complete');
    }
}
