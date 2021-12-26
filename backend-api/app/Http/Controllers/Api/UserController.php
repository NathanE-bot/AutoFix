<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Auth;
use Validator;
use App\User;
use App\TempUser;
use App\Otp;
use DB;
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

        

        $randomNumber = random_int(1000, 9999);
        $emailFromRegis = $request->email;

        \Mail::to($emailFromRegis)->send(new \App\Mail\otpMail($randomNumber));


        $formRegister = $request->all();
        $formRegister['password'] = bcrypt($formRegister['password']);
        $user = TempUser::create($formRegister);
        $accessToken = $user->createToken('authToken')->accessToken;
        $dataid= DB::table('temp_users')->select('id')->get();

        DB::table('otps')->insert([
            'temp_userID' => $user->id,
            'otp' => $randomNumber
           ]);

        return response()->json([
            'user' => $user,
            'access_token' => $accessToken
        ], 200);
    }

    public function idTemp(Request $request){

        try{
            $data = [
                'objectReturn' => DB::table('temp_users')
                ->join('otps','otps.temp_userID','=','otps.id')
                ->where('otps.temp_userID','=',$request->id)
                ->get()
            ];
            return response()->json($data, 200);
        } catch (Exception $err){
            return response()->json($err, 500);
        }
    }

    public function otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'string', 'max:4'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ], 401);
        }

        $otpCode = DB::table('temp_users')
        ->join('otps','otps.temp_userID','=','temp_users.id')
        ->select('otp')
        ->where('temp_users.id','=',$request->id)->get();

        if($otpCode[0]->otp != $request->otp){
            return response()->json([
                'message' => 'Code anda salah'
            ], 404);
        }

        $dataUser = DB::table('temp_users')->where('id','=',$request->id)->get();
        foreach($dataUser as $records)
        {
            $user = User::create([
                'fullName' => $records->fullName,
                'displayName' => $records->displayName,
                'email' => $records->email,
                'password' => $records->password,
                'DoB' => $records->DoB,
                'phoneNumber' => $records->phoneNumber,
                'address' => $records->address,
                'role' => $records->role,
                'profilePicture' => $records->profilePicture,
                'isActive' => $records->isActive,
                ]);
        }

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
