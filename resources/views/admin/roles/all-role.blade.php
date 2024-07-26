@component('admin.layouts.content')

<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
    <div class="card-header">Manage Roles</div>
    <div class="card-body">
        @can('create-role')
            <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Role</a>
        @endcan
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col" style="max-width:100px;">Role Name</th>
                <th scope="col">Permissions</th>
                <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>           
            <tbody>  
           
                @forelse ($roles as $role)
                <tr>
                <tr class="item_type role">
                <input type="hidden" class="delete_val_id" value="{{ $role->id }}">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $role->name }}</td>
                    <td>
                        <ul>
                            @forelse ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @empty
                            @endforelse
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            @if ($role->name!='Super Admin')
                                @can('edit-role')
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                                @endcan
                                @can('delete-role')
                                    @if ($role->name!=Auth::user()->hasRole($role->name))
                                    <button type="submit" class="btn btn-sm btn-danger deletebtn" >Delete</button>
                                    @endif
                                @endcan
                            @endif
                        </form>                     
                    </td>
                    </tr>
                @empty
                    <td colspan="3">
                        <span class="text-danger">
                            <strong>No Role Found!</strong>
                        </span>
                    </td>
                @endforelse
               
                </tr> 
                
                       

            </tbody>
           
        </table>

        {{ $roles->links() }}

        
  
    </div>
  </div>
</div>
@endcomponent
