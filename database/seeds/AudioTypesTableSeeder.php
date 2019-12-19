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
            'type'=>'Short Conversation'
        ]);
        \App\Listening\AudioType::create([
            'type'=>'Long Conversation'
        ]);
        \App\Listening\AudioType::create([
            'type'=>'Speech'
        ]);
    }
}
