<?php

namespace App\Http\Controllers;


use App\Repositories\OrderRepository;
use Illuminate\Http\Request;


class OrderController extends Controller
{

    private $orderRepo;

    public function __construct(OrderRepository $orderRepo){
        $this->orderRepo = $orderRepo;
    }
    public function sendOrder(Request $request){
        $order = $this->orderRepo->getSendOrder($request);

    }


    public function theBestSellingProducts(){


            $theBestSellingProducts = $this->orderRepo->getTheBestSellingProducts();
            return response()->json($theBestSellingProducts);

    }
}
