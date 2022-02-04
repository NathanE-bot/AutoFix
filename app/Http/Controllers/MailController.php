<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\otpMail;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{
    public function index(Request $req){
        $details = [
            'title' => 'Mail from websitepercobaan.com',
            'body' => 'This is for testing email using smtp'
            ];
            $req ->num;
            DB::table('users')
            ->where('id','=',$req->id)
            ->get();
            \Mail::to('email')->send(new \App\Mail\otpMail($details));
            
            $data = dd("Email sudah terkirim.");

            try {
                return response()->json($data, 200);
            } catch (Exception $err){
                return response()->json($err, 500);
            }
    }
}
