<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.png') }}" type="">
      <title>Commerce</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>  -->

      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"></script> -->
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
      <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.min.css') }}" />

      <link rel="stylesheet" type="text/css" href="{{ asset('home/css/all.min.css') }}" />

      <!-- font awesome style -->
      <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
      <link href="{{ asset('home/css/style2.css') }}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />
      @vite(['resources/css/app.css', 'resources/js/app.js'])

   </head>
   <body>   
      <!-- header section strats -->
      @include('home.layouts.header')
      <!-- end header section -->
      <!-- slider section -->
      @yield('content')
      <!-- footer start -->
      @include('home.layouts.footer')
      <!-- footer end -->
      <!-- jQery -->
         <!--    sweetalert code -->
    <script src="{{ asset('admin/assets/js/sweetalert.js') }}"></script>
    <script>
      //   @if (session('message'))
      //   swal({
      //       title: "{{  session('message') }} ",
      //       icon: "success",
      //       button: "ok",
      //   });

      //   @endif
    </script>
      <script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
      <!-- popper js -->
      <script src="{{ asset('home/js/popper.min.js') }}"></script>
      <!-- bootstrap js -->
      <script src="{{ asset('home/js/bootstrap.js') }}"></script>
      <!-- custom js -->



      <script src="{{ asset('home/js/custom.js') }}"></script>
      <script>
            
            $(document).ready(function() {
                    $('#Cash_on_Delivery').click(function(e) {
                        e.preventDefault();

                        // بررسی اینکه آیا سبد خرید خالی است یا خیر
                        $.ajax({
                            url: '/check-cart-status', // URL مورد نظر برای بررسی وضعیت سبد خرید
                            type: 'GET',
                            success: function(response) {
                                if (!response.isCartEmpty === false) { // اگر سبد خرید خالی نیست
                                    // ادامه کد برای اجرای AJAX اصلی
                                    var data = {
                                        orderMethod: 'Cash on Delivery',
                                        _token: '{{ csrf_token() }}'
                                    };

                                    $.ajax({
                                        url: '/cash-order/',
                                        type: 'POST',
                                        data: data,
                                        success: function(response) {
                                            alert('Order placed successfully!');
                                            window.location.href = "{{ route('products-index') }}";
                                        },
                                        error: function() {
                                            alert('There was an error placing your order.');
                                            orderPlaced = false;
                                        }
                                    });
                                } else {
                                    alert('سبد خرید شما خالی است. لطفاً محصولاتی را به سبد اضافه کنید.');
                                }
                            },
                            error: function(){
                                alert('Error check cart status.');
                            }
                        });
                    });
                });
</script>

   </body>
</html>