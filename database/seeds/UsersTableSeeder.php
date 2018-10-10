<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name'      => 'Administrador',
            'email'     => 'administrador@sicario.com.br',
            'password'  => bcrypt('sicario@123'),
        ]);
    }
}