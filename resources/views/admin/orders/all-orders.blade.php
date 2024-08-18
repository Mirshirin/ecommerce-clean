



@component('admin.layouts.content')

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">

    <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Order List</h4>           
        </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th> # </th>
              <th>Image </th>              
              <th>Name </th>
              <th>Email </th>              
              <th>Phone </th>
              <th>Product Title </th>              
              <th>Quantity </th>                          
              <th>Payment status </th>
              <th>Delivery status </th>  
              <th>Final Status</th>  
              <th>print pdf</th>  
            </tr>
          </thead>
          <tbody>

            @foreach ($orders as $order) 
                <tr>
                    <td> {{  $order->id }} </td>   
                    @if (strpos($order->image,'http') !== false)
                      <td>  <img src="{{ $order->image }}" alt="{{  $order->product_title }}"> </td>
                    @else    
                      <td>  <img src="{{ asset('productImage/'. $order->image) }}" alt="{{ $order->product_title  }}"> </td>
                    @endif   
                    <td> {{  $order->name }} </td> 
                    <td> {{  $order->email }} </td> 
                    <td> {{  $order->phone_number }} </td> 
                    <td> {{  $order->product_title }} </td> 
                    <td> {{  $order->quantity }} </td> 
                    <td> {{  $order->payment_status }} </td> 
                    <td> {{  $order->delivery_status }} </td> 
                    <td> {{  $order->delivery_status }} </td> 
                              
                    <td> 
                        <a href=" {{  route('print-pdf',$order->id) }}" class="btn btn-sm btn-success">Print pdf</a>
                    </td> 
                </tr>
         
        @endforeach
        
          </tbody>
        </table>
      </div>
    </div>
    <div class="note">
    <div class="note-body">
      {{ $orders->links() }}
    </div>
  </div>
  
  </div>
</div>
@endcomponent
