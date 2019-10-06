<?php

use Illuminate\Database\Seeder;

class GrammarQuestionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Grammar\GrammarQuestionType::create([
            'name'=>'Fill in the space',
        ]);
        \App\Grammar\GrammarQuestionType::create([
            'name'=>'Find the mistake',
        ]);
    }
}
