<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use App\Role;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        /*
        'App\Model' => 'App\Policies\ModelPolicy',
        */
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        
        
        $this->registerPolicies($gate);

        //Comente esse bloco no primeiro migrate

        /* --------------------- Primeiro Migrate ----------------- */
    
        $permissions = Permission::with('roles')->get();

        foreach ($permissions as $permission) {
             
            $gate->define(

                $permission->name, function(User $user) use ($permission){
                 

                    return $user->hasPermission($permission);
                    



                }

            );  

        
            /* Permissão total para o Grupo adm */

        
            Gate::before(function ($user) {
                if ($user->hasRole('adm')) {
                    return true;
                }
            });        
        

        }
        
        /*--------------------------------Primeiro Migrate----------------*/

    }
}
