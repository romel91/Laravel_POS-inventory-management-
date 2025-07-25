<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function CreateProduct(Request $request){
        // dd($request->all());
        $user_id = $request->header('id');

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data=[
            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'category_id' => $request->category_id,
            'user_id' => $user_id,
        ];

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        $product = Product::create($data);
        if($product){
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product,
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Product creation failed',
            ], 200);
        }
}//end method

    public function ProductList(Request $request){
        $user_id = $request->header('id');
        $products = Product::where('user_id', $user_id)->get();
        return $products;
    }//end method

    public function ProductById(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        $product = Product::find($request->id);
        if($product){
            return response()->json([
                'status' => 'success',
                'message' => 'Product found',
                'data' => $product,
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found',
            ], 200);
        }
    }//end method
    public function UpdateProduct(Request $request){
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'category_id' => 'required'
            
        ]);
        $product = Product::find($request->id);
        if($product){
            $data=[
                'name' => $request->name,
                'price' => $request->price,
                'unit' => $request->unit,
                'category_id' => $request->category_id,
            ];
    
            if($request->hasFile('image')){
                if($product->image && file_exists(public_path('images/'.$product->image))){
                    unlink(public_path('images/'.$product->image));
                }
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                $file = $request->file('image');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $data['image'] = $filename;
            }
    
            $product->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'data' => $product,
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Product not found',
            ], 200);
        }
    }//end method

    public function DeleteProduct(Request $request, $id){
       try{
        // $user_id = $request->header('id');
        $product =Product::findOrFail($id);
        if($product->user_id != $user_id){
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
            ], 200);
        }
        if($product->image && file_exists(public_path('images/'.$product->image))){
            unlink(public_path('images/'.$product->image));
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
        ], 200);

       }catch(\Exception $e){
           return response()->json([
               'status' => 'failed',
               'message' => 'Product not found',
           ], 200);
       }
}
}