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
            'name' => 'Project Manager',
            'id'=>1,
            'role_type'=>3,

        ]);
        DB::table('roles')->insert([
            'name' => 'Site Incharge',
            'id'=>2,
            'role_type'=>3,

        ]);
        DB::table('roles')->insert([
            'name' => 'Supervisor',
            'id'=>3,
            'role_type'=>3,

        ]);
  
      
   

      
  
}
}
