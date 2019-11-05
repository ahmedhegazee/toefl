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
            'value'=>'45m',
        ]);
        \App\Config::create([
            'name'=>'reading_exam_time',
            'value'=>'1h',
        ]);\App\Config::create([
            'name'=>'listening_exam_time',
            'value'=>'1h',
        ]);
    }
}
