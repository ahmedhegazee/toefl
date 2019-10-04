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
        for($i=0;$i<100;$i++){
            $rand =array_rand($arr);
            $question=\App\Grammar\GrammarQuestion::create([
                'question_text'=>'question2',
                'grammar_question_type_id'=>$arr[$rand],
            ]);
            $question->options()->create([
                'option_text'=>'option1',
                'correct'=>0
            ]);
            $question->options()->create([
                'option_text'=>'option2',
                'correct'=>0
            ]);
            $question->options()->create([
                'option_text'=>'option3',
                'correct'=>1
            ]);
            $question->options()->create([
                'option_text'=>'option4',
                'correct'=>0
            ]);
        }

    }
}
