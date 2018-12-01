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

    public function livroUser(){        
        return $this->belongsToMany('App\User','livro_user', 'livro_id', 'user_id')->withPivot(['status']);
    }

    public function userLivros(){        
        return $this->belongsToMany(\App\User::class);
    }
}
