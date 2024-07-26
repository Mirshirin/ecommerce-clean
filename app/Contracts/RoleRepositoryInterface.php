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
    public function edit($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function destroy($id);
}
