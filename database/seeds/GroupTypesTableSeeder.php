<?php

use Illuminate\Database\Seeder;

class GroupTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\GroupType::create([
            'type'=>'Take Course then exam'
        ]);
        \App\GroupType::create([
            'type'=>'Take exam without course'
        ]);
    }
}
