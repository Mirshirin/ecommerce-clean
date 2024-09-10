@extends('home.master')

@section('content')
    <section style="height: 100vh; margin-top:70px">
        <div class="container">
            <div class="container">
                <h1>Product List</h1>
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Product Title</th>
                        <th>Product Quantity</th>
                        <th>dicount</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody> 
                            @php
                            $totalPrice = 0;
                            $totalProduct = 0;
                            @endphp  

                            @if(session('cart'))
                            @foreach((array) session('cart') as $id => $cartProduct)
                            <tr>                                   
                                <td>{{ $cartProduct['product_title'] }}</td>   
                                <td>{{ $cartProduct['quantity'] }}</td>   
                                <td>{{ $cartProduct['code'] }}</td>  
                                <td>
                                    @php
                                        $price = isset($cartProduct['price']) ? floatval($cartProduct['price']) : 0;
                                        $discount = isset($cartProduct['code']) ? floatval($cartProduct['code']) : 0;
                                        $quantity = isset($cartProduct['quantity']) ? intval($cartProduct['quantity']) : 0;
                                        
                                        $subTotal = ($price - (($price * $discount / 100) * $quantity));
                                        $totalPrice += $subTotal;
                                       
                                        $totalProduct += $quantity;
                                    @endphp
                                    {{ $subTotal }}
                                </td>   
                                <td> <img src="{{ asset('storage/' . $cartProduct['image']) }}" style="width:50px" class="img-responsive"></td>  
                                <form action="{{ route('delete-carts', $id) }}" method="post">
                                    @csrf                                
                                    @method('DELETE')
                                <td><button type="submit" class="btn btn-danger btn-sm">Remove</button></td> 
                                </form>
                            </tr>                            
                            @endforeach 
                            @endif

                        <tr>
                            <td>total</td>
                            <td>{{ $totalProduct }}</td>
                            <td></td>
                            <td>${{ $totalPrice }} </td>
                            <!-- <td><big>total</td> -->
                            <td></td>

                            <td></td>
                            <td></td>
                        </tr> 
                    </tbody>
   
                </table>
                    <h1 style="font-size: 20px; font-weight:700;">Proceed to order</h1>
                    <a href="{{ url('/') }}" class="btn btn-danger continue-shopping-btn">Continue Shopping</a>
                    <a href="{{ route('checkout') }}" class="btn btn-danger continue-shopping-btn">Proceed to Checkout</a>           
               
            </div>  
        </div>
    </section>
@endsection
@section('customJS')
    <script>
        $(document).ready(function(){
            $.ajax({
                type: "get",
                url: "{{ route('checkout') }}",
                dataType: "json",
                success: function (response) {
                        if(response.status === false) {
                            // Display the success message using SweetAlert
                            Swal.fire({
                                icon: 'warning',
                                title: 'oops',
                                text: response.message,
                                confirmButtonText: 'OK'
                                    }).then((result) => { 
                                     
                                          
                                            window.location.href = "{{ url('/') }}/" ; // Redirect after the modal closes

                                        
                                    });
                        } 
          
                }
            });
        });
    </script>
@endsection