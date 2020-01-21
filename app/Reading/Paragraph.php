<?php

namespace App\Reading;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->hasMany(ParagraphQuestion::class);
    }
    public function exam()
    {
        return $this->belongsToMany(ReadingExam::class);

    }

    public static function getParagraphs($paragraphs)
    {
        return $paragraphs->map(function ($paragraph) {
            return [
                'id' => $paragraph->id,
                'title' => $paragraph->title,
                'Questions' => $paragraph->questions->count(),
                'actions' => '',
            ];
        })->values()->toArray();
    }
    public static function getParagraphsForChoose($paragraphs)
    {
        return $paragraphs->map(function ($paragraph) {
            return [
                'check'=>'',
                'id' => $paragraph->id,
                'title' => $paragraph->title,
                'Questions' => $paragraph->questions->count(),
                'actions' => '',
            ];
        })->values()->toArray();
    }
}
