<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        $admRole = Role::whereName('adm')->firstOrFail();
        $admId = User::whereName('Administrador')->firstOrFail();
	
	DB::table('role_user')->insert([
		['role_id' => $admRole->id, 'user_id' => $admId->id, 'created_at' => NULL, 'updated_at' => NULL, ]
	]);

    }
}
