<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use App\jwt\JWTToken;

class UserController extends Controller
{
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
        
            $token = JWTToken::CreateToken($request->input('email'),$count->id);
            return response()->json([
                'status'=>'success',
                'message'=>'User Login Successfully',
                'token'=>$token
            ],200)->cookie('token', $token, 60*24*30);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Unauthorized'
            ],200);
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
}
