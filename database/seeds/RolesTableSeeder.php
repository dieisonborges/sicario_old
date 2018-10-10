<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
		
		Administrador
		Chefe de Nicho
		Auxiliar de Nicho
		Cardume VIP
		Franqueado
		Compras

        */

        //
        Role::create([
            'name'=>'adm',
            'label'=>'Administrador',
        ]);

        
    }
}
