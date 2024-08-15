@extends('home.master')

@section('content')

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">              
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('products-index') }}">Shop</a></li>               
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

        <form action="{{ route('processCheckout') }}" method="post" id="orderForm" name="orderForm">
        @csrf

        <!-- {{ route('processCheckout') }} -->
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="name" id="name" value="{{ (!empty($user->name)) ? $user->name : ''  }}" class="form-control" placeholder="First Name">
                                        <p></p>
                                    </div>
                                </div>
                  
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" value="{{ (!empty($user->email)) ? $user->email : ''  }}" class="form-control" placeholder="Email">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ (!empty($user->address)) ? $user->address : ''  }}</textarea>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="phone" id="phone" value="{{ (!empty($user->phone)) ? $user->phone: ''  }}" class="form-control" placeholder="Mobile No.">
                                        <p></p>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <section class="section-9 pt-4">
                <div class="card cart-summery">
                    <div class="card-body">
                        @php
                        $totalPrice =0;
                        $totalProduct =0;
                        @endphp 
                            @if(session('cart'))
                            @foreach((array) session('cart') as $id => $cartProduct)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{ $cartProduct['product_title'] }} X {{ $cartProduct['quantity'] }}</div>
                                <div class="h6">Pkr:{{ $cartProduct['price']-(($cartProduct['price'] * $cartProduct['code']) / 100 ) * $cartProduct['quantity'] }} </div>
                            </div>
                            @php
                            $totalPrice += $cartProduct['price']-(($cartProduct['price'] * $cartProduct['code']) / 100 ) * $cartProduct['quantity'];
                            $totalProduct +=$cartProduct['quantity'];
                            @endphp 

                            @endforeach
                            @endif
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Price Total</strong></div>
                                <div class="h6"><strong> Pkr:{{ $totalPrice }}</strong></div>
                            </div>

                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Product Total </strong></div>
                                <div class="h6"><strong >Pkr:{{  $totalProduct }}</strong></div>
                            </div>
                    </div>
                </div>
                </section>
                <section class="section-9 pt-4">
                    <div class="card payment-form ">
                        <div class="col-md-12">
                            <h3 class="card-title h5 mb-3">Payment Method</h3>
                            <div class="">
                                <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">
                                <label for="payment_method_one" class="form-check-label">Cash on delivery</label>
                            </div>

                            <div class="">
                                <input type="radio" name="payment_method" value="cod" id="payment_method_two">
                                <label for="payment_method_two" class="form-check-label">PayPing</label>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                            </div>

                        </div>
                    </div>

                </section>

                </div>
            </div>

        </form>

    </div>
</section>

@endsection

@section('customJS')

    <script>
        $("#payment_method_one").click(function(){
            if($(this).is(":checked") == true){
                $("#cart-payment-form").addClass('d-none');
            }
        });

        $("#payment_method_two").click(function(){
            if($(this).is(":checked") == true){
                $("#cart-payment-form").removeClass('d-none');
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#orderForm").submit(function(event)
        {
            event.preventDefault();

            $('button[type="submit"]').prop('disabled', true);

            $.ajax({
                type: "post",
                url: "{{ route('processCheckout') }}",
                data: $(this).serializeArray(),
                dataType: "json",
                success: function (response) {
                    var errors = response.errors;
                    $('button[type="submit"]').prop('disabled',false);
                        if(response.status) {
                            // Display the success message using SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: '',
                                text: response.message,
                                confirmButtonText: 'OK'
                                    }).then(() => { // Use then() to wait for the modal to close         // Thank you in reponse
                                        window.location.href = "{{ url('thanks/') }}/" + response.orderId; // Redirect after the modal closes
                                    });
                        } else
                        {

                                // For first name
                                if(errors.name){
                                    $("#name").addClass('is-invalid')
                                    .siblings("p")
                                    .addClass('invalid-feedback')
                                    .html(errors.name);
                                }
                                else{
                                    $("#name").removeClass('is-invalid')
                                    .siblings("p")
                                    .removeClass('invalid-feedback')
                                    .html('');
                                }

                            
                                if(errors.email){
                                    $("#email").addClass('is-invalid')
                                    .siblings("p")
                                    .addClass('invalid-feedback')
                                    .html(errors.email);
                                }
                                else{
                                    $("#email").removeClass('is-invalid')
                                    .siblings("p")
                                    .removeClass('invalid-feedback')
                                    .html('');
                                }

                    
                                // For address
                                if(errors.address){
                                    $("#address").addClass('is-invalid')
                                    .siblings("p")
                                    .addClass('invalid-feedback')
                                    .html(errors.address);
                                }
                                else{
                                    $("#address").removeClass('is-invalid')
                                    .siblings("p")
                                    .removeClass('invalid-feedback')
                                    .html('');
                                }

                        

                                // For Mobile
                                if(errors.phone){
                                $("#mobile").addClass('is-invalid')
                                    .siblings("p")
                                    .addClass('invalid-feedback')
                                    .html(errors.phone);
                                }
                                else{
                                    $("#mobile").removeClass('is-invalid')
                                    .siblings("p")
                                    .removeClass('invalid-feedback')
                                    .html('');
                                }
                        }

                },
            });
        });







    </script>

@endsection