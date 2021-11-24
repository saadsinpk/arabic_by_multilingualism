<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'question_id';
    protected $fillable = [
        'user_id',
        'ques_id',
        'select_ans',
        'corrected_ans',
        'question_time',
    ];
}
