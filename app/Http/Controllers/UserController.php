<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    function UserRegistraion(Request $request){

   try{
    User::create([
        'firstname' => $request->input('firstname'),
        'lastname' => $request->input('lastname'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'password' => $request->input('password'),
        
        
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
    }
}
