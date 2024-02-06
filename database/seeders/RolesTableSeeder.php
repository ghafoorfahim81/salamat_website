<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // role table
        $check_role = (new Role())->where('slug', 'admin')->first();
        if (!$check_role) {
            $role = Role::create([
                'name' => 'admin',
                'slug' => 'admin'
            ]);
            // foreach (Permission::all() as $key => $value) {
            //     $role->permissions()->attach($value, ['id' => Str::uuid()->toString()]);
            // }
            foreach(Permission::all() AS $key=>$value)
            {
                $role->permissions()->attach($value);
            }
        }


    }
}
