<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\LessonQuestions;
use Illuminate\Http\File;
use App\Models\LessionPlus;

class LessonQuestionsController extends Controller
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
    public function index()
    {
        return view('admin.lesson_questions.index');
    }
    public function create()
    {
        $lessions = LessionPlus::get();
        return view('admin.lesson_questions.add_question',compact('lessions'));
    }
    public function store(request $request )
    {
        // dd($request->all());
        $json_data = array();
       $request->validate([
            'question' => 'required:questions',
            'question_tagline' => 'required|max:255',
        ]);
       
        $input = $request->all();
        if ($request->file('image') !=null ){

        $custom_file_name = time().'-'.$request->file('image')->getClientOriginalName();
        $image = $request->file('image')->storeAs('questions',$custom_file_name);
        $input['image'] = $custom_file_name;
        }
        if ($request->file('audio') !=null){
             $custom_file_name = time().'-'.$request->file('audio')->getClientOriginalName();
            $audio = $request->file('audio')->storeAs('questions',$custom_file_name);
            $input['audio'] = $custom_file_name;
        }
        if(isset($request->question_answer)){
            foreach ($request->question_answer as $key => $value) {
                if($value !=null){
                    $json_data[$key]['question_answer'] = $value;
                    $json_data[$key]['order_number'] = $request->order_number[$key];
                }
               
            }
        }

        if(isset($request->question_corren_radio)){
            foreach ($request->question_corren_radio as $key => $value) {
                 if($value ==null ){
                    $json_data[$key]['question_corren_radio'] = 1;
                   }else{
                    $json_data[$key]['question_corren_radio'] = 0;
                   }
            }
        }
        $input['question_answer'] = json_encode($json_data);
      

        LessonQuestions::create($input);
        \Session::flash('flash_message','successfully saved.');
        // exit();
       
        return redirect()->route('lesson_questions.index');

   }
   public function edit($id)
    {
        $question = LessonQuestions::findOrFail($id);
        $lessions = LessionPlus::get();
        return view('admin.lesson_questions.edit', compact('question','lessions'));
        
    }


    public function update(Request $request, $id)
    {

        $question = LessonQuestions::findOrFail($id);

        $request->validate([
            'question' => 'required',
            'question_tagline' => 'required|max:255',
            'question_marks' => 'required|numeric',
        ]);
        $input = $request->all();
        if ($request->file('image')!=null){

        $custom_file_name = time().'-'.$request->file('image')->getClientOriginalName();
        $image = $request->file('image')->storeAs('questions',$custom_file_name);
        $input['image'] = $custom_file_name;
        }
        if ($request->file('audio')!=null){
             $custom_file_name = time().'-'.$request->file('audio')->getClientOriginalName();
            $audio = $request->file('audio')->storeAs('questions',$custom_file_name);
            $input['audio'] = $custom_file_name;
        }
         if(!empty($request->question_answer)){
            foreach ($request->question_answer as $key => $value) {
               $json_data[$key]['question_answer'] = $value;
               $json_data[$key]['order_number'] = $request->order_number[$key];
              
              if(isset($request->question_corren_radio[$key])){
                $json_data[$key]['question_corren_radio'] = 1;
               }else{
                $json_data[$key]['question_corren_radio'] = 0;
               }
               
            }
        }
        
        $question_answer = json_decode($question['question_answer'],true);
        $input['question_answer'] = json_encode($json_data);
        
       
        $question->fill($input)->save();
        \Session::flash('flash_message','successfully updated.');
        return redirect()->route('lesson_questions.index');
    }


    public function destroy($id)
    {
        $question = LessonQuestions::findOrFail($id);
        $question->delete();
        \Session::flash('flash_message','successfully deleted.');
        return redirect()->route('lesson_questions.index');
    }
   
}