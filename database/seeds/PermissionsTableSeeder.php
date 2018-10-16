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

        //Área - Gerência de Equipamentos
        //Create
        Permission::create([
            'name'=>'create_equipamento',
            'label'=>'Create - Gerência de Equipamentos',
        ]);
        //Read
        Permission::create([
            'name'=>'read_equipamento',
            'label'=>'Read - Gerência de Equipamentos',
        ]);
        //Update
        Permission::create([
            'name'=>'update_equipamento',
            'label'=>'Update - Gerência de Equipamentos',
        ]);
        //Delete
        Permission::create([
            'name'=>'delete_equipamento',
            'label'=>'Delete - Gerência de Equipamentos',
        ]);        
        // ------------------------------------------------------------

        //Área - Gerência de Tickets
        //Create
        Permission::create([
            'name'=>'create_ticket',
            'label'=>'Create - Gerência de Tickets de Manutenção',
        ]);
        //Read
        Permission::create([
            'name'=>'read_ticket',
            'label'=>'Read - Gerência de Tickets de Manutenção',
        ]);
        //Update
        Permission::create([
            'name'=>'update_ticket',
            'label'=>'Update - Gerência de Tickets de Manutenção',
        ]);
        //Delete
        Permission::create([
            'name'=>'delete_ticket',
            'label'=>'Delete - Gerência de Tickets de Manutenção',
        ]);        
        // ------------------------------------------------------------


    }
}
