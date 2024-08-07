@component('admin.layouts.content')

<div class="col-12 grid-margin stretch-card">
   
    <div class="card">
    <div class="card-body">
        @include('admin.layouts.errors')
        <h4 class="card-title">Edit Permission</h4>

        <form id="frm" class="form-inline" method="POST" action="{{ route('permissions.update',$permission->id) }}">
            @csrf
            @method('put')
            <label class="sr-only-visible" for="inlineFormInputName2">permission Name</label>
            <input type="text" class="form-control mb-2 mr-sm-2" name="name"  value="{{ old('name',$permission->name) }}" placeholder="Enter permission name" style= "background-color:white !important; color: black;">
           
           
            
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
    </div>
</div>
</div>
@endcomponent

