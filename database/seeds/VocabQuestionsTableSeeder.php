<?php

use Illuminate\Database\Seeder;

class VocabQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<50;$i++){
           $correct= array_rand([1,2,3,4]);
           $question= \App\Reading\VocabQuestion::create([
                'content'=>'Question 2',
            ]);
            for ($j=0;$j<4;$j++){
                $question->options()->create(['content'=>'Option '.($j+1)]);
            }
            $question->options[$correct]->update(['correct'=>1]);
        }
    }
}
