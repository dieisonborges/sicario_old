<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Role extends Model
{
    //
    public function permissions(){
    	return $this->belongsToMany(\App\Permission::class);
    }

    public function users(){
    	return $this->belongsToMany(\App\User::class);
    }

    public function roleUser(){        
        return $this->belongsToMany('App\Role','role_user', 'role_id', 'user_id')->withPivot(['status']);
    }
}
