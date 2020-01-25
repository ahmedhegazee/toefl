<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Config::create([
            'name'=>'computers_count',
            'value'=>'30',
        ]);
        \App\Config::create([
            'name'=>'grammar_exam_time',
            'value'=>'0:45',
        ]);
        \App\Config::create([
            'name'=>'reading_exam_time',
            'value'=>'1:0',
        ]);
        \App\Config::create([
            'name'=>'listening_exam_time',
            'value'=>'1:0',
        ]);
        \App\Config::create([
            'name'=>'center_manager',
            'value'=>'Dr.Faysel A. Metwally',
        ]);
        \App\Config::create([
            'name'=>'faculty_dean',
            'value'=>'Prof. Waleed Shawky Elbehiry',
        ]);
        \App\Config::create([
            'name'=>'vice_president',
            'value'=>'Prof. Hassan H. Younis',

        ]);
        \App\Config::create([
            'name'=>'certificate_id',
            'value'=>'2414',
        ]);
    }
}

