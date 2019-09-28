<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index()
    {
       $students= Student::paginate(15);
        return view('students.index',compact('students'));
    }

    public function show(Student $student)
    {
        return view('students.show',compact('student'));
    }
    public function update(Student $student)
    {
        $student->update(['verified'=>1]);
        return redirect(route('student.index'));
    }
}
