<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'full_name' => "drScripts",
            'phone_number' => '0000000',
            'cabang_id' => '3',
            'special_code' => 'KP-00000000000',
            'role' => 'superadmin',
            'address' => "kopo",
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'full_name' => "Base Admin",
            'phone_number' => '0000001',
            'cabang_id' => '3',
            'special_code' => 'KP-00000000001',
            'role' => 'admin',
            'address' => "kopo",
            'password' => Hash::make('admin'),
        ]);
    }
}
