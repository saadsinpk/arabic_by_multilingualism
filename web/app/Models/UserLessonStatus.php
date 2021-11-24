<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLessonStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'lesson_status_id';
     protected $fillable = [
        'lesson_id',
        'user_id',
        'lesson_status_time',
    ];
}
