<?php
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'add categories']);
        Permission::create(['name' => 'view categories']);
/*
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $role2 = Role::create(['name' => 'company-admin']);
        $role2->givePermissionTo('view users');
        $role2->givePermissionTo('add users');

        $role3 = Role::create(['name' => 'store-admin']);
        $role3->givePermissionTo('view users');

        $role4 = Role::create(['name' => 'driver']);

        // create demo users
       /* $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);*/
        //$user = User::findOrFail(4);
        //$user->assignRole(['driver']);
        /*$role = Role::findOrFail(2);
        $role->givePermissionTo('view categories');
        $role->givePermissionTo('add categories');

        $role = Role::findOrFail(3);
        $role->givePermissionTo('view categories');
        $role->givePermissionTo('add categories');*/

    }
}
