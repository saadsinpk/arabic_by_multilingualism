<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;
    protected $primaryKey = 'questionid';
    protected $fillable = [
        'questionid',
        'question',
        'question_tagline',
        'question_type',
        'question_marks',
        'question_answer',
        'image',
        'audio',
    ];
}
