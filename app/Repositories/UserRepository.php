<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
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
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'password' => $data['password']  ,
            //'password' => Hash::make($data['password'])  ,//bcrypt($data['password']),
        ]);
      // dd(Hash::make($data['password']) );
    }

  
    public function edit($id)
    {
        $user= User::find($id);        
        return view('admin.users.edit-user')->with('user' , $user);
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
        if (!empty($data['password'])){
            $user->update([
                'pssword' => Hash::make($data['password']),
            ]);
        }

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
