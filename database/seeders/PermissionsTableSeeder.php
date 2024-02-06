<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Traits\Seed\PermissionTrait;

class PermissionsTableSeeder extends Seeder
{
    use PermissionTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedAndCheckPermission();
    }
}
