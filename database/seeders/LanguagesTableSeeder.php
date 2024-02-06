<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            [
                'name' => 'Persian',
                'code' => 'fa',
            ],
            [
                'name' => 'Pashto',
                'code' => 'pa',
            ],
            [
                'name' => 'English',
                'code' => 'en',
            ],
        ]);
    }
}
