<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UnitsController;
use App\Http\Controllers\Admin\LevelsController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\LessonQuestionsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\AnswersController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\LessionPlusController;
use Illuminate\Support\Facades\URL;
if (App::environment('production', 'local'))
{ 
    URL::forceScheme('https');
  
}
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/api', [App\Http\Controllers\MainController::class, 'api'])->name('api');
Route::resource('users', UserController::class);
Route::delete('/user/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy']);
Route::get('user_transaction/{id}', [App\Http\Controllers\Admin\UserController::class, 'user_transaction'])->name('user_transaction');
Route::get('login_status/{id}', [App\Http\Controllers\Admin\UserController::class, 'login_status'])->name('login_status');
Route::get('question_status/{id}', [App\Http\Controllers\Admin\UserController::class, 'question_status'])->name('question_status');
Route::get('lesson_status/{id}', [App\Http\Controllers\Admin\UserController::class, 'lesson_status'])->name('lesson_status');
Route::get('revision_status/{id}', [App\Http\Controllers\Admin\UserController::class, 'revision_status'])->name('revision_status');
Route::get('remind_status/{id}', [App\Http\Controllers\Admin\UserController::class, 'remind_status'])->name('remind_status');

Route::resource('levels', LevelsController::class);
Route::delete('/levels/delete/{id}', [App\Http\Controllers\Admin\LevelsController::class, 'destroy']);
Route::resource('units', UnitsController::class);
Route::delete('/units/delete/{id}', [App\Http\Controllers\Admin\UnitsController::class, 'destroy']);
Route::resource('questions', QuestionsController::class);
Route::delete('/questions/delete/{id}', [App\Http\Controllers\Admin\QuestionsController::class, 'destroy']);

Route::resource('lesson_questions', LessonQuestionsController::class);
Route::delete('/lesson_questions/delete/{id}', [App\Http\Controllers\Admin\LessonQuestionsController::class, 'destroy']);

Route::resource('answers', AnswersController::class);
Route::delete('/answers/delete/{id}', [App\Http\Controllers\Admin\AnswersController::class, 'destroy']);
Route::get('/answers/add/{id}', [App\Http\Controllers\Admin\AnswersController::class, 'add']);

Route::resource('messages', MessagesController::class);
Route::patch('messages/add/', [App\Http\Controllers\Admin\MessagesController::class, 'add']);

Route::resource('basic_lessions', LessonController::class);
Route::delete('/lessions/delete/{id}', [App\Http\Controllers\Admin\LessonController::class, 'destroy']);

Route::resource('basic_lession_plus', LessionPlusController::class);
Route::delete('/lession_plus/delete/{id}', [App\Http\Controllers\Admin\LessionPlusController::class, 'destroy']);
Route::post('get_unit/{id}', [App\Http\Controllers\Admin\LessionPlusController::class, 'get_unit'])->name('get_unit');

