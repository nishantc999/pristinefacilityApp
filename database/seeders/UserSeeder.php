<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'role_id' => 0,
            'email' => 'superadmin@gmail.com',
            'username' => 'superadmin',
            'password' => Hash::make('12345678'),
        ]);
    }
}
