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
                'message' => 'User does not exit. Please input another email.'
            ], 404);
        }

        $token = Str::random(10);

        try {

            DB::table('password_resets')->insert([
                'email' => $emailInput,
                'token' => $token
            ]);
    
            // $tokenForURL = DB::table('password_resets')->where('token', '=', $token)->pluck('token');
            $userDetail = DB::table('password_resets')
                        ->join('users','users.email','=','password_resets.email')
                        ->where('token', '=', $token)
                        ->get();
            // $tes = $userDetail[0]->email;
            \Mail::to($emailInput)->send(new \App\Mail\resetPasswordMail($userDetail));

            // dd($tes);

            return response()->json([
                'message' => 'Reset password link sucessfully sent to your email. Please check your email.'
            ], 200);

        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function reset(Request $request){

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ], 401);
        }

        $token = $request->input('token');

        if(!$passwordResets = DB::table('password_resets')->where('token', $token)->first()){
            
            return response()->json([
                'message' => 'Invalid Token. Please try to resend email for reset password.'
            ], 401);
        }

        /** @var User $user */
        if(!$user = User::where('email', $passwordResets->email)->first()){
            return response()->json([
                'message' => 'User does not exist.'
            ], 404);
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json([
            'message' => 'Successfully reset password.'
        ]);
    }
}