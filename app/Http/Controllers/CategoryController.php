<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function CreateCategory(Request $request){
        $user_id =$request->header('id');

        Category::create([
            'name'=>$request->name,
            'user_id'=>$user_id,
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Category Created Successfully'
        ],200);
    } //end method

    public function CategoryList(Request $request){
        $user_id =$request->header('id');
        $categories = Category::where('user_id',$user_id)->get();
        return response()->json([
            'status'=>'success',
            'data'=>$categories
        ],200);
    } //end method

    public function CategoryById(Request $request){
        $user_id =$request->header('id');
        $category = Category::where('user_id',$user_id)->where('id',$request->id)->first();
        return response()->json([
            'status'=>'success',
            'data'=>$category
        ],200);
    }//end method

    public function UpdateCategory(Request $request){
        $user_id =$request->header('id');
        $category = Category::where('user_id',$user_id)->where('id',$request->id)->first();
        if($category){
            $category->update([
                'name'=>$request->name,
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'Category Updated Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Category Not Found'
            ],200);
        }
    }//end method

    public function DeleteCategory(Request $request){
        $user_id =$request->header('id');
        $category = Category::where('user_id',$user_id)->where('id',$request->id)->first();
        if($category){
            $category->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'Category Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Category Not Found'
            ],200);
        }
    }//end method
}
