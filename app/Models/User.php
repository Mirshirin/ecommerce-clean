<?php

namespace App\Models;

use App\Enums\RoleStatus;
use App\Models\Permission;
use App\Support\UserController;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',

    ];
   
    

    public function setPasswordAttribute($value){
        return $this->attributes['password']=bcrypt($value);
    }

    
    // public function permissions(){
    //     return $this->belongsToMany(Permission::class);
    // }

    // public function roles(){
    //     return $this->belongsToMany(Role::class);
    // }
    
    // public function hasPermission($permission){      
    //        return $this->permissions->contains($permission) || $this->hasRole($permission->roles);           
    //     }
       
    // public function hasRole($roles){
      
    //    return !! $roles->intersect($this->roles)->all();
    // }
    // public function hasRole($roles){
    //     if(is_string($roles))
    //     {
    //         return $this->roles->contain('name',$roles);
    //     }
    //     return !! $roles->intersect($this->roles)->count();
    //     }

    public function carts(){
        return $this->hasMany(Cart::class);
    }


}   
    

