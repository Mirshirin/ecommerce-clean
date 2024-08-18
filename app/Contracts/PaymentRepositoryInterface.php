<?php

namespace App\Contracts;

use Illuminate\Support\Arr;

interface PaymentRepositoryInterface
{
 
    public function createPayment(array $data);

}
