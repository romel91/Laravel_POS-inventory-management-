<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Inertia\Inertia;
use App\jwt\JWTToken;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
//pages methods
    public function LoginPage(Request $request){
        return Inertia::render('LoginPage');
    }
    public function RegisterPage(Request $request){
        return Inertia::render('RegisterPage');
    }
    public function SendOtpPage(Request $request){
        return Inertia::render('SendOtpPage');
    }
    public function VerifyOtpPage(Request $request){
        return Inertia::render('VerifyOtpPage');
    }
    public function ResetPasswordPage(Request $request){
        return Inertia::render('ResetPasswordPage');
    }
    





    function UserRegistration(Request $request){

   try{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|string|max:15',
        'password' => 'required|string|min:8|confirmed',
    ]);


    User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'mobile' => $request->input('mobile'),
        'password' => ($request->input('password')),
        
        
    ]);

return response()->json([
    'status'=>'success',
    'message'=>'User Registered Successfully'
]);
   } catch(Exception $e){
    return response()->json([
        'status'=>'error',
        'message'=>'User Registration Failed'
    ]);
   }
    }//end method

    public function UserLogin(Request $request){
        $count = User::where('email', $request->input('email'))->where('password',$request->input('password'))->select('id')->first();

        if($count !== null){
        
            // $token = JWTToken::CreateToken($request->input('email'),$count->id);
            // return response()->json([
            //     'status'=>'success',
            //     'message'=>'User Login Successfully',
            //     'token'=>$token
            // ],200)->cookie('token', $token, 60*24*30);

            $email = $request->input('email');
            $user_id = $count->id;
            $request->session()->put('email', $email);
            $request->session()->put('user_id', $user_id);

            $data =['message'=>'User Login Successfully','status' =>true, 'error'=>''];
            return redirect('/dashboard')->with($data);
        }else{
            // return response()->json([
            //     'status'=>'failed',
            //     'message'=>'Unauthorized'
            // ],200);
            $data =['message'=>'login failed','status' =>false, 'error'=>''];
            return redirect('/login')->with($data);
        }
}//end method

public function DashboardPage(Request $request){
    $userEmail = $request->headers->get('userEmail');
    $userId = $request->headers->get('userId');
    return response()->json([
        'status'=>'success',
        'message'=>'Welcome to Dashboard',
        'userEmail'=>$userEmail,
        'userId'=>$userId
    ],200);
}
//end method

public function Logout(Request $request){
    return response()->json([
        'status'=>'success',
        'message'=>'User Logout Successfully'
    ],200)->cookie('token', '', -1);
}
//end method

public function SendOtp(Request $request){
    $email = $request->input('email');

    $otp = rand(100000, 999999);
    // Store the OTP in the database or send it via email/SMS
    // For demonstration purposes, we'll just return it in the response
    $count = User::where('email', $email)->count();
    if($count == 1){
        Mail::to($email)->send(new OtpMail($otp));
        User::where('email', $email)->update(['otp' => $otp]);
        return response()->json([
            'status'=>'success',
            'message'=>'OTP sent successfully'
        ],200);
    }else{
        return response()->json([
            'status'=>'failed',
            'message'=>'unauthorized'
        ],200);
    }

    
}//end method

public function VerifyOtp(Request $request){
    $email = $request->input('email');
    $otp = $request->input('otp');

    $count = User::where('email', $email)->where('otp', $otp)->count();
    if($count == 1){
        User::where('email',$email)->update(['otp' => 0]);
        $token =JWTToken::CreateTokenForSetPassword($request->input('email'));
        return response()->json([
            'status'=>'success',
            'message'=>'OTP verified successfully'
        ],200)->cookie('token', $token, 60*24*30);
    }else{
        return response()->json([
            'status'=>'failed',
            'message'=>'unauthorized'
        ],200);
    }
}//end method

public function ResetPassword(Request $request){
    try{
        
        $email = $request->header('email');
        $password = $request->input('password');
        User::where('email', $email)->update(['password' => $request->input('password')]);
        return response()->json([
            'status'=>'success',
            'message'=>'Password Reset Successfully'
        ],200);
    }catch(Exception $e){
        return response()->json([
            'status'=>'failed',
            'message'=>'Password Reset Failed'
        ],200);
    }
}
}