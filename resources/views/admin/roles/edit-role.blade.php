@component('admin.layouts.content')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
         $('#permissions').select2(
            {
                'placeholder':'please select some permission'
            }
         );
      });
    </script>
@endsection
<div class="col-12 grid-margin stretch-card">   
    <div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Role</h4>

        <form id="frm" class="form-inline" method="POST" action="{{ route('roles.update',$role->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <label class="sr-only-visible" for="inlineFormInputName2">Role Name</label>
            <input type="text" class="form-control mb-2 mr-sm-2 @error('name') is-invalid @enderror" name="name"  value="{{ old('name',$role->name) }}" placeholder="Enter role name" style= "background-color:white !important; color: black;">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            <br>
            @enderror
            <label class="sr-only-visible" for="inlineFormInputName2">Permission label</label>
            <select class="form-select @error('permissions') is-invalid @enderror" multiple aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
                                @forelse ($permissions as $permission)
                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions ?? []) ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @empty

                                @endforelse
                            </select>
                            @error('permissions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
            <!-- <select name="permissions[]" id="permissions" class="form-control" style= "background-color:white !important; color: black;" multiple >
                @foreach ($permissions as $permission) 
                <option value="{{ $permission->id }} " {{ in_array($permission->id,$role->permissions->pluck('id')->toArray()) ? 'selected' : '' }} >{{ $permission->name }} - {{ $permission->label }} </option> 
                @endforeach                
            </select> -->
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
    </div>
</div>
</div>
@endcomponent

