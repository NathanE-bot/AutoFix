<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'DoB'=>['required', 'Date'],
            'phoneNumber'=>['required','string','max:12'],
            'address'=>['required','string','max:255']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ], 401);
        }
        
        $formRegister = $request->all();
        $formRegister['password'] = bcrypt($formRegister['password']);
        $user = User::create($formRegister);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user, 
            'access_token' => $accessToken
        ], 200);
    }

    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();
            $accessToken =  $user->createToken('authToken')->accessToken;
            return response()->json([
                'user' => $user, 
                'access_token' => $accessToken, 
                'status' => 'Login Successfully'
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'Email atau password masih salah. Coba ulang kembali'
            ], 401);
        }
    }
}
