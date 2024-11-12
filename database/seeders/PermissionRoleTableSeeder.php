<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_permissions = Permission::all();
        $agent_permissions = Permission::where('name','like','ticket%')->get();

        Role::findOrFail(1)->permissions()->sync($admin_permissions);
        Role::findorFail(2)->permissions()->sync($agent_permissions);

    }
}
