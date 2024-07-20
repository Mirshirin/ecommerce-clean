@component('admin.layouts.content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">

    <div class="card-body">
        <div class="d-flex justify-content-between">
          <h4 class="card-title">Role List</h4>
            <div>
              @can('create-role')
              <a class="nav-link btn btn-sm btn-success  " href="{{ route('roles.create') }}">+ Create  Role</a>
              @endcan
            </div>
        </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th> # </th>
              <th>Role name </th>
              <th>Permissions</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
                @forelse ($roles as $role)
                <tr>
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
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> Delete</button>
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
            </tbody>
      
        </table>
        {{ $roles->links() }}

      </div>
    </div>
  </div>
</div>
@endcomponent
