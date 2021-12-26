<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use App\User;
use DB;

class AuthenticationOTPContoller extends Controller
{
    public function SendOtp(Request $req){
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
