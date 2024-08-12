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
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody> 
                        @php
                        $totalPrice =0;
                        $totalProduct =0;
                        @endphp  
                                       
                        @if(session('cart'))
                            @foreach((array) session('cart') as $id => $cartProduct)
                                <tr>                                   
                                    <td>{{ $cartProduct['product_title'] }}</td>   
                                    <td>{{ $cartProduct['quantity'] }}</td>   
                                    <td>{{ $cartProduct['price'] }}</td>   
                                    <td>  <img src="{{  $cartProduct['image'] }}"  style="width:50px" class="img-responsive"></td>  
                                    
                                    <form action="{{ route('delete-carts', $id) }}" method="post">
                                        @csrf                                
                                        @method('DELETE')
                                    <td><button type="submit" class="btn btn-danger btn-sm">Remove</button></td> 
                                    </form>
                                </tr>                            
                         
                                @php
                                $totalPrice += $cartProduct['price']* $cartProduct['quantity'];
                                $totalProduct +=$cartProduct['quantity'];
                                @endphp 
                       
                        @endforeach 
                        @endif 
                        <tr>
                            <td></td>
                            <td>{{ $totalProduct }}</td>
                            <td>${{ $totalPrice }} total</td>
                            <!-- <td><big>total</td> -->
                            <td></td>
                            <td></td>
                        </tr> 
                        </tbody>
   
                 
                    
                  </table>
                  <h1 style="font-size: 20px; font-weight:700;">Proceed to order</h1>
                  <a href="{{ url('/') }}" class="btn btn-danger continue-shopping-btn">Continue Shopping</a>
           
                  <form id="cash_on_delivery" class="form-inline cash-on-delivery-form" method="POST" action="{{ route('cash-order') }}"   >
                  @csrf   
                        <input type="hidden" name="orderMethod" value="Cash on Delivery">
                        <button type="submit" class="btn btn-danger"  >Cash on Delivery</button>
                  </form>
                  
                 
                </div>
                
            </div>  
        </div>
    </section>
@endsection


