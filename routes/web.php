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
Route::get('/res',function (){
    $date = now()->toDateString();
    $date2 = now()->addDays(10)->toDateString();
    //dd($date);
   $res= \App\Resarvation::create([
        'start'=>$date,
        'end'=>$date2
    ]);
   dd($res);
});
Route::view('/error','error')->name('error');
Route::view('/cpanel','cpanel.index')->name('admin');
Route::get('/student','StudentsController@index')->name('student.index');
Route::get('/student/{student}','StudentsController@show')->name('student.show');
//Route::view('/student','students.index')->name('student')->middleware('check_student');
Route::put('/student/{student}','StudentsController@update')->name('student.update');
Route::get('/rule',function(){
   dd(auth()->user()->getRoleID());
});

Route::resource('res','ReservationsController');
