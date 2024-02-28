<?php

namespace App\Http\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function sendOrder(Request $request){
        try {


            $cartData = $request->cart;
            $totalAmount = $request->total;
            $customerData = $request->formData;

            // $request->validate([
            // $customerData['customer_name']=>'required|string',
            // $customerData['customer_surname']=>'required|string',
            // $customerData['customer_address']=>'required|string',
            // $customerData['customer_phone']=>'required|string',
            // '_token' => 'required',



            // ]);
           $order= OrderModel::create([
                'customer_name'=>$customerData['customer_name'],
                'customer_surname'=>$customerData['customer_surname'],
                'customer_address'=>$customerData['customer_address'],
                'customer_phone'=>$customerData['customer_phone'],
                'total_price'=>$totalAmount

            ]);
            // Session::forget('cart')
            if($cartData != null){


                foreach($cartData as $product){
                    OrderItemModel::create([
                        'product_id' => $product['productId'],
                        'order_id' => $order->id,
                        'product_name'=>$product['productName'],
                        'product_size'=>$product['size'],
                        'product_color'=>$product['color'],
                        'quantity'=>$product['cart_quantity'],
                        'boutique'=>$product['boutiqueName'],
                        'product_price'=>$product['price']

                    ]);
                }
            }

            return response()->json($cartData);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
            // Ukoliko se dogodi greška, vraćamo odgovor sa statusom 500
            return response()->json(json_encode(['error' => $e->getMessage(), 'trace' => $e->getTrace()]), 500);


        }
    }
}
