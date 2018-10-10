<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    public function roles(){
    	return $this->belongsToMany(\App\Role::class);
    }

    public function permissionRole(){        
        return $this->belongsToMany('App\Permission','permission_role', 'permission_id', 'role_id')->withPivot(['status']);
    }
}
