<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Levels extends Model
{
    use HasFactory;
    protected $primaryKey = 'level_id';
    protected $fillable = [
        'level_id',
        'level_name',
        'level_sort',
        'level_min_marks',
        'level_max_marks',
    ];

}
