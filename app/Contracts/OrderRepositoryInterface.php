<?php

namespace App\Contracts;

use Illuminate\Support\Arr;

interface OrderRepositoryInterface
{
    public function getAllOrders();
    public function updateOrderStatus($id, array $status);
    public function createOrder(array $data);

}
