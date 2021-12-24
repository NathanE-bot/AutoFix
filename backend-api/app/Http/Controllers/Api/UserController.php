<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Auth;
use Validator;
use App\User;

class UserController extends Controller
{
    /**
     * This is login function
     */
    public function login()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $user['token'] =  $user->createToken('App')->accessToken;
            $user['status'] = "Login Successfully";
            return response()->json($user, 200);
        }
        else{
            return response()->json(['error'=>'Email atau password masih salah. Coba ulang kembali'], 401);
        }
    }

    /**
     * this is register function
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'DoB'=>['required','date_format:Y-m-d'],
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
}
