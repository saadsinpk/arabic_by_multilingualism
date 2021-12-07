<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRemindStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'remind_id';
    protected $fillable = [
        'user_id',
        'word_json',
        'english_json',
        'arabic_json',
        'audio_json',
        'remind_time',
    ];
}
