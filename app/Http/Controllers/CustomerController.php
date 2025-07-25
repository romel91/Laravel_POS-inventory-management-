<?php

namespace App\Http\Controllers;
use App\Models\Customer;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function CreateCustomer(Request $request){
        $user_id =$request->header('id');
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:customers,email',
            'mobile'=>'required|unique:customers,mobile'
        ]);

        Customer::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'user_id'=>$user_id
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Customer Created Successfully'
        ],200);
    } //end method

    public function CustomerList(Request $request){
        $user_id =$request->header('id');
        $categories = Customer::where('user_id',$user_id)->get();
        return response()->json([
            'status'=>'success',
            'data'=>$categories
        ],200);
    } //end method

    public function CustomerById(Request $request){
        $user_id =$request->header('id');
        $Customer = Customer::where('user_id',$user_id)->where('id',$request->id)->first();
        return response()->json([
            'status'=>'success',
            'data'=>$Customer
        ],200);
    }//end method

    public function UpdateCustomer(Request $request){
        $user_id =$request->header('id');
        $Customer = Customer::where('user_id',$user_id)->where('id',$request->id)->first();
        if($Customer){
            $Customer->update([
                'name'=>$request->name,
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'Customer Updated Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Customer Not Found'
            ],200);
        }
    }//end method

    public function DeleteCustomer(Request $request){
        $user_id =$request->header('id');
        $Customer = Customer::where('user_id',$user_id)->where('id',$request->id)->first();
        if($Customer){
            $Customer->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'Customer Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Customer Not Found'
            ],200);
        }
    }//end method
}
