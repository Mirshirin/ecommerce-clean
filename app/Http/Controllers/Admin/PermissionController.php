<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePermissionRequest;
use App\Contracts\PermissionRepositoryInterface;


class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->middleware('permission:create-permission|edit-permission|delete-permission')->only(['index']);
        $this->middleware('permission:create-permission')->only(['create','store']); 
        $this->middleware('permission:edit-permission')->only(['edit','update']);  
        $this->middleware('permission:delete-permission')->only(['destroy']);
    }
    public function index(){

        $permissions= $this->permissionRepository->getAllPermissions();
        return view('admin.permissions.all-permission',['permissions'=> $permissions]);
    
    }
    
    public function create()
    {
        return view('admin.permissions.create-permission');
    }
    
    public function store(UpdatePermissionRequest $request){   
      
        $validatedData = $request->validated();
        $permissions= app(PermissionRepositoryInterface::class)->createPermission($validatedData ); 
        return redirect(route('permissions.index'))->with('message','permission was stored');
    
    }
    
    public function edit($id){
        $permission = $this->permissionRepository->findPermissionById($id);
        return view('admin.permissions.edit-permission')->with('permission',$permission);
    
    }
    public function update(UpdatePermissionRequest $request, $id)
    {  
        $permission = $this->permissionRepository->findPermissionById($id);
        $validatedData = $request->validated();         
        $permissions= app(PermissionRepositoryInterface::class)->updatePermission($validatedData,$id );            
        return to_route('permissions.index',$permission)->with('message','Permission was updated.');
    }
    public function destroy($id)
    {
        $permission = $this->permissionRepository->findPermissionById($id);
        $permission->delete();
        return response()->json([ 'status' => 'Permission deleted successfully' ]);
    }
     
}
