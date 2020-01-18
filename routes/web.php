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


use App\Attempt;
use Barryvdh\DomPDF\PDF;

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
Route::view('/success', 'success')->name('success');
Route::view('/cpanel', 'cpanel.index')->name('admin')->middleware(['auth', 'admin']);
//Route::resource('student','StudentsController')->middleware(['auth','admin']);
Route::resource('student', 'StudentsController')
    ->only(['index', 'show', 'update'])
    ->middleware(['auth', 'admin']);
//Route::get('/student','StudentsController@index')->name('student.index');
//Route::get('/student/{student}','StudentsController@show')->name('student.show');
//Route::put('/student/{student}','StudentsController@update')->name('student.update');
//Route::get('/rule',function(){
//   dd(auth()->user()->getRoleID());
//});
Route::view('/cpanel/questions', 'questions')->name('questions.index')->middleware(['auth', 'admin']);
Route::view('/cpanel/reading', 'reading.index')->name('reading.index')->middleware(['auth', 'admin']);
Route::view('/cpanel/users', 'cpanel.userspanel')->middleware(['auth', 'admin']);
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
    ]);
Route::get('/grammar/exam/{exam}/questions', 'GrammarExamController@showQuestions')->name('grammar.exam.questions.show');
Route::post('/grammar/exam/{exam}/questions', 'GrammarExamController@storeQuestions')->name('grammar.exam.questions.store');
Route::delete('/grammar/exam/{exam}/questions/{question}', 'GrammarExamController@destroyQuestions')->name('grammar.exam.questions.destroy');
#endregion
//Groups Section
Route::get('/group/{group}/students', 'GroupsController@showStudents')->name('group.students.show')->middleware(['auth', 'admin']);
Route::post('/group/{group}/students', 'GroupsController@addStudents')->name('group.students.store')->middleware(['auth', 'admin']);
//Route::post('/group/{group}/exam/create', 'GroupsController@generateExam')->name('group.generate.exam')->middleware(['auth', 'admin']);


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
Route::get('reading/exam/{exam}/paragraphs', 'ReadingExamsController@showParagraphs')->name('reading.exam.show.paragraphs');
Route::get('reading/exam/{exam}/vocab', 'ReadingExamsController@showVocab')->name('reading.exam.show.vocab');
Route::view('cpanel/exams', 'cpanel.exams')->name('exams.index');

Route::resource('reading/vocab', 'VocabQuestionsController')->except(['show']);

Route::get('reading/exam/{exam}/create/paragraphs', 'ReadingExamsController@addParagraphs')->name('reading.exam.add.paragraphs');
Route::post('reading/exam/{exam}/paragraphs', 'ReadingExamsController@storeParagraphs')->name('reading.exam.store.paragraphs');
Route::delete('reading/exam/{exam}/paragraphs/{paragraph}', 'ReadingExamsController@destroyParagraphs')->name('reading.exam.destroy.paragraphs');
Route::get('reading/exam/{exam}/create/vocab', 'ReadingExamsController@addVocabQuestions')->name('reading.exam.add.vocab');
Route::post('reading/exam/{exam}/vocab', 'ReadingExamsController@storeVocabQuestions')->name('reading.exam.store.vocab');
Route::delete('reading/exam/{exam}/vocab/{question}', 'ReadingExamsController@destroyVocabQuestionss')->name('reading.exam.destroy.vocab');

//listening section


Route::resource('listening/audio', 'AudiosController');
Route::resource('listening/audio/{audio}/question', 'ListeningQuestionsController')->names([
    'create' => 'listening.question.create',
    'store' => 'listening.question.store',
    'update' => 'listening.question.update',
    'edit' => 'listening.question.edit',
    'destroy' => 'listening.question.destroy',
])->except(['show', 'index']);
Route::resource('listening/exam', 'ListeningExamController')
    ->middleware(['auth', 'admin'])
    ->names([
        'create' => 'listening.exam.create',
        'store' => 'listening.exam.store',
        'update' => 'listening.exam.update',
        'edit' => 'listening.exam.edit',
        'index' => 'listening.exam.index',
        'destroy' => 'listening.exam.destroy',
        'show' => 'listening.exam.show',
    ]);;
Route::get('/listening/exam/{exam}/audio', 'ListeningExamController@showAudios')->name('listening.exam.audios.show');
Route::post('/listening/exam/{exam}/audio', 'ListeningExamController@storeAudios')->name('listening.exam.audios.store');
Route::delete('/listening/exam/{exam}/audio/{audio}', 'ListeningExamController@destroyAudios')->name('listening.exam.audios.destroy');


