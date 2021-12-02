<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //GD11
        DB::table('users')->insert([
            'namaLengkap' => 'Andreas Raditya Aryatama',
            'email' => '10144@students.uajy.ac.id',
            'password' => '$2a$12$KrcrdFLkBakBkN1b4MmteugJSJq49BpNcOxZZSXMdENrN3/DLdVcS',
            'username' => 'AndRaditya',
            'noTelp' => '085868100245',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
