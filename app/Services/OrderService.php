<?php 
namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $orderRepository;
    protected $productRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function createOrdersFromCart(array $cart, int $userId)
    {
        $totalAmount = 0;
        $total=0;
        $lastOrder = null;
       // dd($cart);
        foreach ($cart as $product) {
            $orderData = [
                'name' => $product['name'],
                'email' => $product['email'],
                'phone_number' => $product['phone_number'],
                'address' => $product['address'],
                'product_title' => $product['product_title'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $product['quantity'],
                'product_id' => $product['product_id'],
                'payment_status' => 'not paid',
                'delivery_status' => 'pending',
                'user_id' => $userId,
            ];

            $lastOrder = $this->orderRepository->createOrder($orderData);
            $total++;

            $discountPrice = $product['code'] != 0
                ? $product['price'] - ($product['price'] * $product['code']) / 100
                : $product['price'];

            $totalAmount += $discountPrice * $product['quantity'];
            $totalAmount = number_format($totalAmount, 2, '.', '');

            $productData = $this->productRepository->getProductById($product['product_id']);
            if ($productData->quantity > 0) {
                $updatedQty = $productData->quantity - $product['quantity'];
                $productData->quantity = $updatedQty;
                $productData->save();
            }       
             $orderDetails[] = $orderData;

          
        }
//dd($orderData);
//dd($orderDetails);
$totalProducts = $total; // Assign the total to the reference parameter

        return ['totalAmount' => $totalAmount, 
                'lastOrder' =>  $lastOrder  ,
                'orderResults' => $orderDetails, // Now this contains all orders
                'totalProducts' => $total,
            ];
    }
   
}
