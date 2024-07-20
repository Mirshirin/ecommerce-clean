<?php

namespace App\Contracts;

interface OrderRepositoryInterface
{
    public function getAllOrders();
    public function updateOrderStatus($id, array $status);
}
