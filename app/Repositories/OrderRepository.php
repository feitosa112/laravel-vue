<?php
namespace App\Repositories;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use Illuminate\Support\Facades\DB;

class OrderRepository {
    private $orderModel;

    public function __construct(OrderModel $orderModel){
        $this->orderModel = $orderModel;
    }


    public function getSendOrder($request){
        try{
            $cartData = $request->cart;
            $totalAmount = $request->total;
            $customerData = $request->formData;

            $order= OrderModel::create([
                'customer_name'=>$customerData['customer_name'],
                'customer_surname'=>$customerData['customer_surname'],
                'customer_address'=>$customerData['customer_address'],
                'customer_phone'=>$customerData['customer_phone'],
                'total_price'=>$totalAmount

            ]);

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

            return response()->json($cartData);

            }
        }catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
            // Ukoliko se dogodi greška, vraćamo odgovor sa statusom 500
            return response()->json(json_encode(['error' => $e->getMessage(), 'trace' => $e->getTrace()]), 500);


        }
    }


    public function getTheBestSellingProducts(){
        try {

            $theBestSellingProducts = OrderItemModel::with(['product.boutique'])
            ->select('product_id', DB::raw('COUNT(product_id) as broj_prodaja'))
            ->groupBy('product_id')
            ->orderByDesc('broj_prodaja')
            ->limit(4)
            ->get();

            return ($theBestSellingProducts);
        }catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
            // Ukoliko se dogodi greška, vraćamo odgovor sa statusom 500
            return response()->json(json_encode(['error' => $e->getMessage(), 'trace' => $e->getTrace()]), 500);


        }
    }
}
