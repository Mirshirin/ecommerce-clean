<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\OrderRepositoryInterface;

class OrderController extends Controller
{
    
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function  index(){
        $orders = $this->orderRepository->getAllOrders();
        return view('orders.all-orders', compact('orders'));
    }

    public function  delivered($id){
        $this->orderRepository->updateOrderStatus($id, ['delivery_status' => 'delivered', 'payment_status' => 'paid']);
        return redirect()->back();

    }
}
