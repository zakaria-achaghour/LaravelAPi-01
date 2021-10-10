<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      

        DB::table('users')->insert([
            'username' => 'a.admin',
            'email' => 'admin@admin.com',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'gender' => 'male',
            'contact' => '06 000000000',
            'password' => Hash::make('password')
        ]);

    }
}
