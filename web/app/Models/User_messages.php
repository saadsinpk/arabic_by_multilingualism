<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\User;
use Carbon\Carbon;

class User_messages extends Model
{
    use HasFactory;
    protected $primaryKey = 'message_id';
    protected $fillable = [
        'user_id',
        'message',
        'sendbyuser',
    ];

    public static function check_user_meesage_limit($user){
    	// if($user->user_membership === 1){
    		// $today = Carbon::now()->format('Y-m-d').'%';
    		 $users = User_messages::where('user_id',$user->id)->first();
    		 if($users === null){
                return false;
    		 }else{
                return true;
    		 }
    	// }
    	return true;
    	
    }
}
