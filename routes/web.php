<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('/');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('check_roles');
//Route::get('/res',function (){
//    $date = now()->toDateString();
//    $date2 = now()->addDays(10)->toDateString();
//    //dd($date);
//   $res= \App\Reservation::create([
//        'start'=>$date,
//        'end'=>$date2
//    ]);
//   dd($res);
//});
//search bar functionality to search for students by phone number
Route::any('/search', function () {
    $q = request()->get('q');
    $student = \App\Student::where('phone', 'LIKE', '%' . $q . '%')->get();
    if (count($student) > 0)
        return redirect()->back()->with('details', $student);
    else return redirect()->back()->with('message', 'No Students found. Try to search again !');
})->name('student.search');
//Route::get('/result',function (){
//    dd(session()->all());
//})->name('result');
Route::view('/error', 'error')->name('error');
Route::view('/cpanel', 'cpanel.index')->name('admin')->middleware(['auth', 'admin']);
//Route::resource('student','StudentsController')->middleware(['auth','admin']);
Route::resource('student', 'StudentsController')
    ->only(['index', 'show', 'update'])
    ->middleware(['auth', 'admin']);
//Route::get('/student','StudentsController@index')->name('student.index');
//Route::get('/student/{student}','StudentsController@show')->name('student.show');
//Route::put('/student/{student}','StudentsController@update')->name('student.update');
Route::get('/st', function () {
    return 'Welcome Student';
})->name('student')->middleware('check_student');
//Route::get('/rule',function(){
//   dd(auth()->user()->getRoleID());
//});
Route::view('/cpanel/questions', 'questions')->name('questions.index')->middleware(['auth', 'admin']);
Route::view('/cpanel/reading', 'reading.index')->name('reading.index')->middleware(['auth', 'admin']);
Route::resource('res', 'ReservationsController')->middleware(['auth', 'admin']);

Route::resource('res/{re}/group', 'GroupsController')->middleware(['auth', 'admin']);
#region grammar
Route::resource('grammar/question', 'GrammarQuestionsController')
    ->middleware(['auth', 'admin'])->except(['show'])
    ->names([
        'create' => 'grammar.question.create',
        'store' => 'grammar.question.store',
        'update' => 'grammar.question.update',
        'edit' => 'grammar.question.edit',
        'index' => 'grammar.question.index',
        'destroy' => 'grammar.question.destroy',
    ]);
Route::resource('grammar/exam', 'GrammarExamController')
    ->middleware(['auth', 'admin'])
    ->names([
        'create' => 'grammar.exam.create',
        'store' => 'grammar.exam.store',
        'update' => 'grammar.exam.update',
        'edit' => 'grammar.exam.edit',
        'index' => 'grammar.exam.index',
        'destroy' => 'grammar.exam.destroy',
        'show' => 'grammar.exam.show',
    ]);;
#endregion
//Groups Section
Route::get('/group/{group}/students', 'GroupsController@showStudents')->name('group.students.show')->middleware(['auth', 'admin']);
Route::post('/group/{group}/students', 'GroupsController@addStudents')->name('group.students.store')->middleware(['auth', 'admin']);
Route::post('/group/{group}/exam/create', 'GroupsController@generateExam')->name('group.generate.exam')->middleware(['auth', 'admin']);


//Paragraphs Questions

Route::resource('reading/paragraph', 'ParagraphsController')->middleware(['auth', 'admin']);
Route::resource('reading/{paragraph}/question', 'ParagraphQuestionsController')
    ->except(['index', 'show'])
    ->names([
        'create' => 'paragraph.question.create',
        'store' => 'paragraph.question.store',
        'update' => 'paragraph.question.update',
        'edit' => 'paragraph.question.edit',
        'destroy' => 'paragraph.question.destroy',
    ]);
Route::resource('reading/exam', 'ReadingExamsController')
    ->names([
        'create' => 'reading.exam.create',
        'store' => 'reading.exam.store',
        'update' => 'reading.exam.update',
        'edit' => 'reading.exam.edit',
        'destroy' => 'reading.exam.destroy',
        'index' => 'reading.exam.index',
        ]);
Route::get('reading/exam/{exam}/paragraphs','ReadingExamsController@showParagraphs')->name('reading.exam.show.paragraphs');
Route::get('reading/exam/{exam}/vocab','ReadingExamsController@showVocab')->name('reading.exam.show.vocab');
Route::view('cpanel/exams','cpanel.exams')->name('exams.index');

Route::resource('reading/vocab', 'VocabQuestionsController')->except(['show']);
