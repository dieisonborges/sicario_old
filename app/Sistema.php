<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    //
    public function equipamentos(){
    	return $this->hasMany(\App\Equipamento::class);
    }
}
