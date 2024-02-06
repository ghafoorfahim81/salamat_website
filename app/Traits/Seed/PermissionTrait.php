<?php
namespace App\Traits\Seed;

use App\Models\PermissionGroup;
use App\Models\Permission;
use Illuminate\Support\Str;
use DB;

trait PermissionTrait
{
    /**
     * seedAndCheckPermission function
     * seed permissions and check existing permission
     * @return void
     */
    public function seedAndCheckPermission()
    {

        // dashboard management

        $g = (new PermissionGroup())->where('name', 'dashboard')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'dashboard',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'dashboard',
            ]
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value['name'])->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);
            }
        }

//         report management

        $g = (new PermissionGroup())->where('name', 'report')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'report',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'report',
            ]
        ];
//        foreach ($permissions as $key => $value) {
//            $p = (new Permission())->where('name', $value)->first();
//            if (!$p) {
//                $p = Permission::create($value);
//                $g->permissions()->sync($p->id, false);
//            }
//        }
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }

        // start user management

        $g = (new PermissionGroup())->where('name', 'user')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'user',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'user_list'
            ],
            [
                'name' => 'user_create'
            ],
            [
                'name' => 'user_edit'
            ],
            [
                'name' => 'user_view'
            ],
            [
                'name' => 'user_delete'
            ],


        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }
        //end
        //   role permission seeder

        $g = (new PermissionGroup())->where('name', 'role')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'role',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'role_list'
            ],
            [
                'name' => 'role_create'
            ],
            [
                'name' => 'role_edit'
            ],
            [
                'name' => 'role_view'
            ],
            [
                'name' => 'role_delete'
            ],



        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }
        //end Role


        //   Document permission seeder

        $g = (new PermissionGroup())->where('name', 'document')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'document',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'document_list'
            ],
            [
                'name' => 'document_create'
            ],
            [
                'name' => 'document_edit'
            ],
            [
                'name' => 'document_view'
            ],
            [
                'name' => 'document_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }
        //end Document


        //   Tracker permission seeder

        $g = (new PermissionGroup())->where('name', 'tracker')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'tracker',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'tracker_list'
            ],
            [
                'name' => 'tracker_create'
            ],
            [
                'name' => 'tracker_edit'
            ],
            [
                'name' => 'tracker_view'
            ],
            [
                'name' => 'tracker_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }

        //end Tracker
        //   Deadline type permission seeder

        $g = (new PermissionGroup())->where('name', 'document_status')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'document_status',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'document_status_list'
            ],
            [
                'name' => 'document_status_create'
            ],
            [
                'name' => 'document_status_edit'
            ],
            [
                'name' => 'document_status_view'
            ],
            [
                'name' => 'document_status_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }

        //end Deadline type
        //   Tracker permission seeder

        $g = (new PermissionGroup())->where('name', 'document_type')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'document_type',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'document_type_list'
            ],
            [
                'name' => 'document_type_create'
            ],
            [
                'name' => 'document_type_edit'
            ],
            [
                'name' => 'document_type_view'
            ],
            [
                'name' => 'document_type_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }

        //end Tracker
        //   Tracker permission seeder

        $g = (new PermissionGroup())->where('name', 'followup_type')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'followup_type',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'followup_type_list'
            ],
            [
                'name' => 'followup_type_create'
            ],
            [
                'name' => 'followup_type_edit'
            ],
            [
                'name' => 'followup_type_view'
            ],
            [
                'name' => 'followup_type_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }
//        External Directorate
        $g = (new PermissionGroup())->where('name', 'external_directorate')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'external_directorate',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'external_directorate_list'
            ],
            [
                'name' => 'external_directorate_create'
            ],
            [
                'name' => 'external_directorate_edit'
            ],
            [
                'name' => 'external_directorate_view'
            ],
            [
                'name' => 'external_directorate_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }

        //end Tracker
        //   Security level permission seeder

        $g = (new PermissionGroup())->where('name', 'security_level')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'security_level',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'security_level_list'
            ],
            [
                'name' => 'security_level_create'
            ],
            [
                'name' => 'security_level_edit'
            ],
            [
                'name' => 'security_level_view'
            ],
            [
                'name' => 'security_level_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                $g->permissions()->sync($p->id, false);

            }
        }
        //end security level


    }
}

?>
