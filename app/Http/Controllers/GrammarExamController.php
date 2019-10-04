<?php

namespace App\Http\Controllers;

use App\Grammar\GrammarExam;
use App\Grammar\GrammarQuestion;
use App\Group;
use Illuminate\Http\Request;

class GrammarExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $exams= GrammarExam::all();
       return view('grammar.exams.index',compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

//        $groupCount = Group::all()->count();
//        $groups = Group::all();
//        for($i=0;$i<$groupCount;$i++){
//            GrammarExam::create([
//                'group_id'=>$groups[$i]->id
//            ]);
//        }


        //get the find questions and random them then insert them in the model (pivot)
       // $exam = GrammarExam::find(1);
        //$exam->questions()->attach(GrammarQuestion::all()->random(4));
//        dd($exam->getFillQuestions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param GrammarExam $grammarExam
     * @return void
     */
    public function show(GrammarExam $grammarExam)
    {
//        $questions = $grammarExam->questions()->orderBy('id', 'asc')->paginate(15);;
        $questions = $grammarExam->questions()->paginate(15);;
        return view('grammar.exams.show',compact('questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GrammarExam $grammarExam
     * @return void
     */
    public function edit(GrammarExam $grammarExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param GrammarExam $grammarExam
     * @return void
     */
    public function update(Request $request, GrammarExam $grammarExam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GrammarExam $grammarExam
     * @return void
     */
    public function destroy(GrammarExam $grammarExam)
    {
        //
    }
}
