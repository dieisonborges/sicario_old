<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cargo', 'email', 'cpf','telefone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];


    //
    public function roles(){
        
        return $this->belongsToMany(\App\Role::class);
    }

    public function setors(){
        
        return $this->belongsToMany(\App\Setor::class);
    }


    public function hasPermission(Permission $permission){        
        return $this->hasAnyRoles($permission->roles);
    }

    public function hasAnyRoles($roles){

        if(is_array($roles) || is_object($roles) ) {
            return !! $roles->intersect($this->roles)->count();
        }
        
        return $this->roles->contains('name', $roles);
        

    }

    public function hasRole($role){

        if($this->roles->contains('name', $role)){
            return true;
        }else{
            return false;
        }
        

    }

    
}
