<?php

namespace App\Repositories;

//use App\Models\Role;
//use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use App\Contracts\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
   
    public function getAllRoles()
    {
        return Role::all();
       
    }
    public function getAllRolesWithPermissions(int $perPage = 3)
    {
        $roles= Role::with('permissions')->orderBy('id', 'DESC')->paginate($perPage) ; 
        return $roles;
    }
    public function getRolePermissions($id)
    {
       return DB::table("role_has_permissions")->where("role_id",$id)
        ->pluck('permission_id')
        ->all();
    }
    public function getAllPermissions(int $perPage = 3)
    {   
        return Permission::all();
    }
    public function findRoleById($id)
    {
        return Role::find($id);
    }
    // public function create()
    // {
    //     return view('roles.create', [
    //         'permissions' => Permission::get()
    //     ]);
    // }
    public function store(array $data)
    {  
         return Role::create([
            'name' => $data['name'],
          
        ]);
       
    }
    public function edit($id)
    {
        $role= Role::find($id);        
        return view('admin.roles.edit-role')->with('role' , $role);       
    }

    public function update($data,$id)
    {      
        $role= $this->findRoleById($id);
        $role->update($data);
        return $role;
    }
    public function destroy($id)
    {   
        $role = $this->findRoleById($id);
        $role->delete();
        return $role; 
    }
    public function getAllRoleNames()
    {
        return Role::pluck('name')->all();
    }
    public function getAllPermissionNames(){

        return Permission::pluck('name')->all();



     

    }
}
