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

//Route::get('/result',function (){
//    dd(session()->all());
//})->name('result');
Route::view('/error', 'error')->name('error');
Route::view('/success', 'success')->name('success');
Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::view('/cpanel', 'cpanel.index')->name('admin');

    Route::group(['middleware' => ['manage-students-panel']], function () {
        Route::view('/cpanel/students-panel', 'cpanel.studentspanel')->name('cpanel.students-panel');
        Route::resource('student', 'StudentsController')
            ->only(['index', 'show', 'update']);
        Route::patch('/student/{student}/verify', 'StudentsController@verifyStudent')->name('student.verify');
        Route::patch('/student/{student}/new-reservation', 'StudentsController@moveStudentToNewReservation');
        Route::get('/reservations/available', 'ApiControllers\ApiController@getAvailableReservations');
//        Route::any('/search', function () {
//            $q = request()->get('q');
//            $student = \App\Student::where('phone', 'LIKE', '%' . $q . '%')->get();
//            if (count($student) > 0)
//                return redirect()->back()->with('details', $student);
//            else return redirect()->back()->with('message', 'No Students found. Try to search again !');
//        })->name('student.search');
    });
    Route::group(['middleware' => ['manage-grammar']], function () {
        Route::view('/cpanel/grammar', 'grammar.index')->name('grammar.index');
        Route::resource('/cpanel/grammar/question', 'GrammarControllers\GrammarQuestionsController')
            ->except(['show'])
            ->names([
                'create' => 'grammar.question.create',
                'store' => 'grammar.question.store',
                'update' => 'grammar.question.update',
                'edit' => 'grammar.question.edit',
                'index' => 'grammar.question.index',
                'destroy' => 'grammar.question.destroy',
            ]);
        Route::resource('/cpanel/grammar/exam', 'GrammarControllers\GrammarExamController')
            ->names([
                'create' => 'grammar.exam.create',
                'store' => 'grammar.exam.store',
                'update' => 'grammar.exam.update',
                'edit' => 'grammar.exam.edit',
                'index' => 'grammar.exam.index',
                'destroy' => 'grammar.exam.destroy',
                'show' => 'grammar.exam.show',
            ]);
        Route::resource('/cpanel/grammar/exam/{exam}/questions', 'GrammarControllers\GrammarExamQuestionsController')
            ->only(['index', 'store', 'destroy'])
            ->names([
                'store' => 'grammar.exam.questions.store',
                'destroy' => 'grammar.exam.questions.destroy',
                'index' => 'grammar.exam.questions.index'
            ]);
//        Route::get('/grammar/exam/{exam}/questions', 'GrammarExamController@showQuestions')->name('grammar.exam.questions.show');
//        Route::post('/grammar/exam/{exam}/questions', 'GrammarExamController@storeQuestions')->name('grammar.exam.questions.store');
//        Route::delete('/grammar/exam/{exam}/questions/{question}', 'GrammarExamController@destroyQuestions')->name('grammar.exam.questions.destroy');
        Route::get('/cpanel/grammar/live/{exam}', 'LiveExamsController@showGrammarExam')->name('grammar.live.exam.start');
        Route::post('/cpanel/grammar/live', 'LiveExamsController@storeGrammarExamAttempt')->name('grammar.live.exam.submit');
    });
    Route::group(['middleware' => ['manage-reading']], function () {
        Route::view('/cpanel/reading', 'reading.index')->name('reading.index');
        Route::view('/cpanel/reading/questions', 'reading.questions')->name('reading.questions.index');

        Route::resource('/cpanel/reading/vocab', 'ReadingControllers\VocabQuestionsController')->except(['show']);

        Route::resource('/cpanel/reading/paragraph', 'ReadingControllers\ParagraphsController')->middleware(['auth', 'admin']);
        Route::resource('/cpanel/reading/{paragraph}/question', 'ReadingControllers\ParagraphQuestionsController')
            ->except(['index', 'show'])
            ->names([
                'create' => 'paragraph.question.create',
                'store' => 'paragraph.question.store',
                'update' => 'paragraph.question.update',
                'edit' => 'paragraph.question.edit',
                'destroy' => 'paragraph.question.destroy',
            ]);
        Route::resource('/cpanel/reading/exam', 'ReadingControllers\ReadingExamsController')
            ->names([
                'create' => 'reading.exam.create',
                'store' => 'reading.exam.store',
                'update' => 'reading.exam.update',
                'edit' => 'reading.exam.edit',
                'destroy' => 'reading.exam.destroy',
                'index' => 'reading.exam.index',
            ])->except(['show']);
        Route::get('/cpanel/reading/exam/{exam}/paragraph', 'ReadingControllers\ReadingExamsController@showParagraphs')->name('reading.exam.show.paragraphs');
        Route::get('/cpanel/reading/exam/{exam}/vocab', 'ReadingControllers\ReadingExamsController@showVocab')->name('reading.exam.show.vocab');

        Route::resource('/cpanel/reading/exam/{exam}/vocab-questions','ReadingControllers\ReadingExamVocabQuestionsController')
            ->only(['index', 'store', 'destroy'])
            ->names([
                'store' => 'reading.exam.vocab.store',
                'destroy' => 'reading.exam.vocab.destroy',
                'index' => 'reading.exam.vocab.index'
            ]);
//        Route::get('/cpanel/reading/exam/{exam}/create/vocab', 'ReadingControllers\ReadingExamsController@addVocabQuestions')->name('reading.exam.add.vocab');
//        Route::post('/cpanel/reading/exam/{exam}/vocab', 'ReadingControllers\ReadingExamsController@storeVocabQuestions')->name('reading.exam.store.vocab');
//        Route::delete('/cpanel/reading/exam/{exam}/vocab/{question}', 'ReadingControllers\ReadingExamsController@destroyVocabQuestionss')->name('reading.exam.destroy.vocab');
//
        Route::resource('/cpanel/reading/exam/{exam}/paragraphs','ReadingControllers\ReadingExamParagraphsController')
            ->only(['index', 'store', 'destroy'])
            ->names([
                'store' => 'reading.exam.paragraph.store',
                'destroy' => 'reading.exam.paragraph.destroy',
                'index' => 'reading.exam.paragraph.index'
            ]);
//        Route::get('/cpanel/reading/exam/{exam}/create/paragraphs', 'ReadingControllers\ReadingExamsController@addParagraphs')->name('reading.exam.add.paragraphs');
//        Route::post('/cpanel/reading/exam/{exam}/paragraphs', 'ReadingControllers\ReadingExamsController@storeParagraphs')->name('reading.exam.store.paragraphs');
//        Route::delete('/cpanel/reading/exam/{exam}/paragraphs/{paragraph}', 'ReadingControllers\ReadingExamsController@destroyParagraphs')->name('reading.exam.destroy.paragraphs');

        Route::get('/cpanel/live/reading/{exam}', 'LiveExamsController@showReadingExam')->name('reading.live.exam.start');
        Route::post('/cpanel/live/reading', 'LiveExamsController@storeReadingExamAttempt')->name('reading.live.exam.submit');
    });
    Route::group(['middleware' => ['manage-listening']], function () {
        Route::view('cpanel/listening', 'listening.index')->name('listening.index');
        Route::resource('/cpanel/listening/audio', 'ListeningControllers\AudiosController');
        Route::resource('/cpanel/listening/audio/{audio}/question', 'ListeningControllers\ListeningQuestionsController')->names([
            'create' => 'listening.question.create',
            'store' => 'listening.question.store',
            'update' => 'listening.question.update',
            'edit' => 'listening.question.edit',
            'destroy' => 'listening.question.destroy',
        ])->except(['show', 'index']);
        Route::resource('/cpanel/listening/exam', 'ListeningControllers\ListeningExamController')
            ->names([
                'create' => 'listening.exam.create',
                'store' => 'listening.exam.store',
                'update' => 'listening.exam.update',
                'edit' => 'listening.exam.edit',
                'index' => 'listening.exam.index',
                'destroy' => 'listening.exam.destroy',
                'show' => 'listening.exam.show',
            ]);;
            Route::resource('/cpanel/listening/exam/{exam}/audio','ListeningControllers\ListeningExamAudiosController')->only(['index', 'store', 'destroy'])
                ->names([
                    'store' => 'listening.exam.audio.store',
                    'destroy' => 'listening.exam.audio.destroy',
                    'index' => 'listening.exam.audio.index'
                ]);
//        Route::get('/cpanel/listening/exam/{exam}/audio', 'ListeningControllers\ListeningExamController@showAudios')->name('listening.exam.audios.show');
//        Route::post('/cpanel/listening/exam/{exam}/audio', 'ListeningControllers\ListeningExamController@storeAudios')->name('listening.exam.audios.store');
//        Route::delete('/cpanel/listening/exam/{exam}/audio/{audio}', 'ListeningControllers\ListeningExamController@destroyAudios')->name('listening.exam.audios.destroy');

        Route::get('/cpanel/live/listening/{exam}', 'LiveExamsController@showListeningExam')->name('listening.live.exam.start');
        Route::post('/cpanel/live/listening', 'LiveExamsController@storeListeningExamAttempt')->name('listening.live.exam.submit');
    });
    Route::group(['middleware' => ['print-certificates']], function () {
        Route::view('/cpanel/certificates-panel', 'cpanel.certificatesControlPanel')->name('cpanel.certificates-panel');
        Route::get('/students/{reservation}/print', 'ApiControllers\ApiController@printPDF');
        Route::get('/students/{reservation}/certificates', 'ApiControllers\ApiController@getStudentsForCertificates');
    });
    Route::group(['middleware' => ['edit-student-marks']], function () {
        Route::view('/cpanel/marks', 'cpanel.failedStudents')->name('cpanel.marks-panel');
        Route::get('/reservations/', 'ApiControllers\ApiController@getReservations');
        Route::get('/students/{reservation}/failed', 'ApiControllers\ApiController@getFailedStudents');
        Route::patch('/students/marks', 'ApiControllers\ApiController@updateStudentMarks');

    });
    Route::group(['middleware' => ['manage-exams-panel']], function () {
        Route::view('/cpanel/exam-panel', 'exams.examControlPanel')->name('cpanel.exams-panel');
        Route::post('/attempt/{student}', 'ApiControllers\ApiController@checkStudentAttempt');
        Route::get('/reservations/', 'ApiControllers\ApiController@getReservations');
        Route::get('/groups/{res}', 'ApiControllers\ApiController@getGroups');
        Route::get('/students/{group}', 'ApiControllers\ApiController@getStudents');
        Route::post('/students/{group}/enter', 'ApiControllers\ExamsApiController@studentsCanEnterExam');
        Route::post('/students/{group}/start', 'ApiControllers\ExamsApiController@studentsCanStartExam');
        Route::post('/students/{group}/stop', 'ApiControllers\ExamsApiController@endExam');
        Route::get('/students/{group}/entered', 'ApiControllers\ExamsApiController@isExamEntered');
        Route::get('/students/{group}/started', 'ApiControllers\ExamsApiController@isExamStarted');
        Route::get('/students/{group}/working', 'ApiControllers\ExamsApiController@isExamWorking');
        Route::get('/group/{group}/hasExams', 'ApiControllers\ExamsApiController@isGroupHasExams');
    });
    Route::group(['middleware' => ['super-admin']], function () {
        Route::view('/cpanel/users-panel', 'cpanel.userspanel')->name('cpanel.users-panel');
        Route::view('/cpanel/configs-panel', 'cpanel.configpanel')->name('cpanel.configs-panel');


        Route::get('/users', 'ApiControllers\ApiController@getAllUsers');
        Route::get('/configs', 'ApiControllers\ApiController@getConfigs');
        Route::patch('/configs/update', 'ApiControllers\ApiController@updateConfig');
        Route::patch('/users/{user}', 'ApiControllers\ApiController@updateUser');
        Route::delete('/users/{user}', 'ApiControllers\ApiController@destroyUser');
        Route::patch('/roles/{user}', 'ApiControllers\ApiController@updateUserRoles');
        Route::post('/users/store', 'ApiControllers\ApiController@addNewUser');
    });
    Route::group(['middleware' => ['manage-reservations-panel']], function () {
        Route::resource('/cpanel/res', 'ReservationsController');

        Route::resource('/cpanel/res/{re}/group', 'GroupsController');
    });


});
Route::post('/users/unique-email', 'ApiControllers\ApiController@checkEmailIsUnique');
Route::post('/students/unique-phone', 'ApiControllers\ApiController@checkPhoneIsUnique');
//Route::resource('student','StudentsController')->middleware(['auth','admin']);
//Route::get('/student','StudentsController@index')->name('student.index');
//Route::get('/student/{student}','StudentsController@show')->name('student.show');
//Route::put('/student/{student}','StudentsController@update')->name('student.update');
//Route::get('/rule',function(){
//   dd(auth()->user()->getRoleID());
//});

