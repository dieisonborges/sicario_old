<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    //
    public function setors(){
        
        return $this->belongsToMany(\App\Setor::class);
    }

    public function uploads(){        
        return $this->belongsToMany('App\Upload','upload_tutorial');
    }
}
