<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use App\Models\PermissionRole;
use App\Models\PermissionRoleMaster;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        // LGate::before(function ($user, $ability) {
        //     return $user->hasRole('super-admin') ? true : null;
        // });
        try {
            PermissionRoleMaster::get()->map(function ($perm) {
                 Gate::define("view " . $perm->code, function ($user) use ($perm) {
                        return (bool) $user->hasPermissionTo("view", $perm->id);
                    });

                
            });

            PermissionRoleMaster::get()->map(function ($perm) {
                 Gate::define("add " . $perm->code, function ($user) use ($perm) {
                        return (bool) $user->hasPermissionTo("add", $perm->id);
                    });
            });


            PermissionRoleMaster::get()->map(function ($perm) {
                 Gate::define("edit " . $perm->code, function ($user) use ($perm) {
                        return (bool) $user->hasPermissionTo("edit", $perm->id);
                    });
            });

            PermissionRoleMaster::get()->map(function ($perm) {
                 Gate::define("delete " . $perm->code, function ($user) use ($perm) {
                        return (bool) $user->hasPermissionTo("delete", $perm->id);
                    });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
        
        Passport::routes();
    }

    protected function registerAccessGate()
    {

    }
}
