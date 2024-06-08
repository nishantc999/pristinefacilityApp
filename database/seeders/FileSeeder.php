<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertFromFile('state.sql');
        $this->insertFromFile('city.sql');
        $this->insertFromFile('district.sql');
        
    }
    private function insertFromFile($filename)
    {
        $path = database_path('seeders/seed_files/' . $filename);
        $sql = file_get_contents($path);
        
        DB::unprepared($sql);
    }
}
