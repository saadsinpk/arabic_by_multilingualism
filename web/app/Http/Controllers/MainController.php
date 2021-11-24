<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function api(Request $request)
    {

        if(isset($_GET['data'])) {
			if($_GET['data'] == 'user') {
				$users = array();
				$users = DB::select("SELECT * FROM users");
				
				echo json_encode($users);
			}
			if($_GET['data'] == 'user_transaction') {
				if(isset($_GET['id'])) {
					$users = array();
					$users = DB::select(DB::raw("SELECT * FROM user_transactions LEFT join users ON users.id = user_transactions.user_id WHERE user_id = '".$_GET['id']."'"));
					
					echo json_encode($users);
					exit();
				}
				echo json_encode(array());
			}
			if($_GET['data'] == 'messages') {
				$users = array();
				$users = DB::select(DB::raw("SELECT *, MAX(message) AS message FROM user_messages LEFT join users ON users.id = user_messages.user_id GROUP BY user_messages.user_id"));
				
				echo json_encode($users);
			}
			if($_GET['data'] == 'level') {
				$users = array();
				$users = DB::select("SELECT * FROM levels");
				
				echo json_encode($users);
			}
			if($_GET['data'] == 'unit') {
				$users = array();
				$users = DB::select("SELECT * FROM units LEFT JOIN levels ON level_id = unit_level");
				
				echo json_encode($users);
			}
			if($_GET['data'] == 'questions') {
				$users = array();
				$users = DB::select("SELECT * FROM questions WHERE `question_lesson` IS NULL");
				
				echo json_encode($users);
			}
			if($_GET['data'] == 'lession_questions') {
				$users = array();
				$users = DB::select("SELECT * FROM `questions` WHERE `question_lesson` IS NOT NULL");
				
				echo json_encode($users);
			}
			if($_GET['data'] == 'answers') {
				if(isset($_GET['id'])) {
					$users = array();
					$users = DB::select("SELECT * FROM answers WHERE answer_question = '".$_GET['id']."'");
					
					echo json_encode($users);
				}
			}
			if($_GET['data'] == 'word') {
				$users = array();
				$users = DB::select("SELECT * FROM words");
				echo json_encode($users);
			}
			if($_GET['data'] == 'basic_lesson') {
				$users = array();
				$users = DB::select("SELECT lesson_id, lesson_title, level_name, unit_name, level_id, lesson_level, unit_id, lesson_unit, is_basic FROM lession_pluses LEFT JOIN levels ON levels.level_id = lession_pluses.lesson_level LEFT JOIN units on units.unit_id = lession_pluses.lesson_unit where is_basic=1");
				// $users = DB::select("SELECT * FROM lession_pluses where is_basic=1");
				echo json_encode($users);
			}
			if($_GET['data'] == 'basic_plus_lesson') {
				$users = array();
				$users = DB::select("SELECT lesson_id, lesson_title, level_name, unit_name, level_id, lesson_level, unit_id, lesson_unit, is_basic FROM lession_pluses LEFT JOIN levels ON levels.level_id = lession_pluses.lesson_level LEFT JOIN units on units.unit_id = lession_pluses.lesson_unit where lession_pluses.is_basic != 1");
				echo json_encode($users);
			}
			if($_GET['data'] == 'login_status') {
				$users = array();
				$users = DB::select("SELECT * FROM user_login_statuses LEFT JOIN users ON users.id = user_login_statuses.user_id");
				echo json_encode($users);
			}
			if($_GET['data'] == 'lesson_status') {
				$users = array();
				$users = DB::select("SELECT * FROM lession_pluses LEFT JOIN users ON users.id = user_lesson_statuses.user_id LEFT JOIN lession_pluses ON lession_pluses.lesson_id = user_lesson_statuses.lesson_id");
				echo json_encode($users);
				// user_transaction
			}
			if($_GET['data'] == 'question_status') {
				$users = array();
				$users = DB::select("SELECT * FROM user_question_statuses LEFT JOIN users ON users.id = 	user_question_statuses.user_id LEFT JOIN questions ON questions.questionid = 	user_question_statuses.ques_id LEFT JOIN answers ON answers.answer_id = 	user_question_statuses.select_ans AND answers.answer_question = 	user_question_statuses.ques_id");
				echo json_encode($users);
			}
			if($_GET['data'] == 'remind_status') {
				$users = array();
				$users = DB::select("SELECT * FROM user_remind_statuses LEFT JOIN users ON users.id = user_remind_statuses.user_id LEFT JOIN word ON word.word_id = user_remind_statuses.word_id");
				echo json_encode($users);
			}
			if($_GET['data'] == 'revision_status') {
				$users = array();
				$users = DB::select("SELECT * FROM user_revision_statuses LEFT JOIN users ON users.id = user_revision_statuses.user_id LEFT JOIN word ON word.word_id = user_revision_statuses.word_id");
				echo json_encode($users);
			}
		}
    }
}