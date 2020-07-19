<?php

namespace App;

use App\Grammar\GrammarAnswer;
use App\Grammar\GrammarResult;
use App\Listening\ListeningAnswer;
use App\Listening\ListeningResult;
use App\Reading\ParagraphAnswer;
use App\Reading\ReadingResult;
use App\Reading\VocabAnswer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Student extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }

    public function getVerifiedAttribute($option)
    {
        return $this->verifiedOptions()[$option];
    }

    public function getStudyingAttribute($option)
    {
        return $this->studyingOptions()[$option];
    }

    public function isOnline()
    {
        return Cache::has('student-is-online-' . $this->id) ? 'active' : 'not active';
    }

    public function verifiedOptions()
    {
        return [

            0 => 'Not Verified',
            1 => 'Verified',
        ];
    }

    public function studyingOptions()
    {
        return [

            1 => 'Ms.c(Master)',
            2 => 'PhD(Doctor)',
            3 => 'Board certified',
        ];
    }

    public function reservation()
    {
        return $this->belongsToMany(Reservation::class, 'student_reservation')
            ->withPivot(['student_documents_id', 'required_score', 'studying', 'verified'])->withTimestamps();
    }

    public function group()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }


    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function implementScoreEquation($marks)
    {
        $totalQuestions = Config::whereIn('id', [9, 10, 11, 12])->get()->map(function ($config) {
            return intval($config->value);
        })->sum();
        return ceil(($marks * 677) / $totalQuestions);
    }

    public function checkIfSuccess($marks)
    {
        return $marks > $this->reservation->last()->pivot->required_score;
    }

    public function sumAllMarks(int $grammarMarks = 0, int $readingMarks = 0, int $listeningMarks = 0)
    {

        if (is_null($this->attempts->last()->result)) {
            $marks = $grammarMarks + $readingMarks + $listeningMarks;
            $marks = $this->implementScoreEquation($marks);
            $this->results()->create([
                'attempt_id' => $this->attempts->last()->id,
                'mark' => intval($marks),
                'success' => $this->checkIfSuccess($marks),
            ]);
            $message = " solved toefl exam and has {" . $marks . "}";
            Logging::logStudent($this, $message);
        }
    }

    public function editResult($marks)
    {
        $result = $this->attempts->last()->result;
        $marks = $this->implementScoreEquation($marks);

        $result->update([
            'mark' => intval($marks),
            'success' => $this->checkIfSuccess($marks),
        ]);
    }

    public function isVerified()
    {
        return $this->reservation->last()->pivot->verified == 1;
    }

    public function CanEnterExam()
    {
        return Cache::has('group-can-enter-exam-' . $this->group->last()->id);
    }

    public function CanStartExam()
    {
        return Cache::has('group-can-start-exam-' . $this->group->last()->id);
    }

    public function deleteActiveSession()
    {
        Cache::forget('student-is-online-' . $this->id);
    }

    public static function getStudents($students)
    {

        return $students->map(function ($student) {
            //            $attempt=Attempt::where('reservation_id', $student->reservation->last()->id)->where('student_id', $student->id)->get()->first();
            $attempt = $student->attempts()->where('reservation_id', $student->reservation->last()->id)
                ->where('group_id', $student->group->last()->id)->get()->first();

            //            $failed = -1;
            if (is_null($attempt)) {
                $failed = -1;
            } else if (is_null($attempt->result))
                $failed = -1;
            else
                $failed =  intval($attempt->result->success);
            //                try{
            //                    $failed=  intval($attempt->result->success);
            //                }catch(\Exception $exception){
            //                    $failed=-1;
            //                }


            //                        ? true : $student->attempts->last()->reservation->id != $student->reservation->last()->id;
            return [
                'id' => $student->id,
                'Arabic Name' => $student->arabic_name,
                'English Name' => $student->user->name,
                'Reservation' => Carbon::parse($student->reservation->last()->start)->format('d-m-yy'),
                'phone' => $student->phone,
                'email' => $student->user->email,
                'verified' => $student->getVerifiedAttribute($student->reservation->last()->pivot->verified),
                'Studying Degree' => $student->getStudyingAttribute($student->reservation->last()->pivot->studying),
                'Required Score' => $student->reservation->last()->pivot->required_score,
                'Actions' => '',
                'failed' => $failed,
                'has_certificates' => $student->certificates->count() > 0,
            ];
        });
    }
    public static function filterStudents($students, $group)
    {
        return $students->filter(function ($student) use ($group) {
            return $student->attempts->where('group_id', $group->id)->count() > 0;
        })->filter(function ($student) use ($group) {
            return !is_null($student->attempts()->where('group_id', $group->id)->get()->first()->result);
        })
            ->filter(function ($student) use ($group) {
                return $student->attempts()->where('group_id', $group->id)->get()->first()->result->success == 0
                    && $student->reservation->last()->id == $group->reservation->id;
            });
    }
    public static function getExaminedStudents($students, $group)
    {

        return Student::filterStudents($students, $group)->map(function ($student) {
            return [
                'check' => '',
                'id' => $student->id,
                'Arabic Name' => $student->arabic_name,
                'English Name' => $student->user->name,
                'phone' => $student->phone,
                'email' => $student->user->email,
            ];
        });
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }
}
