@extends('home.master')

<script>
   var numericInput = document.getElementById('numericInput'); 
   incrementButton.addEventListener('click', function() {
     numericInput.stepUp();
   });
 
   decrementButton.addEventListener('click', function() {
     numericInput.stepDown();
   });
 </script>

@section('content')

<section class="arrival_section">
   <div class="container"  style="float: right; margin-right: 1px;">
 
      @if (strpos($product->image,'http') !== false)
         <img src="{{ $product->image }}" alt="{{ $product->title }}">
      @else    
         <img src="/storage/{{ $product->image }}" alt="{{ $product->title }}">
      @endif
     
   </div>
   <div style="margin-left:40px; ">
   <div class="heading_container remove_line_bt">
      <h5>
         {{ $product->title }}
      </h5>
   </div>

   <p style="margin-top: 20px;margin-bottom: 10px;">
      {{ $product->description }}
   </p>
   <p>
      @if ( $product->discount_price !=null)
      <h6 style="color: red ">
         ${{ $product->discount_price }}
      </h6>
      <h6 style="text-decoration-line: line-through">
         ${{ $product->price }}
      </h6>
      @else
      <h6>
         ${{ $product->price }}
      </h6>
      @endif
   </p>
</div>

<div style="margin-left:30%;">
   <form action="{{ route('add-cart',$product->id) }}" method="POST">
      @csrf
         <div class="input-group">
            <div>
               <input type="number" id="numericInput" name="quantity" class="form-control" value="0"  size="2">
               <input type="submit" value="Add to Cart" name="" class="option1" >                
               <a href="{{ url('/') }}" class="btn btn-danger">Continue Shopping</a>
            </div>
         </div>  
   </form>
</div>

</div>
   
</section>

@endsection


















