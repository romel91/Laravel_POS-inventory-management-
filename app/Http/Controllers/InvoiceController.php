<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Customer;
use App\Models\InvoiceProduct;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function CreateInvoice(Request $request){
      DB::beginTransaction();
      try {
        $user_id = $request->header('id');

        $data =[
            'user_id' => $user_id,
            'customer_id' => $request->customer_id,
            'total' => $request->total,
            'discount' => $request->discount,
            'vat' => $request->vat,
            'payable' => $request->payable
        ];
        $invoice = Invoice::create($data);

        $products = $request->input('products');
        foreach ($products as $product) {
           $existUnit =Product::where('id', $product['id'])->first();

           if(!$existUnit){
            return response()->json([
                'status' => 'failed',
                'message' => "Product with id {$product['id']} not found"
            ], 200);
           }

           if($existUnit->unit < $product['unit']){
            return response()->json([
                'status' => 'failed',
                'message' => "only {$existUnit->unit} unit available for product with id {$product['unit']}"
            ], 200);
           }

           InvoiceProduct::create([
            'invoice_id' => $invoice->id,
            'product_id' => $product['id'],
            'user_id' => $user_id,
            'qty' => $product['unit'],
            'sale_price' => $product['price']
        ]);
        Product::where('id', $product['id'])->update([
            'unit' => $existUnit->unit - $product['unit']
        ]);//end foreach
        }

        DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Invoice created successfully'
        ], 200);
      } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'failed',
            'message' => $e->getMessage()
        ], 200);
      }
    }//end method

    public function InvoiceList(){
        $invoices = Invoice::with('customer')->get();
        return response()->json([
            'status' => 'success',
            'data' => $invoices
        ], 200);
    }//end method

    public function InvoiceDetails(Request $request){
        $user_id = $request->header('id');

        $customerDetails = Customer::where('user_id',$user_id)->where('id',$request->customer_id)->first();
        $invoiceDetails = Invoice::with('customer')->where('user_id',$user_id)->where('id',$request->id)->first();
        $invoiceProducts = InvoiceProduct::with('product')->where('invoice_id',$request->id)->where('user_id',$user_id)->with('product')->get();

        return response()->json([
            'status' => 'success',
            'customerDetails' => $customerDetails,
            'invoiceDetails' => $invoiceDetails,
            'invoiceProducts' => $invoiceProducts
        ], 200);
    }//end method

    public function DeleteInvoice($id){
        DB::beginTransaction();
        try {
            
            $user_id = request()->header('id');
            InvoiceProduct::where('invoice_id', $id)->where('user_id',$user_id)->delete();
            Invoice::where('id', $id)->where('user_id',$user_id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 200);
        }
    }//end method
        
      
}
