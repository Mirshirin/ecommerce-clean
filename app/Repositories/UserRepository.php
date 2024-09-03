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
            //'password' => $data['password']  ,
            'password' => Hash::make($data['password'])  ,//bcrypt($data['password']),
        ]);
       //dd(Hash::make($data['password']) );
    }

  
    public function edit($id)
    {
        $user= User::find($id);        
        return view('admin.users.edit-user')->with('user' , $user);
    }

    public function update(array $data,$id)
    {
      

        $user = User::find($id);

       
        $preparedData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),

        ];
    
        // // Log the prepared data
        // Log::info([
        //     'userId' => $id,
        //     'dataToSave' => $preparedData,
        //     'action' => 'update'
        // ]);
    
        // // Update the user
        $validatedData = $user->update($preparedData);

        // Check if a password was provided
        if (isset($data['password']) && !empty($data['password'])) {
            // Hash the password
            $hashedPassword = Hash::make($data['password']);
            
            // Update the user with the hashed password
           // $user->password = $hashedPassword;
            
            // Log the hashed password
            // Log::info([
            //     'userId' => $id,
            //     'passwordHashed' => $hashedPassword,
            //     'action' => 'update'
            // ]);
        }
    
        // // Optionally, log the result of the save operation
        // if ($validatedData) {
        //     Log::info([
        //         'userId' => $id,
        //         'updated' => true,
        //         'dataSaved' => $preparedData,
        //         'action' => 'update'
        //     ]);
        // } else {
        //     Log::error([
        //         'userId' => $id,
        //         'updateFailed' => true,
        //         'dataAttempted' => $preparedData,
        //         'action' => 'update'
        //     ]);
        // }
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
