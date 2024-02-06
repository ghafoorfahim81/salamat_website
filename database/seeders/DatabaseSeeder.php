<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                PermissionsTableSeeder::class,
                RolesTableSeeder::class,
                UsersTableSeeder::class,
            ]
        );
        Artisan::call('app:fetch-hr-data');
        DB::table('doc_types')->insert([
            [
                'name' => 'عریضه',
                'slug' => 'requisition',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'مکتوب',
                'slug' => 'letter',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'پیشنهاد',
                'slug' => 'suggestion',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'فرامین',
                'slug' => 'orders',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'احکام',
                'slug' => 'ahkam',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'استعلام',
                'slug' => 'inquiries',
                'created_at' => Carbon::now()
            ],

        ]);

        DB::table('fiscal_years')->insert([
            [
                'name' => '1402',
                'start_date' => '2023-02-20',
                'end_date' => '2024-02-20',
                'created_at' => Carbon::now()
            ],
        ]);

        //Status
        DB::table('statuses')->insert([
            [
                'name' => 'انتظار',
                'slug' => 'pending',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'در حال اجرا',
                'slug' => 'ongoing',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'تکمیل ناشده',
                'slug' => 'notCompleted',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'تکمیل شده',
                'slug' => 'completed',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'قبول شده',
                'slug' => 'approved',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'رد شده',
                'slug' => 'rejected',
                'created_at' => Carbon::now()
            ],
        ]);

        //Deadline Type
        DB::table('deadline_types')->insert([[
            'name' => 'ثابت',
            'created_at' => Carbon::now()
        ],
            [
                'name' => 'متغیر',
                'created_at' => Carbon::now()
            ],
        ]);

        //Followup Type
        DB::table('followup_types')->insert([
            [
                'name' => '-',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'اجرات',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'جواب',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'به تعقیب ',
                'created_at' => Carbon::now()
            ],
        ]);

        //Security Level
        DB::table('security_levels')->insert([[
            'name' => 'عادی',
            'created_at' => Carbon::now()
        ],
            [
                'name' => 'محرم',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'عاجل',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'اشد عاجل',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'اشد محرم ',
                'created_at' => Carbon::now()
            ],
        ]);


        //Deadline
        DB::table('deadlines')->insert([
            [
                'days' => 3,
                'doc_type_id' => 1,
                'security_level_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'days' => 4,
                'doc_type_id' => 1,
                'security_level_id' => 2,
                'created_at' => Carbon::now()
            ],
            [
                'days' => 5,
                'doc_type_id' => 1,
                'security_level_id' => 3,
                'created_at' => Carbon::now()
            ],
            [
                'days' => 5,
                'doc_type_id' => 1,
                'security_level_id' => 4,
                'created_at' => Carbon::now()
            ], [
                'days' => 5,
                'doc_type_id' => 1,
                'security_level_id' => 5,
                'created_at' => Carbon::now()
            ],

            [
                'days' => 3,
                'doc_type_id' => 2,
                'security_level_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'days' => 4,
                'doc_type_id' => 2,
                'security_level_id' => 2,
                'created_at' => Carbon::now()
            ],
            [
                'days' => 5,
                'doc_type_id' => 2,
                'security_level_id' => 3,
                'created_at' => Carbon::now()
            ],
            [
                'days' => 5,
                'doc_type_id' => 2,
                'security_level_id' => 4,
                'created_at' => Carbon::now()
            ], [
                'days' => 5,
                'doc_type_id' => 2,
                'security_level_id' => 5,
                'created_at' => Carbon::now()
            ],

                [
                    'days' => 3,
                    'doc_type_id' => 3,
                    'security_level_id' => 1,
                    'created_at' => Carbon::now()
                ],
                [
                    'days' => 4,
                    'doc_type_id' => 3,
                    'security_level_id' => 2,
                    'created_at' => Carbon::now()
                ],
                [
                    'days' => 5,
                    'doc_type_id' => 3,
                    'security_level_id' => 3,
                    'created_at' => Carbon::now()
                ],
                [
                    'days' => 5,
                    'doc_type_id' => 3,
                    'security_level_id' => 4,
                    'created_at' => Carbon::now()
                ], [
                    'days' => 5,
                    'doc_type_id' => 3,
                    'security_level_id' => 5,
                    'created_at' => Carbon::now()
                ],

        ]);

    }
}
