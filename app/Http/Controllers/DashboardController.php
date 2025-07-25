<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function DashboardSummary(Request $request){
        $userId = $request->header('id');

        $product = Product::where('user_id', $userId)->count();
        $category = Category::where('user_id', $userId)->count();
        $customer = Customer::where('user_id', $userId)->count();
        $invoice = Invoice::where('user_id', $userId)->count();
        $total =Invoice::where('user_id', $userId)->sum('total');
        $vat = Invoice::where('user_id', $userId)->sum('vat');
        $payable = Invoice::where('user_id', $userId)->sum('payable');
        $discount = Invoice::where('user_id', $userId)->sum('discount');

        $data =[
            'product'=>$product,
            'category'=>$category,
            'customer'=>$customer,
            'invoice'=>$invoice,
            'total'=>$total,
            'vat'=>$vat,
            'payable'=>$payable,
            'discount'=>$discount
        ];

        return $data;
    }
}
