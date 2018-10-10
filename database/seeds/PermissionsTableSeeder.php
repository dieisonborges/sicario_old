<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Área - Gerência de Usuários
        //Create
        Permission::create([
            'name'=>'create_user',
            'label'=>'Create - Gerência de Usuários',
        ]);
        //Read
        Permission::create([
            'name'=>'read_user',
            'label'=>'Read - Gerência de Usuários',
        ]);
        //Update
        Permission::create([
            'name'=>'update_user',
            'label'=>'Update - Gerência de Usuários',
        ]);
        //Delete
        Permission::create([
            'name'=>'delete_user',
            'label'=>'Delete - Gerência de Usuários',
        ]);
        // ------------------------------------------------------------

        //Área - Gerência de Roles (Regras)
        //Create
        Permission::create([
            'name'=>'create_role',
            'label'=>'Create - Gerência de Roles (Regras)',
        ]);
        //Read
        Permission::create([
            'name'=>'read_role',
            'label'=>'Read - Gerência de Roles (Regras)',
        ]);
        //Update
        Permission::create([
            'name'=>'update_role',
            'label'=>'Update - Gerência de Roles (Regras)',
        ]);
        //Delete
        Permission::create([
            'name'=>'delete_role',
            'label'=>'Delete - Gerência de Roles (Regras)',
        ]);        
        // ------------------------------------------------------------

        //Área - Gerência de Permissions (Permissões)
        //Create
        Permission::create([
            'name'=>'create_permission',
            'label'=>'Create - Gerência de Permissions (Permissões)',
        ]);
        //Read
        Permission::create([
            'name'=>'read_permission',
            'label'=>'Read - Gerência de Permissions (Permissões)',
        ]);
        //Update
        Permission::create([
            'name'=>'update_permission',
            'label'=>'Update - Gerência de Permissions (Permissões)',
        ]);
        //Delete
        Permission::create([
            'name'=>'delete_permission',
            'label'=>'Delete - Gerência de Permissions (Permissões)',
        ]);        
        // ------------------------------------------------------------


    }
}