#region grammar
#endregion
//Groups Section
//Route::get('/group/{group}/students', 'GroupsController@showStudents')->name('group.students.show')->middleware(['auth', 'admin']);
//Route::post('/group/{group}/students', 'GroupsController@addStudents')->name('group.students.store')->middleware(['auth', 'admin']);
//Route::post('/group/{group}/exam/create', 'GroupsController@generateExam')->name('group.generate.exam')->middleware(['auth', 'admin']);


//Paragraphs Questions


//listening section


//Exams
Route::group(['middleware' => ['auth','check_student','student_is_online']], function () {
    Route::get('/exam/home', 'ExamsController@showStudentHome')->name('student.home')->middleware(['has_only_one_attempt']);
    Route::group(['middleware' => 'can_start_exam'], function () {
        Route::get('/exam/grammar', 'ExamsController@showGrammarExam')->name('grammar.exam.start');
        Route::post('/exam/grammar', 'ExamsController@storeGrammarExamAttempt')->name('grammar.exam.submit');
        Route::get('/exam/reading', 'ExamsController@showReadingExam')->name('reading.exam.start');
        Route::post('/exam/reading', 'ExamsController@storeReadingExamAttempt')->name('reading.exam.submit');
        Route::get('/exam/listening', 'ExamsController@showListeningExam')->name('listening.exam.start');
        Route::post('/exam/listening', 'ExamsController@storeListeningExamAttempt')->name('listening.exam.submit');

    });

});

//live exams


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
