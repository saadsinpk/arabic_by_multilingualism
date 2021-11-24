<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'user_messages';
    protected $dates= ['created_at'];
    protected $primaryKey = 'message_id';
    protected $fillable = [
        'message_id',
        'message',
    ];
}
