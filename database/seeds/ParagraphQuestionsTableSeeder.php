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
       $ids= \App\Reading\Paragraph::all()->pluck('id')->toArray();

           for ($i=0;$i<100;$i++){
               $id=array_rand($ids);
               $correct= array_rand([1,2,3,4]);
                $question=\App\Reading\ReadingQuestion::create([
                    'content'=>'Question 1',
                    'reading_question_type_id'=>2,
                    'paragraph_id'=>$ids[$id],
                ]);
                for ($j=0;$j<4;$j++){
                    $question->options()->create(['content'=>'Option '.($j+1)]);
                }
               $question->options[$correct]->update(['correct'=>1]);
           }
       }


}
