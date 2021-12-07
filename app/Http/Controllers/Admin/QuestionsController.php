<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Questions;
use Illuminate\Http\File;

class QuestionsController extends Controller
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
        return view('admin.questions.index');
    }
    public function create()
    {
        return view('admin.questions.add_question');
    }
    public function store(Request $request)
    {
        
        $json_data = array();
       $request->validate([
            'question' => 'required:questions'
        ]);
       
        $input = $request->all();
        if ($request->file('image') !=null ){

        $file_extension = explode(".",$request->file('image')->getClientOriginalName());
        $file_extension = end($file_extension);
        $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;
        $image = $request->file('image')->storeAs('questions',$custom_file_name);
        $input['image'] = $custom_file_name;
        }
        if ($request->file('audio') !=null){
            $file_extension = explode(".",$request->file('audio')->getClientOriginalName());
            $file_extension = end($file_extension);
            $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;
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
      

        Questions::create($input);
        \Session::flash('flash_message','successfully saved.');
        
       
        return redirect()->route('questions.index');

   }
   public function edit($id)
    {
        $question = Questions::findOrFail($id);
        return view('admin.questions.edit', compact('question'));
        
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $question = Questions::findOrFail($id);

        $request->validate([
            'question' => 'required'
        ]);
        $input = $request->all();
        if ($request->file('image')!=null){

        $file_extension = explode(".",$request->file('image')->getClientOriginalName());
        $file_extension = end($file_extension);
        $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;
        $image = $request->file('image')->storeAs('questions',$custom_file_name);
        $input['image'] = $custom_file_name;
        }
        if ($request->file('audio')!=null){
            $file_extension = explode(".",$request->file('audio')->getClientOriginalName());
            $file_extension = end($file_extension);
            $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;
            $audio = $request->file('audio')->storeAs('questions',$custom_file_name);
            $input['audio'] = $custom_file_name;
        }
         if(!empty($request->question_answer)){
            foreach ($request->question_answer as $key => $value) {
               $json_data[$key]['question_answer'] = $value;
               $json_data[$key]['order_number'] = $request->order_number[$key];
               $json_data[$key]['question_corren_radio'] = $request->question_corren_radio[$key];
               
            }
        }
        
        $question_answer = json_decode($question['question_answer'],true);
        $input['question_answer'] = json_encode($json_data);
        
       
        $question->fill($input)->save();
        \Session::flash('flash_message','successfully updated.');
        return redirect()->route('questions.index');
    }


    public function destroy($id)
    {
        $question = Questions::findOrFail($id);
        $question->delete();
        \Session::flash('flash_message','successfully deleted.');
        return redirect()->route('questions.index');
    }
   
}