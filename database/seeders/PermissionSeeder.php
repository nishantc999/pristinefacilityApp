<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();
        $array=['update','create','delete','show'];
      foreach($array as $value){
        DB::table('permissions')->insert([
            'module_name' => 'user management',
            'feature_name' => $value,

        ]);
        DB::table('permissions')->insert([
            'module_name' => 'role management',
            'feature_name' => $value,

        ]);
    
   
        DB::table('permissions')->insert([
            'module_name' => 'sku management',
            'feature_name' => $value,

        ]);
        DB::table('permissions')->insert([
            'module_name' => 'shift management',
            'feature_name' => $value,

        ]);
        DB::table('permissions')->insert([
            'module_name' => 'client management',
            'feature_name' => $value,

        ]);
        DB::table('permissions')->insert([
            'module_name' => 'employee management',
            'feature_name' => $value,

        ]);
   

      }
 
      DB::table('permissions')->insert([
        'module_name' => 'daily sale',
        'feature_name' => 'show',

    ]);
    }
}
