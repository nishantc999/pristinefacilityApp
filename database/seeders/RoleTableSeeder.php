<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use DB;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->delete();
     
  
        DB::table('roles')->insert([
            'name' => 'Client',
            'id'=>1

        ]);
        DB::table('roles')->insert([
            'name' => 'Area Manager',
            'id'=>2

        ]);
        DB::table('roles')->insert([
            'name' => 'Site Manager',
            'id'=>3

        ]);
        DB::table('roles')->insert([
            'name' => 'Supervisor',
            'id'=>4

        ]);
        DB::table('roles')->insert([
            'name' => 'Employee',
            'id'=>5

        ]);
      
   

      
  
}
}
