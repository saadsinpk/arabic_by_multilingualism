<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_transaction extends Model
{
    use HasFactory;
    protected $primaryKey = 'transaction_id';
     protected $fillable = [
        'gateway_transaction',
        'user_id',
        'amount',
    ];
}
