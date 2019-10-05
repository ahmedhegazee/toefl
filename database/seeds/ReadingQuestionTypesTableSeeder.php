<?php

use Illuminate\Database\Seeder;

class ReadingQuestionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Reading\ReadingQuestionType::create([
            'name'=>'vocab question'
        ]);
        \App\Reading\ReadingQuestionType::create([
            'name'=>'paragraph question'
        ]);
    }
}
