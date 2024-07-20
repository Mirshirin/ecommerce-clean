@component('admin.layouts.content')

    <div class="card-body">
        <h4 class="card-title">Edit User</h4>

        <form id="frm1" class="form-inline" method="put" action="{{ route('users.update',$user->id) }}" >
            @csrf
            @method('put')
            <label class="sr-only-visible" for="name">Name</label>
            <input type="text" class="form-control mb-2 mr-sm-2 @error('name') is-invalid @enderror"  id="name" name="name"  value="{{   old('name',$user->name)}}" style= "background-color:white !important; color: black;" >
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    <br>
                @enderror
            <label class="sr-only-visible" for="email">Email address</label>
            <input type="email" class="form-control mb-2 mr-sm-2 " id="email" name="email"  value="{{  old('email',$user->email) }}" style= "background-color:white !important; color: black;" >
                          
         
            <label class="sr-only-visible" for="password">Password</label>
            <input type="password" class="form-control mb-2 mr-sm-2 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password " style= "background-color:white !important; color: black;" >
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            <br>
            @enderror
            <label class="sr-only-visible" for="password_confirmation">Password Confirmation</label>
            <input type="password" class="form-control mb-2 mr-sm-2" id="password_confirmation" name="password_confirmation" placeholder="Enter Password confirmation" style= "background-color:white !important; color: black;" >
            <label class="sr-only-visible" for="phone">Phone No.</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" style= "background-color:white !important; color: black;" >
            <label class="sr-only-visible" for="address">address</label>
            <input type="text" class="form-control mb-2 mr-sm-2" id="address" name="address" placeholder="Enter address" value="{{ old('address', $user->address) }}" style= "background-color:white !important; color: black;" >
            @if (! $user->hasVerifiedEmail())
            <label class="sr-only-visible" for="verify">User Verification</label>
            <input type="checkbox" class="form-check-input" id="verify" name="verify" > 
            @endif
                <br>
                <div class="mb-3 row">
                <label for="roles" class=" sr-only-visible">Roles</label>
                <div class="col-md-4"> 
                <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                @forelse ($roles as $role)

                @if ($role!='Super Admin')
                <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                {{ $role }}
                </option>
                @else
                @if (Auth::user()->hasRole('Super Admin')) 
                <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
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

            <!-- <button type="submit" class="btn btn-primary mb-2">Submit</button> -->
            <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update User">
                    </div>
        </form>
    </div>
  
     
@endcomponent
