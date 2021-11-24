<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\Units;
use App\Models\Levels;
use App\Models\LessionPlus;
use App\Models\Answers;
use App\Models\Words;
use App\Models\APi\User;
use App\Models\UserRemindStatus;
use App\Models\UserRevisionStatus;
use App\Models\User_words;
use App\Models\User_lessons;
use App\Models\User_transaction;
use Validator;
use Carbon\Carbon;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use DB;

class MainController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.verify');

    }
    /* get question by question id*/
    public function getQuestions(Request $request, $id) {
      $user_id = JWTAuth::user()->id;
      if (User::where('id', $user_id)->exists()) {
        $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        $this->check_user($user_data);

        if (Questions::where('questionid', $id)->exists()) {
            $status = Questions::where('questionid', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($status, 200);
          } else {
            return response()->json([
              "message" => "Question not found"
            ], 404);
          }
      }
  } 
  /* get question by question id*/
  public function getQuestionsLevel(Request $request, $id) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
       if(Questions::where('question_lesson', $id)->exists()){
            $status = Questions::where('question_lesson', $id)->get()->toJson(JSON_PRETTY_PRINT);
            $status = json_decode($status);
            foreach ($status as $key => $value) {
              $status[$key]->question_answer = json_decode($value->question_answer);
              if(!empty($value->image)) {
                $status[$key]->image = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($value->image);
              }
              if(!empty($value->audio)) {
                $status[$key]->audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($value->audio);
              }
            }
            return response($status, 200);
          } else {
            return response()->json([
              "message" => "Question not found"
            ], 404);
          }
        }
  }
