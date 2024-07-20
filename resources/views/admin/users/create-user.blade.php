@component('admin.layouts.content')

<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
        <h4 class="card-title">Create User</h4>      
        <form id="frm" class="form-inline" method="PUT" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
          <label class="sr-only-visible" for="name">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror mb-2 mr-sm-2" name="name" id="name" value="{{ old('name') }}" placeholder="Enter your name" style= "background-color:white !important; color: black;" >
            @error('name')
                    <span class="text-danger">{{ $message }}</span>
            @enderror
          <label class="sr-only-visible" for="email">Email address</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" style= "background-color:white !important; color: black;">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
                <br>
            @enderror
          <label class="sr-only-visible" for="phone">Phone No.</label>
          <input type="text" class="form-control mb-2 mr-sm-2"   id="phone" name="phone"  placeholder="Enter Phone" style= "background-color:white !important; color: black;" >
          <label class="sr-only-visible" for="address">address</label>
          <input type="text" class="form-control mb-2 mr-sm-2"  id="address" name="address"  placeholder="Enter address" style= "background-color:white !important; color: black;" >
          <label class="sr-only-visible" for="password">Password</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror          
        <label class="sr-only-visible" for="password_confirmation">Password Confirmation</label>
          <input type="password" class="form-control mb-2 mr-sm-2" id="password_confirmation" name="password_confirmation"  placeholder="Enter Password confirmation" style= "background-color:white !important; color: black;" >
          
          <label class="sr-only-visible" for="verify">User Verification</label>
          <input type="checkbox" class="form-check-input"  id="verify" name="verify" >
          <br>
          <div class="mb-3 row">
                        <label for="roles" class=" sr-only-visible">Roles</label>
                        <div class="col-md-2">           
                            <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                                @forelse ($roles as $role)

                                    @if ($role!='Super Admin')
                                        <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                        {{ $role }}
                                        </option>
                                    @else
                                        @if (Auth::user()->hasRole('Super Admin'))   
                                            <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                            {{ $role }}
                                            </option>
                                        @endif
                                    @endif

                                @empty

                                @endforelse
                            </select>
                            @error('roles')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
          <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
    </div>
  </div>
</div>
  @endcomponent
