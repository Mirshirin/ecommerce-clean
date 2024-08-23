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
<h2>{{ $mailmessage }}</h2>
<hr>
<h2>Order Details</h2>
<p>Order ID:{{$order->id }}</p>
<p>Customer name : {{ $order->name }}</p>
<p>Customer email: {{ $order->email }}</p>
<p>Customer phone number: {{ $order->phone_number }}</p>
<p>Customer addres: {{ $order->address}}</p>  
<p>Your product {{ $order->product_title  }}</p>
<p>The price {{ $order->price }} $</p>
<p>The image {{ $order->image }} </p>
</body>
</html>
