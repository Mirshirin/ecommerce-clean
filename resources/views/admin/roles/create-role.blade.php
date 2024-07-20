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
      @include('admin.layouts.errors')
    <h4 class="card-title">Create Role</h4>   
    <form id="frm" class="form-inline" method="POST" action="{{ route('roles.store') }}">
        @csrf
      <label class="sr-only-visible " for="inlineFormInputName2">Role Name</label>
      <input type="text" class="form-control mb-2 mr-sm-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter role name" style= "background-color:white !important; color: black;" >
      @error('name')
          <span class="text-danger">{{ $message }}</span>
          <br>
      @enderror
      <label class="sr-only-visible" for="inlineFormInputName2">Permissions</label>
      <div class="col-md-6">           
          <select class="form-select @error('permissions') is-invalid @enderror" multiple aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
              @forelse ($permissions as $permission)
                  <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                      {{ $permission->name }}
                  </option>
              @empty

              @endforelse
          </select>
          @error('permissions')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
            
      <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>
  </div>
</div>
</div>
@endcomponent
