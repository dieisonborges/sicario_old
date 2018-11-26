<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    //
    public function users(){        
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function setors(){        
        return $this->belongsTo(\App\Setor::class);
    }
}
