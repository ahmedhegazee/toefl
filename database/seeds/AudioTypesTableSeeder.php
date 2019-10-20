<?php

use Illuminate\Database\Seeder;

class AudioTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Listening\AudioType::create([
            'type'=>'Short Speech'
        ]);
        \App\Listening\AudioType::create([
            'type'=>'Long Speech'
        ]);
        \App\Listening\AudioType::create([
            'type'=>'Dialog'
        ]);
    }
}
