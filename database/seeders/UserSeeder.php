<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
      

        // DB::table('users')->insert([
        //     'username' => 'a.admin',
        //     'email' => 'admin@admin.com',
        //     'firstname' => 'Admin',
        //     'lastname' => 'Admin',
        //     'gender' => 'male',
        //     'contact' => '06 000000000',
        //     'password' => Hash::make('password')
        // ]);
         $admin = User::create([
            'username' => 'a.admin',
            'email' => 'admin@admin.com',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'gender' => 'male',
            'contact' => '06 000000000',
            'password' => Hash::make('password'),
            
        ]);
        $role =  Role::create(['name' => 'admin']);
      

        // attach role and user
       $admin->roles()->attach($role);

    }
}
