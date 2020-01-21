<?php

namespace App\Http\Controllers\GrammarControllers;

use App\Grammar\GrammarQuestion;
use App\Grammar\GrammarQuestionType;
use App\Http\Controllers\Controller;
use App\Logging;
use App\Question;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GrammarQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $questions = GrammarQuestion::with('options','type')->paginate(15);
//        $questions1 = GrammarQuestion::all()
//            ->map(function ($question) {
//                return [
//                    'id' => $question->id,
//                    'Question' => $question->content,
//                    'Question Type' => $question->type->name,
//                    'First Option' => $question->options[0]->content,
//                    'Second Option' => $question->options[1]->content,
//                    'Third Option' => $question->options[2]->content,
//                    'Fourth Option' => $question->options[3]->content,
//                    'Correct Answer' => Question::getCorrectAnswer($question->options),
//                    'actions' => '',
//                ];
//            })->values()->toArray();
        $questions1=Question::getGrammarQuestions(GrammarQuestion::all());
        $questions1 = json_encode($questions1);
//        return view('grammar.questions.index',compact('questions','questions1'));
        return view('grammar.questions.index',compact('questions1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        $types=GrammarQuestionType::all();
        return view('grammar.questions.create',compact('options','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $question=GrammarQuestion::create([
           'content'=>$request['content'],
           'grammar_question_type_id'=>$request['type']
       ]);
        $message=" add new grammar question with id {".$question->id."}";
        Logging::logProfessor(auth()->user(),$message);
       foreach($request->options as $option){
           $question->options()->create([
               'content'=>$option
           ]);
       }
       $question->options[$request->correct-1]->update(['correct'=>1]);
        return \redirect()->to(route('grammar.question.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param GrammarQuestion $question
     * @return \Illuminate\Http\Response
     */
    public function edit(GrammarQuestion $question)
    {

        $previous=url()->previous();
        session([
            'previous'=>$previous,
        ]);
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        $types=GrammarQuestionType::all();
        return view('grammar.questions.update',compact('question','options','types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param GrammarQuestion $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, GrammarQuestion $question)
    {
        $this->validator($request->all())->validate();
        $message=" update grammar question with id {".$question->id."} ";
        Logging::logProfessor(auth()->user(),$message);
        $question->update([
            'content'=>$request['content'],
            'grammar_question_type_id'=>$request['type'],
            ]);
        $question->options()->delete();
        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option,

            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        if(session()->has('previous'))
            return \redirect()->to(session()->get('previous'));
        else
            return \redirect()->to(route('grammar.question.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GrammarQuestion $question
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(GrammarQuestion $question)
    {
        $check=false;
        if($question->exam()->count()==0){
            $message=" delete grammar question with id {".$question->id."} ";
            Logging::logProfessor(auth()->user(),$message);
            $question->options()->delete();
            $question->delete();
            $check=true;
        }
        return response()->json(['success'=>$check]);
//        return Redirect::action('GrammarQuestionsController@index');

    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator( $data)
    {
        $message=[
            'options.0.required'=>'First Option field is required.',
            'options.1.required'=>'Second Option field is required.',
            'options.2.required'=>'Third Option field is required.',
            'options.3.required'=>'Fourth Option field is required.',
            'content.required'=>'Question Content field is required.',

        ];
        $roles =[
            'content' => 'required|string',
            'options' => 'required|array|min:4',
            'options.*' => 'required|string|distinct',
            'correct'=>'required|numeric',
            'type'=>'required|numeric'
        ];
       return Validator::make($data,$roles,$message);

    }

}
