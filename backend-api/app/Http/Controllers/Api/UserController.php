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
use Carbon\Carbon;
use Laravel\Passport\Passport;
class UserController extends Controller
{
    /**
     * This is login function
     */
    public function login()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){

            $user = Auth::user();
            $access_token =  $user->createToken('access_token');
            $str_access_token = $access_token->accessToken;
            $todayDate = Carbon::now();
            $expiration = $access_token->token->expires_at;


            return response()->json([
                'user' => $user,
                'expires_in' => $expiration,
                'access_token' => $str_access_token,
                'status' => 'Login Successfully'
            ], 200);
        }
        else{
            return response()->json([
                'error'=>'Email atau password masih salah. Coba ulang kembali'
            ], 401);
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
            'DoB'=>['required'],
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
        $tempUser = TempUser::create($formRegister);
        $dataId= DB::table('temp_users')->select('id')->where('email', $request->email)->get();

        $encryptUserId = encrypt($dataId);

        DB::table('otps')->insert([
            'temp_userID' => $tempUser->id,
            'otp' => $randomNumber
           ]);

        return response()->json([
            'encryptUserId' => $encryptUserId,
            'message' => 'We have send otp to your email for your account verification. Please check your Email.'
        ], 200);
    }

    public function idTemp(Request $request){

        $decryptUserId = decrypt($request->id);

        try{
            $data = DB::table('temp_users')
            // ->join('otps','otps.temp_userID','=','temp_users.id')
            ->where('id','=',$decryptUserId[0]->id)
            ->first();
        } catch (Exception $err){
            return response()->json($err, 500);
        }
        
        return response()->json([
            'email' => $data->email
        ], 200);
    }

    public function otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'string', 'max:4'],
            'encryptUserId' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ], 401);
        }

        $decryptUserId = decrypt($request->encryptUserId);

        $tempId = (string) $decryptUserId[0]->id;

        $otpCode = DB::table('temp_users')
        ->join('otps','otps.temp_userID','=','temp_users.id')
        ->select('otp')
        ->where('temp_users.id','=',$tempId)->first();

        if($otpCode->otp != $request->otp){
            return response()->json([
                'message' => 'Kode yang anda masukkan salah.'
            ], 404);
        }
        $dataToken = new User;

        $dataUser = DB::table('temp_users')->where('id','=',$tempId)->first();
        $dataToken->tokenChat = uniqid();
        $dataToken->fullName = $dataUser->fullName;
        $dataToken->displayName = $dataUser->displayName;
        $dataToken->email = $dataUser->email;
        $dataToken->password = $dataUser->password;
        $dataToken->DoB = $dataUser->DoB;
        $dataToken->phoneNumber = $dataUser->phoneNumber;
        $dataToken->address = $dataUser->address;
        $dataToken->role = $dataUser->role;
        $dataToken->profilePicture = $dataUser->profilePicture;
        $dataToken->isActive = $dataUser->isActive;
        $dataToken->save();


        try {

            $dataOTP = DB::table('otps')->where('otp', '=', $request->otp)->delete();
            $dataTemp = DB::table('temp_users')->where('id', '=', $tempId)->delete();

        } catch (Exception $error) {
            return response()->json($error, 500);
        }

        return response()->json([
            'message' => 'Verification success'
        ], 200);
    }

    public function resendOtp(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'encryptUserId' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ], 401);
        }

        $decryptUserId = decrypt($request->encryptUserId);
        $tempId = (string) $decryptUserId[0]->id;

        try {
            $randomNumber = random_int(1000, 9999);

            if(Otp::where('otp', $randomNumber )->exists()){
                try {
                    do {
                        $randomNumber = random_int(1000, 9999);

                    } while (Otp::where('otp', $randomNumber )->exists());

                } catch (Exception $error) {
                    return response()->json($error, 500);
                }

                $data = Otp::find($tempId);
                $data->update(['otp' => $randomNumber]);

                \Mail::to($request->email)->send(new \App\Mail\otpMail($randomNumber));

            } else {
                $data = Otp::find($tempId);
                $data->update(['otp' => $randomNumber]);

                \Mail::to($request->email)->send(new \App\Mail\otpMail($randomNumber));
            }

        } catch (Exception $error) {
            return response()->json($error, 500);
        }

        return response()->json([
            'message' => 'Resend OTP success. Please check your email'
        ], 200);

    }
}
