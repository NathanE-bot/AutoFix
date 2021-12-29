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
                'message' => 'User does not exists. Please input another email.'
            ], 404);
        }

        $token = Str::random(10);

        try {

            DB::table('password_resets')->insert([
                'email' => $emailInput,
                'token' => $token
            ]);
    
            $userDetail = DB::table('password_resets')
                        ->join('users','users.email','=','password_resets.email')
                        ->where('token', '=', $token)
                        ->get();
            \Mail::to($emailInput)->send(new \App\Mail\resetPasswordMail($userDetail));

        } catch (Exception $err){
            return response()->json($err, 500);
        }

        return response()->json([
            'message' => 'Reset password link sucessfully sent to your email. Please check your email.'
        ], 200);
    }

    public function reset(Request $request){

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'id' => 1,
                'message'=>$validator->errors()
            ], 401);
        }

        $token = $request->input('token');

        if(!$passwordResets = DB::table('password_resets')->where('token', $token)->first()){
            
            return response()->json([
                'id' => 2,
                'message' => 'Invalid Token. Try to resend email to get new link.'
            ], 401);
        }

        /** @var User $user */
        if(!$user = User::where('email', $passwordResets->email)->first()){
            return response()->json([
                'id' => 3,
                'message' => 'User does not exist.'
            ], 404);
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();

        try{
            
            $data = DB::table('password_resets')->where('token', $token)->delete();

        }catch (Exception $error) {
            return response()->json($error, 500);
        }

        return response()->json([
            'id' => 5,
            'message' => 'Successfully reset password.'
        ], 200);
    }

    public function checkTokenResetPassword (Request $request) {

        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()
            ], 401);
        }

        $token = $request->input('token');

        if(!$passwordResets = DB::table('password_resets')->where('token', $token)->first()){
            
            return response()->json([
                'message' => 'token invalid'
            ], 401);
        }

        return response()->json([
            'message' => 'token valid'
        ], 200);
    }
}