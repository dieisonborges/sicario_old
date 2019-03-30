<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    //
    public function setors(){
        
        return $this->belongsToMany(\App\Setor::class);
    }
}
