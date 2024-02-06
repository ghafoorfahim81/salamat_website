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

        // start user management

        //  permission group table
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
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        //end
        //  permission group table

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
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        // project Role

        $g = (new PermissionGroup())->where('name', 'project')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'product',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'product_list'
            ],
            [
                'name' => 'product_create'
            ],
            [
                'name' => 'product_edit'
            ],
            [
                'name' => 'product_view'
            ],
            [
                'name' => 'product_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        // Order permission
        $g = (new PermissionGroup())->where('name', 'order')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'about Us',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'about_us_list'
            ],
            [
                'name' => 'about_us_create'
            ],
            [
                'name' => 'about_us_edit'
            ],
            [
                'name' => 'about_us_view'
            ],
            [
                'name' => 'about_us_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        // invoice permission
        $g = (new PermissionGroup())->where('name', 'invoice')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'contact Us',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'contact_us_list'
            ],
            [
                'name' => 'contact_us_create'
            ],
            [
                'name' => 'contact_us_edit'
            ],
            [
                'name' => 'contact_us_view'
            ],
            [
                'name' => 'contact_us_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        //end

        // end user management

        //end


        //receipt

        $g = (new PermissionGroup())->where('name', 'receipt')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'comment',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'comment_list'
            ],
            [
                'name' => 'comment_create'
            ],
            [
                'name' => 'comment_edit'
            ],
            [
                'name' => 'comment_view'
            ],
            [
                'name' => 'comment_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        //end receipt
        //payment

        $g = (new PermissionGroup())->where('name', 'payment')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'blog',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'blog_list'
            ],
            [
                'name' => 'blog_create'
            ],
            [
                'name' => 'blog_edit'
            ],
            [
                'name' => 'blog_view'
            ],
            [
                'name' => 'blog_delete'
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        //end payment

        $g = (new PermissionGroup())->where('name', 'category')->first();
        if (!$g) {
            $g = PermissionGroup::create([
                'name' => 'category',
                'category' => 'admin',
            ]);
        }
        //  permission  table
        $permissions = [
            [
                'name' => 'category_list'
            ],
            [
                'name' => 'category_create'
            ],
            [
                'name' => 'category_edit'
            ],
            [
                'name' => 'category_view'
            ],
            [
                'name' => 'category_delete'
            ],
            [
                'name' => 'category_report'
            ]
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }
        //end category


        //dashboard
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
                'name' => 'dashboard_show'
            ],
            [
                'name' => 'organization_dashboard',
            ],
            [
                'name' => 'admin_dashboard',
            ],
        ];
        foreach ($permissions as $key => $value) {
            $p = (new Permission())->where('name', $value)->first();
            if (!$p) {
                $p = Permission::create($value);
                // $g->permissions()->sync($p->id, false);
                $g->permissions()->attach($p->id, ['id' => Str::uuid()->toString()]);

            }
        }

    }
}

?>
