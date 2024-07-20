<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::query()
            ->orderBy('created_at', 'asc')
            ->paginate(7);
    }
    public function findUserById($id)
    {
        return User::find($id);
    }

    public function store(array $data)
    { 
        

         return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => $data['password'],
        ]);
       
    }
    public function edit($id)
    {
        $user= User::find($id);        
        return view('admin.users.edit-user');//->with('user' , $user);
    }

    public function update(array $data,$id)
    {
    
        $user= User::find($id); 
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
         
        ]);

        return $user;
    }
    public function destroy($id)
    {
        try {
            $user=$this->findUserById($id);
            $user->syncRoles([]);
            $user->delete();
            return true;
        }catch (ModelNotFoundException $e) {            
            return false;
        }
    }
}
