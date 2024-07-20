<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Contracts\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
  
   
    public function getAllPermissions()
    {
        return Permission::query()
        ->orderBy('created_at', 'asc')
            ->paginate(7);
          
    }
    public function findPermissionById($id)
    {
        return Permission::find($id);
    }
    public function createPermission(array $data)
    {
        return Permission::create($data);
    }
    
    public function updatePermission(array $data,$id)
    {
        $permission = $this->findPermissionById($id);
        $permission->update($data);
        return $permission;
        
    }
    public function destroy($id)
    {
        $user=$this->findPermissionById($id);
        $user->delete();
        return $user; 
    }
}
