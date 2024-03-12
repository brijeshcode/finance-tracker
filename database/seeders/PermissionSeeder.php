<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\AdvanceSetups\RoleController;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::firstOrCreate(['name' => 'admin'], ['description' => 'all admin permissions']);
        $role = Role::firstOrCreate(['name' => 'operator'], ['description' => 'operator permissions']);
        $role = Role::firstOrCreate(['name' => 'investor'], ['description' => 'Who will use this platform']);

        User::find(1)->assignRole('admin');
        User::find(2)->assignRole('investor');
        // User::find(2)->assignRole('admin');
        $permisison = new RoleController();
        $permisison->seedPermission();

        return;
         
    }
}
