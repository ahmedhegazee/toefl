<?php

namespace App\Http\Controllers;

use App\Grammar\GrammarQuestion;
use App\Group;
use App\Reading\Paragraph;
use App\Reading\VocabQuestion;
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
        return view('group.index', compact('groups'));
    }
    public function getStudents(Group $group)
    {
        $students =$group->students()->get();
        $data=$students->toArray();
        $received=[];
        for ($i=0;$i<count($students);$i++){
            $student=[];
            $student['id']=$data[$i]['id'];
            $student['name']=$students[$i]->user()->name;
            $student['arabic_name']=$data[$i]['arabic_name'];
            $student['email']=$students[$i]->user()->email;
            $student['verified']=$data[$i]['verified'];
            $student['active']=$students[$i]->isOnline();
            $student['enterexam']=$data[$i]['enterexam'];
            $student['startexam']=$data[$i]['startexam'];
            array_push($received,$student);
        }
        return response()->json($received);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Reservation $re
     * @return \Illuminate\Http\Response
     */
    public function create(Reservation $re)
    {
        return view('group.create', compact('re'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Reservation $re
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reservation $re)
    {
        $re->groups()->create($this->validateData());

        return redirect(route('res.show', ['re' => $re]));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $re, Group $group)
    {
        $students = $group->students()->paginate(15);
        return view('group.show', compact('students', 'group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $re, Group $group)
    {
        return view('group.update', compact('group', 're'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $re, Group $group)
    {
        $group->update($this->validateData());
        return redirect(route('res.show', ['re' => $group->reservation]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $re, Group $group)
    {

        // $group->delete();
    }

    public function validateData()
    {
        return \request()->validate([
            'name' => 'required|string'
        ]);
    }

    /**
     * @param Group $group
     * show all students to add them to this group
     */

    public function showStudents(Group $group)
    {
        $students = Student::paginate(15);
        return view('group.students.index', compact('group', 'students'));
    }

    /**
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addStudents(Request $request, Group $group)
    {
        foreach ($request->students as $student) {
            Student::find($student)->update(['group_id' => $group->id]);
        }
        return redirect(route('res.show', ['re' => $group->reservation]));
    }

    public function generateExam(Group $group)
    {
        $this->generateGrammarExam($group);
        $this->generateReadingExam($group);
        return redirect()->back();
    }


    /**
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateGrammarExam(Group $group)
    {
        $questionsCount = GrammarQuestion::all()->count();
        $fillQuestionCount = GrammarQuestion::fillQuestions()->count();
        $findQuestionCount = GrammarQuestion::findQuestions()->count();
        if ($questionsCount > 40 && $fillQuestionCount > 15 && $findQuestionCount > 25) {
            if ($group->grammarExam()->count() == 0) {
                //        create exam for this group
                $group->grammarExam()->create();
                $this->generateRandomGrammarQuestions($group);
            } else {

                $group->grammarExam->questions()->detach($group->grammarExam->questions);
                $this->generateRandomGrammarQuestions($group);
            }
            return redirect()->back();
        } else {
            return redirect()->back()->with('error', 'there is no enough grammar questions');
        }

    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateRandomGrammarQuestions(Group $group)
    {
        //attach fill questions to this exam in random matter
        $group->grammarExam->questions()->attach(GrammarQuestion::fillQuestions()->random(15));
        //attach find questions to this exam in random matter
        $group->grammarExam->questions()->attach(GrammarQuestion::findQuestions()->random(25));
    }

    public function generateReadingExam(Group $group)
    {
        $vocabQuestionCount = VocabQuestion::all()->count();
        $paragraphQuestionCount = Paragraph::all()->count();
        if (  $vocabQuestionCount > 30 && $paragraphQuestionCount > 5) {
            if ($group->readingExam()->count() == 0) {
                //        create exam for this group
                $group->readingExam()->create();
                $this->generateRandomReadingQuestions($group);
            } else {

                $group->readingExam->vocabQuestions()->detach($group->readingExam->vocabQuestions);
                $group->readingExam->paragraphs()->detach($group->readingExam->paragraphs);
                $this->generateRandomReadingQuestions($group);
            }
            return redirect()->back();
        } else {
            return redirect()->back()->with('error', 'there is no enough reading questions');
        }

    }

    /**
     * @param Group $group
     */
    public function generateRandomReadingQuestions(Group $group)
    {
        //attach fill questions to this exam in random matter
        $group->readingExam->vocabQuestions()->attach(VocabQuestion::all()->random(30));

        //attach paragraphs to this exam in random matter
        $group->readingExam->paragraphs()->attach(Paragraph::all()->random(5));


    }
}
