<?php

namespace App\Http\Controllers\Admin;

//use App\Models\Role;
//use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use App\Contracts\RoleRepositoryInterface;

class RoleController extends Controller
{
  
    protected $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);    
    }
    public function index(){
        $roles=$this->roleRepository->getAllRolesWithPermissions();
        return view('admin.roles.all-role',['roles' => $roles]);     
    }
    public function create(){
        $permissions = $this->roleRepository->getAllPermissions();
        return view('admin.roles.create-role')->with('permissions',$permissions);
    }
    public function store(StoreRoleRequest $request){
        $validatedData=$request->validated();    
        $role= app(RoleRepositoryInterface::class)->store($validatedData);
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);
        return redirect(route('roles.index'))->with('message','Data saved.');
    }
    public function edit($id){

        $permissions = $this->roleRepository->getAllPermissions();
        $rolePermissions=$this->roleRepository->getRolePermissions($id);
        $role=$this->roleRepository->findRoleById($id);
        return view('admin.roles.edit-role',[
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions]);
    }
    public function update(UpdateRoleRequest $request,$id){

       $validatedName= $request->only('name');
       $role=app(RoleRepositoryInterface::class)->update($validatedName,$id);

       $validatedData = $request->validated();
       $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
       $role->syncPermissions($permissions);

        return redirect(route('roles.index'))->with('message','Data updated.');
    }
    
    public function destroy($id){

        $role =  $this->roleRepository->findRoleById($id);

        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
    
        $role= $this->roleRepository->destroy($id);
        $role->delete();
        return response()->json([ 'status' => 'role deleted successfully' ]);

    }
}
