<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model 
{
    //

    public function equipamentos(){        
        return $this->belongsTo('App\Equipamento', 'equipamento_id', 'id');
    }

    public function users(){        
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function prontuarioTickets(){        
        return $this->belongsToMany('App\Ticket','prontuario_tickets');
    }

    public function prontuarioTicketsShow(){        
        return $this->hasMany(\App\ProntuarioTickets::class);
    }

    public function setors(){
        
        return $this->belongsToMany(\App\Setor::class);
    }
 


}
