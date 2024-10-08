
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
      $(document).ready(function(){
        // Set up the CSRF token for all AJAX requests
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        @if (session('message'))

        swal({
            title: "{{session('message')}}",
           
            icon: "success",
           
           
          })
        @endif  
        // Function to handle deletion
        function deleteItem(delete_id, itemType) {
          swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
        .then((willDelete) => {
            if (willDelete) {
              var data = {
                "_token": $('input[name=_token]').val(),
                "id": delete_id
              };

              $.ajax({
                type: "DELETE",
                url: '/admin/'+ itemType+'s/'+ delete_id,         
                data: data,
                success: function(response) {
                  swal(response.status, {
                    icon: "success",
                  })
                .then((result) => {
                    location.reload();
                  });
                }
              });
            }
          });
        }
        // Attach click event to delete buttons
        $('.deletebtn').click(function(e) {
              e.preventDefault();
              var delete_id = $(this).closest("tr").find('.delete_val_id').val();
              var itemType =  $(this).closest("tr").attr('class').split(' ')[1];     
            
              console.log(itemType);
              console.log(delete_id );

              deleteItem(delete_id, itemType);
            });
          
          });
    </script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" ></script>
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
    <script src="{{ asset('admin/assets/js/settings.js') }}"></script>
    <script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
    <!--    sweetalert code -->
   <script src="{{ asset('admin/assets/js/sweetalert.js') }}"></script>
    
