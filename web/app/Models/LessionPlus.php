<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessionPlus extends Model
{
    use HasFactory;
    protected $primaryKey = 'lesson_id';
    protected $fillable = [
        'lesson_title',
        'lesson_level',
        'lesson_unit',
        'lesson_sort',
        'lesson_audio',
        'bulk_audio',
        'lesson_content',
        'lesson_content_2',
        'total_words',
        'lesson_tags',
    ];
}
