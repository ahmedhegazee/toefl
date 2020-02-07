<?php

use Illuminate\Database\Seeder;

class GrammarQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr=[1,2];
        for($i=0;$i<5000;$i++){
            $correct= array_rand([1,2,3,4]);

            $rand =array_rand($arr);
            $question=\App\Grammar\GrammarQuestion::create([
                'content'=>'question2',
                'grammar_question_type_id'=>$arr[$rand],
            ]);
            for ($j=0;$j<4;$j++){
                $question->options()->create(['content'=>'Option '.($j+1)]);
            }
            $question->options[$correct]->update(['correct'=>1]);
        }

    }
}
