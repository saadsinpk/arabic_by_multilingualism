<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonQuestions extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $primaryKey = 'questionid';
    protected $fillable = [
        'questionid',
        'question',
        'question_tagline',
        'question_type',
        'question_marks',
        'question_answer',
        'question_lesson',
        'image',
        'audio',
    ];
}
