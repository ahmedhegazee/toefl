<?php

use Illuminate\Database\Seeder;

class ParagraphQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $paragraphs= \App\Reading\Paragraph::all();

       foreach ($paragraphs as $paragraph){
           for ($i=0;$i<6;$i++){
               $correct= array_rand([1,2,3,4]);
               $question=$paragraph->questions()->create([
                   'content'=>'Question 1',
               ]);
               for ($j=0;$j<4;$j++){
                   $question->options()->create(['content'=>'Option '.($j+1)]);
               }
               $question->options[$correct]->update(['correct'=>1]);
           }
           }
       }



}
