<?php 
namespace App\Services;

use App\Repositories\PaymentRepository;

class PaymentService
{
    protected $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function createPayment(array $paymentData)
    {
        return $this->paymentRepository->createPayment($paymentData);
    }
}
