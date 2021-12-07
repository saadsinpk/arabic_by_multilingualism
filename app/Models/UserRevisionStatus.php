<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRevisionStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'revision_id';
    protected $fillable = [
        'user_id',
        'word_json',
        'english_json',
        'arabic_json',
        'audio_json',
        'revision_time',
    ];
}