/* get level by level id*/
  public function getLevels(Request $request, $id) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
      if (Levels::where('level_id', $id)->exists()) {
          $status = Levels::where('level_id', $id)->get()->toJson(JSON_PRETTY_PRINT);
          return response($status, 200);
        } else {
          return response()->json([
            "message" => "Level not found"
          ], 404);
        }
      }
  }
  public function getUnits(Request $request, $id) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
      if (Units::where('unit_level', $id)->exists()) {
          $status = Units::where('unit_level', $id)->orderBy('unit_sort', 'ASC')->get()->toJson(JSON_PRETTY_PRINT);
          return response($status, 200);
        } else {
          return response()->json([
            "message" => "Unit not found"
          ], 404);
        }
      }
  }
  /* get Lession by Lession id*/
  public function getLession_pluses(Request $request, $id) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
      if (LessionPlus::where('lesson_unit', $id)->exists()) {
          $status = LessionPlus::where('lesson_unit', $id)->orderBy('lesson_sort', 'ASC')->get()->toJson(JSON_PRETTY_PRINT);
          $status = json_decode($status);
          foreach ($status as $key => $value) {
            $content = $value->lesson_content;
            if (preg_match_all('/{{([^}]*)}}/', $content, $matches)) {
            }
            $tags_decode = json_decode($value->lesson_tags);
            $tags_array = array();
            if(isset($value->lesson_tags) AND !empty($value->lesson_tags)) {
              foreach ($tags_decode as $tag_key => $tag_value) {
                $tags_array[$tag_value->word_arabic] = $tag_value;
              }
            }

            foreach ($matches[1] as $match_key => $match_value) {
              if(isset($tags_array[$match_value])) {
                $audio = '';
                if(isset($tags_array[$match_value]->word_audio)) {
                  if(!empty($tags_array[$match_value]->word_audio)) {
                    $audio = $tags_array[$match_value]->word_audio;
                  }
                }
                // $content = str_replace("{{".$match_value."}}","{{".$tags_array[$match_value]->word_arabic."|".$tags_array[$match_value]->word_english."|".$tags_array[$match_value]->word_meaning."|audio:".$audio."}}",$content);
              }
            }

            $content_2 = $value->lesson_content_2;
            if (preg_match_all('/{{([^}]*)}}/', $content_2, $matches)) {
            }

            foreach ($matches[1] as $match_key => $match_value) {
              if(isset($tags_array[$match_value])) {
                $audio = '';
                if(isset($tags_array[$match_value]->word_audio)) {
                  if(!empty($tags_array[$match_value]->word_audio)) {
                    $audio = $tags_array[$match_value]->word_audio;
                  }
                }
              }
            }

            $status[$key]->lesson_content = '';
            $status[$key]->lesson_content_2 = '';
            $status[$key]->lesson_tags = json_decode($value->lesson_tags);
            $status[$key]->lesson_json_data = json_decode($value->lesson_json_data);
            if(!empty($value->lesson_audio)) {
              $status[$key]->lesson_audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($value->lesson_audio);
            }
          }
          $status = json_encode($status,JSON_UNESCAPED_UNICODE);
          return response($status, 200);
        } else {
          return response()->json([
            "message" => "lesson not found"
          ], 404);
        }
      }
  }
  public function getLession_single_pluses(Request $request, $id) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
      if (LessionPlus::where('lesson_id', $id)->exists()) {
          $status = LessionPlus::where('lesson_id', $id)->get()->toJson(JSON_PRETTY_PRINT);
          $status = json_decode($status);
          foreach ($status as $key => $value) {
            $content = $value->lesson_content;
            if (preg_match_all('/{{([^}]*)}}/', $content, $matches)) {
            }
            $tags_decode = json_decode($value->lesson_tags);
            $tags_array = array();
            if(isset($value->lesson_tags) AND !empty($value->lesson_tags)) {
              foreach ($tags_decode as $tag_key => $tag_value) {
                $tags_array[$tag_value->word_arabic] = $tag_value;
              }
            }
            foreach ($matches[0] as $match_key => $match_value) {
              $without_html_match_value = strip_tags($match_value);
              $without_html_bracket_match_value = str_replace(array('{{', '}}'),array('',''),$without_html_match_value);
              $whbmv = $without_html_bracket_match_value;
              if(isset($tags_array[$whbmv])) {
                $audio = '';
                if(isset($tags_array[$whbmv]->word_audio)) {
                  $audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/lesson_audio/'.urlencode($tags_array[$whbmv]->word_audio);
                }
                $content = str_replace($match_value,"<a href='".$whbmv."' style='color:#4472C4;mso-themecolor:accent1;mso-style-textoutline-type:none; mso-style-textoutline-outlinestyle-dpiwidth:0pt;mso-style-textoutline-outlinestyle-linecap: flat;mso-style-textoutline-outlinestyle-join:round;mso-style-textoutline-outlinestyle-pctmiterlimit: 0%;mso-style-textoutline-outlinestyle-dash:solid;mso-style-textoutline-outlinestyle-align: center;mso-style-textoutline-outlinestyle-compound:simple;mso-effects-shadow-color: #6E747A;mso-effects-shadow-alpha:43.0%;mso-effects-shadow-dpiradius:3.0pt; mso-effects-shadow-dpidistance:2.0pt;mso-effects-shadow-angledirection:5400000; mso-effects-shadow-align:center;mso-effects-shadow-pctsx:100.0%;mso-effects-shadow-pctsy: 100.0%;mso-effects-shadow-anglekx:0;mso-effects-shadow-angleky:0'>".$whbmv."</a>",$content);
              }
            }
            $status[$key]->lesson_content = $content;
            $status[$key]->lesson_content_2 = $status[$key]->lesson_content_2;

            if(!empty($value->lesson_json_data)) {
              $status[$key]->lesson_json_data = json_decode($value->lesson_json_data);
              foreach ($status[$key]->lesson_json_data as $json_lesson_key => $json_lesson_value) {
                if(!empty($json_lesson_value->lesson_audio)) {
                  $status[$key]->lesson_json_data[$json_lesson_key]->lesson_audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($json_lesson_value->lesson_audio);
                }
              }
            }
            if(!empty($value->lesson_tags)) {
              $status[$key]->lesson_tags = json_decode($value->lesson_tags);
              foreach ($status[$key]->lesson_tags as $json_lesson_key => $json_lesson_value) {
                if(!empty($json_lesson_value->word_audio)) {
                  $status[$key]->lesson_tags[$json_lesson_key]->word_audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/lesson_audio/'.urlencode($json_lesson_value->word_audio);
                }
              }
            }

            if(!empty($value->lesson_audio)) {
              $status[$key]->lesson_audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/lesson_audio/'.urlencode($value->lesson_audio);
            }
            
            if(!empty($value->bulk_audio)) {
              $status[$key]->bulk_audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/lesson_audio/'.urlencode($value->bulk_audio);
            }

          }
          $status = json_encode($status,JSON_UNESCAPED_UNICODE);
          return response($status, 200);
        } else {
          return response()->json([
            "message" => "lesson not found"
          ], 404);
        }
      }
  }
  /* get Answer by answer id*/
  public function getAnswer(Request $request, $id) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
      if (Answers::where('answer_id', $id)->exists()) {
          $status = Answers::where('answer_id', $id)->get()->toJson(JSON_PRETTY_PRINT);
          return response($status, 200);
        } else {
          return response()->json([
            "message" => "Answer not found"
          ], 404);
        }
      }
  }
  /* get user by user id*/
  public function getUser(Request $request) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
        $status = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($status, 200);
      } else {
        return response()->json([
          "message" => "User not found"
        ], 404);
      }
  }

  /* update user by user id*/
  public function updateUser(Request $request) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);

        $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,id,'.$user_id,
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }
             $user = User::find($user_id);
               $user->name = $request->get('first_name').$request->get('last_name');
                $user->username = $request->get('email');
                $user->email = $request->get('email');
                $user->firstname = $request->get('first_name');
                $user->lastname = $request->get('last_name');  
                $user->usergroup = 2;
                if($request->get('password') != '------') {
                  $user->password = Hash::make($request->get('password'));
                }
              $user->save();
              return response(["message" => "Successfully Updated"], 200);
      } else {
        return response()->json([
          "message" => "User not found"
        ], 404);
      }
  }

  public function getAllQuestions(Request $request) {
      $user_id = JWTAuth::user()->id;
      if (User::where('id', $user_id)->exists()) {
        $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
        $this->check_user($user_data);
        $status = Questions::where('question_lesson','=',NULL)->get()->toJson(JSON_PRETTY_PRINT);
        // $status = Questions::where('question_lesson','=','null')->get()->toJson(JSON_PRETTY_PRINT);
        $status = json_decode($status);
        foreach ($status as $key => $value) {
          $status[$key]->question_answer = json_decode($value->question_answer);
          if(isset($value->image)) {
            if(!empty($value->image)) {
              $status[$key]->image = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($value->image);
            }
          }
          if(isset($value->audio)) {
            if(!empty($value->audio)) {
              $status[$key]->audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($value->audio);
            }
          }
        }
        return response($status, 200);      
      }
  }

  public function getAllQuestionsLevel(Request $request, $id) {
        $user_id = JWTAuth::user()->id;
        if (User::where('id', $user_id)->exists()) {
          $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
          $this->check_user($user_data);
          $status = DB::select("SELECT * FROM `lession_pluses` LEFT JOIN questions ON questions.question_lesson = lession_pluses.lesson_id WHERE `lesson_level` = ".$id);

          foreach ($status as $key => $value) {
            $status[$key]->question_answer = json_decode($value->question_answer);
            if(isset($value->image)) {
              if(!empty($value->image)) {
                $status[$key]->image = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($value->image);
              }
            }
            if(isset($value->audio)) {
              if(!empty($value->audio)) {
                $status[$key]->audio = 'https://arabiclanguageapp.co.uk/admin/storage/app/questions/'.urlencode($value->audio);
              }
            }
          }
          return response($status, 200);
        }
  }
  public function check_ban(Request $request) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $user_data = json_decode($user_data);
      if($user_data[0]->user_ban == 2) {
        $error = json_encode(array('status' => 'error', 'message' => 'user_is_ban' ));
        print_r($error);
        exit();
      }
    }
    $success = json_encode(array('status' => 'success', 'message' => 'user_is_not_ban' ));
    print_r($success);
    exit();
  }

  public function check_user($user_data) {
    $user_data = json_decode($user_data);
    $data_create = $user_data[0]->created_at;

    if( strtotime($data_create) > strtotime('-7 day') ) {
    } else {
      if($user_data[0]->user_membership == '1') {
        $error = json_encode(array('status' => 'error', 'message' => 'free_user_expire' ));
        print_r($error);
        exit();
      }
    }
  }
