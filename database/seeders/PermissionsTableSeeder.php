<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_access',
            ],
            [
                'id'    => 2,
                'title' => 'task_access',
            ],
            [
                'id'    => 3,
                'title' => 'video_access',
            ],
            [
                'id'    => 4,
                'title' => 'activity_logs_access',
            ],
            [
                'id'    => 5,
                'title' => 'video_show_access',
            ],
            [
                'id'    => 6,
                'title' => 'overviews_access',
            ],
            [
                'id'    => 7,
                'title' => 'reporter_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
