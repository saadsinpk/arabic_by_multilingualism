<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AllStatusController;
use App\Http\Controllers\Api\MainController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/doAppleLogin/{id}', [AuthController::class, 'doAppleLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify_otp', [AuthController::class, 'verify_otp']);
Route::post('/resend_otp', [AuthController::class, 'resend_otp']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot_password', [AuthController::class,'forgot_password']);
Route::post('change_password', [AuthController::class,'change_password']);
Route::post('/facebook_login/{id}', [AuthController::class, 'getFacebookLogin']);
Route::get('/facebook_delete', [AuthController::class, 'getFacebookDelete']);
Route::get('/check_email/{id}', [AuthController::class, 'getEmailUseOrNo']);
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
	
   
    

Route::group(['middleware' => ['jwt.verify']], function() {
      Route::get('/user-profile', [AuthController::class, 'userProfile']); 
      Route::post('/logout', [AuthController::class, 'logout']);
      Route::get('/user-check-subscription', [AuthController::class, 'userCheckSubscription']); 
      Route::get('/user-check-level', [AuthController::class, 'userCheckLevel']); 
      
      Route::post('/refresh', [AuthController::class, 'refresh']);
      Route::get('/user_lesson_status', [AllStatusController::class, 'getLessionStatus']);
      Route::get('/user_login_status', [AllStatusController::class, 'getLoginStatus']);
      Route::get('/user_messages', [AllStatusController::class, 'getMessageStatus']);
      Route::get('/user_question_status', [AllStatusController::class, 'getQuestionStatus']);
      Route::get('/user_remind_status', [AllStatusController::class, 'getRemindStatus']);
      Route::get('/user_revision_status', [AllStatusController::class, 'getRevisionStatus']);
      Route::get('/user_transaction', [AllStatusController::class, 'getTransaction']);

      Route::post('/add_user_lesson_status', [AllStatusController::class, 'addLessionStatus']);
      Route::post('/add_user_login_status', [AllStatusController::class, 'addLoginStatus']);
      Route::post('/add_user_messages', [AllStatusController::class, 'addUserMessage']);
      Route::post('/add_user_question_status', [AllStatusController::class, 'addQuestionStatus']);
      Route::post('/add_user_remind_status', [AllStatusController::class, 'addRemindStatus']);
      Route::post('/add_user_revision_status', [AllStatusController::class, 'addRevisionStatus']);
      Route::post('/remove_user_remind_revision_status', [AllStatusController::class, 'removeRemindRevisionStatus']);
      Route::post('/add_user_transactions', [AllStatusController::class, 'addtransactions']);
      Route::post('/user_transactions_cancel', [AllStatusController::class, 'canceltransactions']);

      Route::get('/get_question/{id}', [MainController::class, 'getQuestions']);
      Route::get('/get_question_level/{id}', [MainController::class, 'getQuestionsLevel']);
      Route::get('/get_level/{id}', [MainController::class, 'getLevels']);
      Route::get('/get_unit/{id}', [MainController::class, 'getUnits']);
      Route::get('/get_lesson_by_level/{id}', [MainController::class, 'getLessonByLevel']);
      Route::post('/check_remind_revision_word', [MainController::class, 'check_remind_revision_word']);

      Route::get('/check_unit/{id}', [MainController::class, 'checkUnit']);
      Route::get('/get_lession_plus/{id}', [MainController::class, 'getLession_pluses']);
      Route::get('/get_single_lession_plus/{id}', [MainController::class, 'getLession_single_pluses']);
      Route::get('/get_single_lession_plus_test/{id}', [MainController::class, 'getLession_single_pluses_test']);
      Route::get('/get_answer/{id}', [MainController::class, 'getAnswer']);
      Route::post('/update_user', [MainController::class, 'updateUser']);
      Route::post('/update_user_points', [MainController::class, 'UserPoints']);

      Route::get('/check_ban', [MainController::class, 'check_ban']);
      Route::get('/get_questions', [MainController::class, 'getAllQuestions']);
      Route::get('/get_questions_level/{id}', [MainController::class, 'getAllQuestionsLevel']);
      Route::get('/get_levels', [MainController::class, 'getAllLevels']);
      Route::get('/get_units', [MainController::class, 'getAllUnits']);
      Route::get('/get_lesson_plus', [MainController::class, 'getAllLession_pluses']);
      Route::get('/get_answers', [MainController::class, 'getAllAnswer']);
      Route::get('/statitics', [MainController::class, 'statitics']);

      Route::get('/get_questions_startup', [MainController::class, 'getQuestionStartup']);
      Route::post('/post_questions_startup', [MainController::class, 'postQuestionStartup']);
});