/* get level by level*/
  public function getAllLevels(Request $request) {
        $user_id = JWTAuth::user()->id;
        if (User::where('id', $user_id)->exists()) {
          $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
          $this->check_user($user_data);
          $status = Levels::orderBy('level_sort', 'ASC')->get()->toJson(JSON_PRETTY_PRINT);
          return response($status, 200);
        }
  }
  public function getAllUnits(Request $request) {
        $user_id = JWTAuth::user()->id;
        if (User::where('id', $user_id)->exists()) {
          $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
          $this->check_user($user_data);
          $status = Units::orderBy('unit_sort', 'ASC')->get()->toJson(JSON_PRETTY_PRINT);
          return response($status, 200);
        }
  }
  /* get Lession by Lession*/
  public function getAllLession_pluses(Request $request) {
        $user_id = JWTAuth::user()->id;
        if (User::where('id', $user_id)->exists()) {
          $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
          $this->check_user($user_data);
          $status = LessionPlus::orderBy('lesson_sort', 'ASC')->get()->toJson(JSON_PRETTY_PRINT);
          return response($status, 200);
        }
  }
  /* get Answer by answer*/
  public function getAllAnswer(Request $request) {
        $user_id = JWTAuth::user()->id;
        if (User::where('id', $user_id)->exists()) {
          $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
          $this->check_user($user_data);
          $status = Answers::get()->toJson(JSON_PRETTY_PRINT);
          return response($status, 200);
        }
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function UserPoints(Request $request)
    {
        $user_id = JWTAuth::user()->id;
        if (User::where('id', $user_id)->exists()) {
          $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
          $this->check_user($user_data);

        $validator='';
        $user = JWTAuth::user();
        if(isset($request->invisted_min)){
          
          $validator = Validator::make($request->all(), [
            'invisted_min' => 'numeric|between:0,99.99',
          ]);
          if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
          }
          if($request->point_type == 'add'){
            $user->invisted_min = $user->invisted_min+$request->invisted_min;
          }else{
            $user->invisted_min = $user->invisted_min-$request->invisted_min;
          }
        }
        if(isset($request->lesson_complete)){
          // dd($request->all());
          $validator = Validator::make($request->all(), [
            'lesson_complete' => 'numeric',
          ]);
          if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
          }

          if($request->point_type == 'add'){
            $user->lesson_complete = $user->lesson_complete+$request->lesson_complete;
          }else{
            $user->lesson_complete = $user->lesson_complete-$request->lesson_complete;
          }
        }
        if(isset($request->words_learned)){
          $validator = Validator::make($request->all(), [
            'words_learned' => 'numeric',
          ]);
          if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
          }
          if($request->point_type == 'add'){
            $user->words_learned = $user->words_learned+$request->words_learned;
          }else{
            $user->words_learned = $user->words_learned-$request->words_learned;
          }
        }

        if($request->point_type == 'add'){
          $user->user_points = $user->user_points+$request->user_points;
        }else if($request->point_type == 'minus'){
          $user->user_points = $user->user_points-$request->user_points;
        }
        
        if($user->save()){
          $this->update_user_level($user->user_points);
          return response(["message" => "Successfully Updated"], 200);
        }else {
          return response()->json([
            "message" => "points not updated"
          ], 404);
        }
      }
    }


    /* get statitics */

    public function statitics(){
      $user = JWTAuth::user();
      $user_id = $user->id;
      $invisted_min = $user->invisted_min;
      $lesson = User_lessons::where('user_id',$user_id)->get();
      $lesson_count = $lesson->count();
      $words= User_words::where('user_id',$user_id)->count();
      $lessons= LessionPlus::get();
      $total_lessons = $lessons->count();
      $total_words = $lessons->sum('total_words');
      return response(["lesson_count" => $lesson_count,'words_count'=>$words,'minutes_invisted'=>$invisted_min,'total_lessons'=>$total_lessons,'total_words'=>$total_words], 200);
    }

    public function update_user_level($user_points){
      // dd($user_points);
        $user_id = JWTAuth::user()->id;
        if (User::where('id', $user_id)->exists()) {
          $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
          $this->check_user($user_data);
         $level = Levels::select('*')->where('level_min_marks', '<=', $user_points)->where('level_max_marks', '>=', $user_points)->orWhereNull('level_max_marks')->orderby('level_id','desc')->first();
         $user_id = JWTAuth::user()->id;
         
         if($level != null){
          User::where('id', $user_id)->update(array('user_level' => $level->level_id));
         }
        return true;
      }
  }

  public function checkUnit(Request $request, $id) {
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
    	$status = DB::table('levels')->join('units', 'levels.level_id', '=', 'units.unit_level')
              ->where('levels.level_id',$id)->count();
      if($status > 0){
      	return response(["unit" => true], 200);
      }
      return response(["unit" => false], 200);
    }
  }
  public function getLessonByLevel(Request $request, $id){
    $user_id = JWTAuth::user()->id;
    if (User::where('id', $user_id)->exists()) {
      $user_data = User::where('id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);
      $this->check_user($user_data);
      $lesson_level = LessionPlus::where('lesson_level', $id)->orderBy('lesson_sort', 'ASC')->get()->toJson(JSON_PRETTY_PRINT);
      return response($lesson_level, 200);
    }
  }

  public function check_remind_revision_word(Request $request) {
    $user_id = JWTAuth::user()->id;
    $status = array();

    $status['remind'] = false;
    $status['revision'] = false;
    if(isset($request->lesson_id)) {
      $lesson_id = $request->lesson_id;
      if(isset($request->remind)) {
        $status_query = UserRemindStatus::where([['user_id', $user_id],['word_json', $request->remind]])->get()->count();
        if($status_query > 0) {
          $status['remind'] = true;
        }
      }
      if(isset($request->revision)) {
        $status_query = UserRevisionStatus::where([['user_id', $user_id],['word_json', $request->revision]])->get()->count();
        if($status_query > 0) {
          $status['revision'] = true;
        }
      }
    }
    return response($status, 200);
  }
}

// getLessonByLevel
// getLession_pluses
// getAllLession_pluses
// getAllUnits
// getLevels
// getAllLevels
