<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        // Admin permissions
        Role::findOrFail(1)->permissions()->attach([1, 2, 3, 4, 5, 6]);
        // Uncredited reporter permissions
        Role::findOrFail(2)->permissions()->attach([2, 5]);
        // Reporter permissions
        Role::findOrFail(3)->permissions()->attach([2, 3, 5, 7]);
    }
}
