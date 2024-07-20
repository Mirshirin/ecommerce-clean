<?php

namespace App\Contracts;


interface RoleRepositoryInterface
{
    public function getAllRoles();
    public function getAllRoleNames();
    public function getAllPermissions();
    public function getAllRolesWithPermissions();
    public function getRolePermissions($id);
    public function findRoleById($id);
    public function createRole(array $data);
    public function updateRole(array $data,$id);
    public function destroy($id);
}
