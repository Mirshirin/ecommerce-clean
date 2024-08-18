<?php

namespace App\Repositories;

use App\Models\PaymentOrder;
use App\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function createPayment(array $data){
        return PaymentOrder::create($data);
    }
}
