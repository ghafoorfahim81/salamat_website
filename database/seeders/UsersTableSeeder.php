<?php
namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role =(new Role())->where('slug','super-admin')->first();
        $user =(new User())->where('user_name','admin')->first();

        if(!$user)
        {
            $user  = User::create([
                'user_name'     => 'admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password')
            ]);
            if($role && $user)
            {
                (new UserRole())->create([
                    'user_id' =>$user->id,
                    'role_id' => $role->id
                ]);
            }
        }
    }
}
