<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function getAllUsers();  
    public function findUserById($id);  
    public function edit($id);  
    public function store(array $data);    
    public function update(array $data,$id);
    public function destroy($id);
}