//Exams
Route::get('/exam/home', 'ExamsController@showStudentHome')->name('student.home')->middleware('has_only_one_attempt');
Route::get('/exam/grammar', 'ExamsController@showGrammarExam')->name('grammar.exam.start')->middleware(['can_start_exam']);
Route::post('/exam/grammar', 'ExamsController@storeGrammarExamAttempt')->name('grammar.exam.submit')->middleware(['can_start_exam']);
Route::get('/exam/reading', 'ExamsController@showReadingExam')->name('reading.exam.start')->middleware(['can_start_exam']);
Route::post('/exam/reading', 'ExamsController@storeReadingExamAttempt')->name('reading.exam.submit')->middleware(['can_start_exam']);
Route::get('/exam/listening', 'ExamsController@showListeningExam')->name('listening.exam.start')->middleware(['can_start_exam']);
Route::post('/exam/listening', 'ExamsController@storeListeningExamAttempt')->name('listening.exam.submit')->middleware(['can_start_exam']);

//live exams
Route::view('/exam/cpanel', 'exams.examControlPanel');
Route::get('/live/{exam}/grammar', 'LiveExamsController@showGrammarExam')->name('grammar.live.exam.start');
Route::post('/live/grammar', 'LiveExamsController@storeGrammarExamAttempt')->name('grammar.live.exam.submit');
Route::get('/live/{exam}/reading', 'LiveExamsController@showReadingExam')->name('reading.live.exam.start');
Route::post('/live/reading', 'LiveExamsController@storeReadingExamAttempt')->name('reading.live.exam.submit');
Route::get('/live/{exam}/listening', 'LiveExamsController@showListeningExam')->name('listening.live.exam.start');
Route::post('/live/listening', 'LiveExamsController@storeListeningExamAttempt')->name('listening.live.exam.submit');

//Api routes
Route::group(['middleware' => ['admin','auth']], function () {
    Route::view('/cpanel/certificates', 'cpanel.certificatesControlPanel');
    Route::view('/cpanel/marks', 'cpanel.failedStudents');
    Route::view('/cpanel/configs', 'cpanel.configpanel');
    Route::get('/students/{reservation}/print', 'ApiController@printPDF');
    Route::get('/students/{reservation}/certificates', 'ApiController@getStudentsForCertificates');
    Route::post('/attempt/{student}', 'ApiController@checkStudentAttempt');
    Route::get('/reservations/', 'ApiController@getReservations');
    Route::get('/groups/{res}', 'ApiController@getGroups');
    Route::get('/students/{group}', 'ApiController@getStudents');
    Route::post('/students/{group}/enter', 'ApiController@studentsCanEnterExam');
    Route::post('/students/{group}/start', 'ApiController@studentsCanStartExam');
    Route::post('/students/{group}/stop', 'ApiController@endExam');
    Route::get('/students/{group}/entered', 'ApiController@isExamEntered');
    Route::get('/students/{group}/started', 'ApiController@isExamStarted');
    Route::get('/students/{group}/working', 'ApiController@isExamWorking');
    Route::get('/group/{group}/hasExams', 'ApiController@isGroupHasExams');
    Route::get('/students/{reservation}/failed', 'ApiController@getFailedStudents');
    Route::get('/users', 'ApiController@getAllUsers');
    Route::get('/configs', 'ApiController@getConfigs');
    Route::patch('/students/marks','ApiController@updateStudentMarks');
    Route::patch('/configs/update','ApiController@updateConfig');
    Route::patch('/users/{user}','ApiController@updateUser');
    Route::delete('/users/{user}','ApiController@destroyUser');
    Route::patch('/roles/{user}','ApiController@updateUserRoles');
    Route::post('/users/store','ApiController@addNewUser');
    Route::post('/users/unique-email','ApiController@checkEmailIsUnique');
    Route::post('/students/unique-phone','ApiController@checkPhoneIsUnique');

});
//for development purposes
/*
Route::get("/short", function () {
    $short = App\Listening\Audio::shortConversation()->get();
    foreach ($short as $audio) {
        $question = $audio->questions()->create([
            'content' => "Short Question"
        ]);
        for ($i = 0; $i < 4; $i++)
            $question->options()->create([
                'content' => "Option" . ($i + 1),
            ]);
        $question->options[0]->update(['correct' => 0]);
    }
});
Route::get("/long", function () {
    $short = App\Listening\Audio::longConversation()->get();
    foreach ($short as $audio) {
        for ($j = 0; $j < 2; $j++) {
            $question = $audio->questions()->create([
                'content' => "Long Question"
            ]);
            for ($i = 0; $i < 4; $i++)
                $question->options()->create([
                    'content' => "Option" . ($i + 1),
                ]);
            $question->options[0]->update(['correct' => 0]);
        }

    }
});
Route::get("/speech", function () {
    $short = App\Listening\Audio::speech()->get();
    foreach ($short as $audio) {
        for ($j = 0; $j < 5; $j++) {
            $question = $audio->questions()->create([
                'content' => "Speech Question"
            ]);
            for ($i = 0; $i < 4; $i++)
                $question->options()->create([
                    'content' => "Option" . ($i + 1),
                ]);
            $question->options[0]->update(['correct' => 0]);
        }

    }
});
*/
