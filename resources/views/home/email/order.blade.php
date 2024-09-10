<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject }} </title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 16px">

<h2>{{ $subject }}</h2>
    <h3>{{ $mailmessage }}</h3>
    <hr>
    <h2>Order Details</h2>
    <p>Order ID: {{ $orderDetails['orderResults'][0]['name'] }}</p>

    <!-- Show order image if available -->
    @if (!empty($order['image']))
        <p><img src="{{ Storage::disk('public')->url($order['image']) }}" alt="{{ $order->product_title }}" width="100"></p>
    @endif

    <h3>Purchased Products Count: {{ $orderDetails['totalProducts'] }}</h3> 
    <span class="count">Purchased Amount: {{ number_format($orderDetails['totalAmount'], 0, '.', ',') }}</span>

    @if (!empty($orderDetails['orderResults']))
        <h2>Purchased Products:</h2>
        <?php $counter = 0; ?>
        <ul>
            @foreach ($orderDetails['orderResults'] as $product)
                <li>
                    <p>Item {{ $counter + 1 }}</p>
                    <p><strong>{{ $product['product_title'] }}</strong></p>
                    <p>Price: {{ number_format($product['price'], 0, '.', ',') }}</p>
                    <p>Quantity: {{ $product['quantity'] }}</p>
                    <p>Total Price for Item {{ $counter + 1 }} after discounting = {{ number_format($product['price'] - ((($product['price']*$product['code'])/100 )* $product['quantity']) , 0, '.', ',')  }} </p>                </li>
                <?php $counter++; ?>
            @endforeach
        </ul>
    @else
        <p>No products found in the order.</p>
    @endif
</body>
</html>