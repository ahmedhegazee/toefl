<?php
namespace App;
 class Question{
     public static function getCorrectAnswer($options)
     {
         foreach ($options as $option)
             if ($option->correct)
                 return $option->getCorrectOption($option->id % 4 == 0 ? 4 : $option->id % 4);

     }

     public static function getGrammarQuestions($questions)
     {
         return $questions->map(function ($question) {
             return [
                 'id' => $question->id,
                 'Question' => $question->content,
                 'Question Type' => $question->type->name,
                 'First Option' => $question->options[0]->content,
                 'Second Option' => $question->options[1]->content,
                 'Third Option' => $question->options[2]->content,
                 'Fourth Option' => $question->options[3]->content,
                 'Correct Answer' => Question::getCorrectAnswer($question->options),
                 'actions' => '',
             ];
         })->values()->toArray();
     }
     public static function getQuestions($questions)
     {
         return $questions->map(function ($question) {
             return [
                 'id' => $question->id,
                 'Question' => $question->content,
                 'First Option' => $question->options[0]->content,
                 'Second Option' => $question->options[1]->content,
                 'Third Option' => $question->options[2]->content,
                 'Fourth Option' => $question->options[3]->content,
                 'Correct Answer' => Question::getCorrectAnswer($question->options),
                 'actions' => '',
             ];
         })->values()->toArray();
     }

     public static function getGrammarQuestionsForChoosePanel($questions)
     {
         return $questions->map(function ($question) {
             return [
                 'check'=>'',
                 'id' => $question->id,
                 'Question' => $question->content,
                 'Question Type' => $question->type->name,
                 'First Option' => $question->options[0]->content,
                 'Second Option' => $question->options[1]->content,
                 'Third Option' => $question->options[2]->content,
                 'Fourth Option' => $question->options[3]->content,
                 'Correct Answer' => Question::getCorrectAnswer($question->options),
                 'actions' => '',
             ];
         })->values()->toArray();
     }
     public static function getQuestionsForChoosePanel($questions)
     {
         return $questions->map(function ($question) {
             return [
                 'check'=>'',
                 'id' => $question->id,
                 'Question' => $question->content,
                 'First Option' => $question->options[0]->content,
                 'Second Option' => $question->options[1]->content,
                 'Third Option' => $question->options[2]->content,
                 'Fourth Option' => $question->options[3]->content,
                 'Correct Answer' => Question::getCorrectAnswer($question->options),
                 'actions' => '',
             ];
         })->values()->toArray();
     }
}
?>
