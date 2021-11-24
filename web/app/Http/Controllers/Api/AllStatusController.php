<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLessonStatus;
use App\Models\User_messages;
use App\Models\UserLoginStatus;
use App\Models\UserQuestionStatus;
use App\Models\UserRemindStatus;
use App\Models\UserRevisionStatus;
use App\Models\User_transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Api\User;
use Validator;
use Carbon\Carbon;
use JWTAuth;

class AllStatusController extends Controller
{

	 public function __construct() {
        $this->middleware('jwt.verify');

    }
   public function getLessionStatus() {
    $user_id = JWTAuth::user()->id;
    if (UserLessonStatus::where('user_id', $user_id)->exists()) {
        $status = UserLessonStatus::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "Lession status not found"
        ], 404);
      }
  }

  public function getLoginStatus() {
    $user_id = JWTAuth::user()->id;
    if (UserLoginStatus::where('user_id', $user_id)->exists()) {
        $status = UserLoginStatus::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "Login status not found"
        ], 404);
      }
  }

   public function getMessageStatus() {
    $user_id = JWTAuth::user()->id;
    if (User_messages::where('user_id', $user_id)->exists()) {
        $status = User_messages::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "Messages not found"
        ], 404);
      }
  } 

  public function getQuestionStatus() {
    $user_id = JWTAuth::user()->id;
    if (UserQuestionStatus::where('user_id', $user_id)->exists()) {
        $status = UserQuestionStatus::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "Question status not found"
        ], 404);
      }
  }
  public function getRemindStatus() {
    $user_id = JWTAuth::user()->id;
    if (UserRemindStatus::where('user_id', $user_id)->exists()) {
        $status = UserRemindStatus::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "Remind status not found"
        ], 404);
      }
  }

  public function getRevisionStatus() {
    $user_id = JWTAuth::user()->id;
    if (UserRevisionStatus::where('user_id', $user_id)->exists()) {
        $status = UserRevisionStatus::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "Revision status not found"
        ], 404);
      }
  }
  public function getTransaction() {
    $user_id = JWTAuth::user()->id;
    if (User_transaction::where('user_id', $user_id)->exists()) {
        $status = User_transaction::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "Transactions not found"
        ], 404);
      }
  }

  public function addLessionStatus(Request $request){
    $user_id = JWTAuth::user()->id;
  	$validator = Validator::make($request->all(), [
                'lesson_id' => 'required|numeric',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $lession = UserLessonStatus::create([
                'lesson_id' => $request->get('lesson_id'),
                'user_id' => $user_id,
                'lesson_status_time' => now(),
            ]);
            if($lession){
            	return response()->json([
			          "message" => "Added Successfully."
			        ], 200);
            }else{
            	return response()->json([
		          "message" => "Lession not added"
		        ], 404);
            }
  }

    public function addLoginStatus(Request $request){
      $user_id = JWTAuth::user()->id;
      $lession = UserLoginStatus::create([
          'user_id' => $user_id,
      ]);
      if($lession){
      	return response()->json([
          "message" => "Added Successfully."
        ], 200);
      }else{
      	return response()->json([
        "message" => "Login Status not added"
      ], 404);
      }
  }

    public function addUserMessage(Request $request){
      $user = JWTAuth::user();
      $user_id = $user->id;
  	  $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);
      if($validator->fails()){
          return response()->json($validator->errors()->toJson(), 400);
        }
        $message = User_messages::check_user_meesage_limit($user);
        if($message === false){
          return response()->json([
              "message" => "Sorry. You can't send message first."
            ], 200);
        }
            

            $lession = User_messages::create([
                'user_id' => $user_id,
                'message' => $request->get('message'),
                'sendbyuser' =>$user_id,
            ]);
            if($lession){
            	return response()->json([
			          "message" => "Added Successfully."
			        ], 200);
            }else{
            	return response()->json([
		          "message" => "User Message not added"
		        ], 404);
            }
  }

   public function addQuestionStatus(Request $request){
    $user_id = JWTAuth::user()->id;
  	$validator = Validator::make($request->all(), [
                'ques_id' => 'required',
                'select_ans' => 'required|numeric',
                'corrected_ans' => 'required|numeric',
            ]);
            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $lession = UserQuestionStatus::create([
                'user_id' => $user_id,
                'ques_id' => $request->get('ques_id'),
                'select_ans' => $request->get('select_ans'),
                'corrected_ans' => $request->get('corrected_ans'),
            ]);
            if($lession){
            	return response()->json([
			          "message" => "Added Successfully."
			        ], 200);
            }else{
            	return response()->json([
		          "message" => "Questions Status not added"
		        ], 404);
            }
  }

  public function addRemindStatus(Request $request){
        $user_id = JWTAuth::user()->id;
      	$validator = Validator::make($request->all(), [
                'word_json' => 'required',
            ]);

            if($validator->fails()){
              return response()->json($validator->errors()->toJson(), 400);
            }

            $lession = UserRemindStatus::create([
                'user_id' => $user_id,
                'lesson_id' => $request->lesson_id,
                'word_json' => $request->word_json,
                'english_json' => $request->english_json,
                'arabic_json' => $request->arabic_json,
                'audio_json' => $request->audio_json
            ]);
            if($lession){
            	return response()->json([
			          "message" => "Added Successfully."
			        ], 200);
            }else{
            	return response()->json([
		          "message" => "Remind Status not added"
		        ], 404);
            }
  }
    public function addRevisionStatus(Request $request){
      $user_id = JWTAuth::user()->id;
  	  $validator = Validator::make($request->all(), [
                'word_json' => 'required',
            ]);

            if($validator->fails()){
              return response()->json($validator->errors()->toJson(), 400);
            }

            $lession = UserRevisionStatus::create([
                'user_id' => $user_id,
                'lesson_id' => $request->lesson_id,
                'word_json' => $request->word_json,
                'english_json' => $request->english_json,
                'arabic_json' => $request->arabic_json,
                'audio_json' => $request->audio_json
            ]);
            if($lession){
            	return response()->json([
			          "message" => "Added Successfully."
			        ], 200);
            }else{
            	return response()->json([
		          "message" => "Revision Status not added"
		        ], 404);
            }
  }  
  public function removeRemindRevisionStatus(Request $request){
    $user_id = JWTAuth::user()->id;
    $status = array('success');

    $status['remind'] = false;
    $status['revision'] = false;
    if(isset($request->lesson_id)) {
      $lesson_id = $request->lesson_id;
      if(isset($request->remind)) {
        $status_query = UserRemindStatus::where([['user_id', $user_id],['word_json', $request->remind]])->delete();
        if($status_query > 0) {
          $status['remind'] = true;
        }
      }
      if(isset($request->revision)) {
        $status_query = UserRevisionStatus::where([['user_id', $user_id],['word_json', $request->revision]])->delete();
        if($status_query > 0) {
          $status['revision'] = true;
        }
      }
    }
    return response($status, 200);
  }
  public function addtransactions(Request $request){
    $user_id = JWTAuth::user()->id;
    $validator = Validator::make($request->all(), [
                'gateway_transaction' => 'required',
                'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $transaction = User_transaction::create([
                'gateway_transaction' => $request->get('gateway_transaction'),
                'user_id' => $user_id,
                'amount' => $request->get('amount'),
            ]);
            if($transaction){
              User::where('id', $user_id)->update(array('user_membership' => 2));
              return response()->json([
                "message" => "Added Successfully."
              ], 200);
            }else{
              return response()->json([
              "message" => "Transactions Status not added"
            ], 404);
            }
  }
  public function canceltransactions(Request $request){
    $user_id = JWTAuth::user()->id;
    User::where('id', $user_id)->update(array('user_membership' => 1));
    return response()->json([
      "message" => "Added Successfully."
    ], 200);
  }
}
