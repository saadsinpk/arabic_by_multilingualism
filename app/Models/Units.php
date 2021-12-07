<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Units extends Model
{
    use HasFactory;
    protected $primaryKey = 'unit_id';
    protected $fillable = [
        'unit_id',
        'unit_name',
        'unit_sort',
        'unit_level',
    ];

}
