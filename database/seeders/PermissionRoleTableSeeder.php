<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        // Admin has Users, Tasks, Overviews tabs
        Role::findOrFail(1)->permissions()->attach([1, 2, 4, 5]);
        // User has Tasks tab
        Role::findOrFail(2)->permissions()->attach([2]);
        // Reporter has Tasks and Video tab
        Role::findOrFail(3)->permissions()->attach([2, 3]);
    }
}
