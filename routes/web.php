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
Route::any('/search',function(){
    $q = request()->get ( 'q' );
    $student = \App\Student::where('phone','LIKE','%'.$q.'%')->get();
    if(count($student) > 0)
        return redirect()->back()->with('details',$student);
    else return redirect()->back()->with('message','No Students found. Try to search again !');
})->name('student.search');
Route::get('/result',function (){
    dd(session()->all());
})->name('result');
Route::view('/error','error')->name('error');
Route::view('/cpanel','cpanel.index')->name('admin')->middleware(['auth','admin']);
//Route::resource('student','StudentsController')->middleware(['auth','admin']);
Route::get('/student','StudentsController@index')->name('student.index');
Route::get('/student/{student}','StudentsController@show')->name('student.show');
Route::put('/student/{student}','StudentsController@update')->name('student.update');
Route::get('/st',function (){
    return 'Welcome Student';
})->name('student')->middleware('check_student');
//Route::get('/rule',function(){
//   dd(auth()->user()->getRoleID());
//});
Route::view('/cpanel/questions','questions.index')->name('questions.index')->middleware(['auth','admin']);
Route::resource('res','ReservationsController')->middleware(['auth','admin']);
Route::resource('grammar','GrammarQuestionsController')->middleware(['auth','admin'])->except(['show']);
Route::resource('paragraph','ParagraphsController')->middleware(['auth','admin']);
//Route::resource('group','GroupsController')->middleware(['auth','admin'])->except('create','store');
Route::resource('grammarExam','GrammarExamController')->middleware(['auth','admin']);

//Groups Section
Route::get('res/{re}/group/create','GroupsController@create')->name('group.create')->middleware(['auth','admin']);
Route::post('res/{re}/group','GroupsController@store')->name('group.store')->middleware(['auth','admin']);
Route::get('/group/{group}/students','GroupsController@showStudents')->name('group.students.show')->middleware(['auth','admin']);
Route::get('/group/{group}','GroupsController@show')->name('group.show')->middleware(['auth','admin']);
Route::get('/group/{group}/edit','GroupsController@edit')->name('group.edit')->middleware(['auth','admin']);
Route::put('/group/{group}','GroupsController@update')->name('group.update')->middleware(['auth','admin']);
Route::post('/group/{group}/students','GroupsController@addStudents')->name('group.students.store')->middleware(['auth','admin']);
Route::post('/group/{group}/exam/create','GroupsController@generateExam')->name('group.generate.exam')->middleware(['auth','admin']);
//Route::resource('reading','ReadingQuestionsController')->middleware(['auth','admin'])->except(['show','index']);

Route::get('/paragraph/{paragraph}/reading/create','ReadingQuestionsController@create')->name('reading.create');
Route::POST('/paragraph/{paragraph}/reading','ReadingQuestionsController@store')->name('reading.store');
Route::put('/paragraph/{paragraph}/reading/{question}','ReadingQuestionsController@update')->name('reading.update');
Route::get('/paragraph/{paragraph}/reading/{question}/edit','ReadingQuestionsController@edit')->name('reading.edit');
Route::delete('/paragraph/{paragraph}/reading/{question}','ReadingQuestionsController@destroy')->name('reading.destroy');


//Route::post('res/{re}','ReservationsController@generateGroups')->name('res.generate.group');
