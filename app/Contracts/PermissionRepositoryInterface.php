<?php

namespace App\Contracts;


interface PermissionRepositoryInterface
{
    public function getAllPermissions();
    public function findPermissionById($id);    
    public function createPermission(array $data);
    public function updatePermission(array $data,$id);
    public function destroy($id);
   // public function hasPermission($permission);

}
