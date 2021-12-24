<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use App\User;
use DB;

class ForgotPasswordController extends Controller
{
    //
    public function forgot(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ], 401);
        }

        $emailInput = $request->input('email');

        if(User::where('email', $emailInput)->doesntExist()){
            return response()->json([
                'errorMessage' => 'User does not exit. Please input another email.'
            ], 404);
        }

        $token = Str::random(10);

        DB::table('password_resets')->insert([
            'email' => $emailInput,
            'token' => $token
        ]);

        // Sending Email
        return response()->json([
            'message' => 'We have send an email to change your password, please check your email.'
        ], 200);
    }
}
