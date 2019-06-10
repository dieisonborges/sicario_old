<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    //

    public function users(){
    	return $this->belongsToMany(\App\User::class);
    }

    public function tickets(){
    	return $this->belongsToMany(\App\Ticket::class);
    }

    public function tutorials(){
        return $this->belongsToMany(\App\Tutorial::class);
    }

    public function livros(){
        return $this->hasMany(\App\Livro::class);
    }

    public function setorUser(){        
        return $this->belongsToMany('App\Setor','setor_user', 'setor_id', 'user_id')->withPivot(['status']);
    }

    public function setorTutorial(){        
        return $this->belongsToMany('App\Setor','setor_tutorial', 'setor_id', 'tutorial_id')->withPivot(['status']);
    }

    public function setorTicket(){        
        return $this->belongsToMany('App\Setor','setor_ticket', 'setor_id', 'ticket_id')->withPivot(['status']);
    }

    public function chefes(){        
        return $this->belongsToMany('App\User','chefe_setor', 'setor_id', 'user_id');
    }
}
