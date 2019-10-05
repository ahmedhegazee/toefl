<?php

namespace App\Http\Controllers;

use App\Grammar\GrammarQuestion;
use App\Group;
use App\Reservation;
use App\Student;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        return view('group.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Reservation $re
     * @return \Illuminate\Http\Response
     */
    public function create(Reservation $re)
    {
        return view('group.create',compact('re'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Reservation $re
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Reservation $re)
    {
        $re->groups()->create($this->validateData());

            return redirect(route('res.show',['re'=>$re]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $re,Group $group)
    {
        $students= $group->students;
        return view('group.show',compact('students','group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $re,Group $group)
    {
        return view('group.update',compact('group','re'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Reservation $re, Group $group)
    {
       $group->update($this->validateData());
        return redirect(route('res.show',['re'=>$group->reservation]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $re,Group $group)
    {

       // $group->delete();
    }

    public function validateData()
    {
        return \request()->validate([
            'name'=>'required|string'
        ]);
    }

    /**
     * @param Group $group
     * show all students to add them to this group
     */

    public function showStudents(Group $group)
    {
        $students = Student::paginate(15);
        return view('group.students.index',compact('group','students'));
    }

    /**
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addStudents(Request $request, Group $group)
    {
        foreach ($request->students as $student){
            Student::find($student)->update(['group_id'=>$group->id]);
        }
        return redirect(route('res.show',['re'=>$group->reservation]));
    }

    public function generateExam(Group $group)
    {
        $questionsCount= GrammarQuestion::all()->count();
       $fillQuestionCount= GrammarQuestion::where('grammar_question_type_id',1)->count();
       $findQuestionCount= GrammarQuestion::where('grammar_question_type_id',2)->count();
       if($questionsCount>40 &&$fillQuestionCount>15&&$findQuestionCount>25) {
           if($group->exam()->count()==0){
               //        create exam for this group
               $group->exam()->create();
               $this->generateRandomQuestions($group);
           }
           else
           {

               $group->exam->questions()->detach($group->exam->questions);
               $this->generateRandomQuestions($group);
           }
           return redirect()->back();
       }
       else{
           return redirect()->back()->with('error','there is no enough questions');
       }

    }

    /**
     * @param Group $group
     */
    public function generateRandomQuestions(Group $group)
    {
        //attach fill questions to this exam in random matter
        $group->exam->questions()->attach(GrammarQuestion::where('grammar_question_type_id',1)->get()->random(15));
        //attach find questions to this exam in random matter
        $group->exam->questions()->attach(GrammarQuestion::where('grammar_question_type_id',2)->get()->random(25));
        return redirect()->back();
    }
}
