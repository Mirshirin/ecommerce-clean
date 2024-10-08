@component('admin.layouts.content')
<div class="col-12 grid-margin stretch-card">
  <div class="card">
      <div class="card-body">
        <h4 class="card-title">Create Category</h4>      
        <form id="frm" class="form-inline" method="POST" action="{{ route('categories.store') }}">
            @csrf
          <label class="sr-only-visible" for="inlineFormInputName2">Name</label>
          <input type="text" class="form-control mb-2 mr-sm-2 @error('name') is-invalid @enderror" name="name"   placeholder="Enter category name" style= "background-color:white !important; color: black;" >
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            <br>
            @enderror
          <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
      </div>
  </div>
</div>
@endcomponent

