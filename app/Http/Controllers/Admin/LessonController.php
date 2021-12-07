<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\LessionPlus;
use Illuminate\Http\File;
use App\Models\Levels;
use App\Models\Units;
use DB;
use Response;
class LessonController extends Controller
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
        return view('admin.basic_lession.index');
    }
    public function create()
    {
        $level = DB::select("SELECT * FROM levels");
        return view('admin.basic_lession.add_lession', compact('level'));
    }
    public function store(request $request )
    {
        $request->validate([
            'lesson_title' => 'required',
        ]);
        $basic_lession = new LessionPlus;
        $basic_lession->lesson_title = $request->lesson_title;;
        $basic_lession->lesson_sub_title = $request->lesson_sub_title;
        $basic_lession->lesson_level = $request->lesson_level;
        $basic_lession->lesson_unit = $request->lesson_unit;
        $basic_lession->lesson_sort = $request->lesson_sort;

        if ($request->file('bulk_audio')!=null){

            $file_extension = explode(".",$request->file('bulk_audio')->getClientOriginalName());
            $file_extension = end($file_extension);
            $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;

            $audio = $request->file('bulk_audio')->storeAs('lesson_audio',$custom_file_name);
            $basic_lession->bulk_audio = $custom_file_name;
        }

        $basic_lession->is_basic = 1;
        if(!empty($request->character)){
            foreach ($request->character as $key => $value) {
               $json_data[$key]['character'] = $value;
               $json_data[$key]['arabic'] = $request->arabic[$key];
               $json_data[$key]['english'] = $request->english[$key];
            }
        }

        if(!empty($request->file('lesson_audio'))){
        foreach($request->file('lesson_audio') as $key => $image)
            {
                $file_extension = explode(".",$image->getClientOriginalName());
                $file_extension = end($file_extension);
                $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;

                $audio = $image->storeAs('questions',$custom_file_name);
                $json_data[$key]['lesson_audio'] = $custom_file_name;
                
            }
        }
        
        $basic_lession->lesson_json_data = json_encode($json_data);
        if($basic_lession->save()){
            \Session::flash('flash_message','successfully saved.');
        }
        
       
        return redirect()->route('basic_lessions.index');

   }
   public function edit($id)
    {
        // dd($lession);
        $lession = LessionPlus::findOrFail($id);
        $lession['level'] = DB::select("SELECT * FROM levels");
        $lession['units'] = Units::select('*')->get();
        // dd($lession);
        return view('admin.basic_lession.edit', compact('lession'));
        
    }


    public function update(Request $request, $id)
    {
        $basic_lession = LessionPlus::findOrFail($id);
        $json_data = array();
        $input = $request->all();
        $request->validate([
            'lesson_title' => 'required',
        ]);
        if ($request->file('bulk_audio')!=null){
            $file_extension = explode(".",$request->file('bulk_audio')->getClientOriginalName());
            $file_extension = end($file_extension);
            $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;

            $audio = $request->file('bulk_audio')->storeAs('lesson_audio',$custom_file_name);
            $input['bulk_audio'] = $custom_file_name;
        }
        $basic_lession->lesson_title = $request->lesson_title;;
        $basic_lession->lesson_sub_title = $request->lesson_sub_title;
        $basic_lession->lesson_level = $request->lesson_level;
        $basic_lession->lesson_unit = $request->lesson_unit;
        $basic_lession->lesson_sort = $request->lesson_sort;
        $basic_lession->is_basic = 1;
        $lesson_audio = json_decode($basic_lession['lesson_json_data'],true);
        if(!empty($request->character)){
            foreach ($request->character as $key => $value) {
               $json_data[$key]['character'] = $value;
               $json_data[$key]['arabic'] = $request->arabic[$key];
               $json_data[$key]['english'] = $request->english[$key];
                if(isset($lesson_audio[$key]['lesson_audio'])){
                    if($lesson_audio[$key]['lesson_audio'] != ''){
                        $json_data[$key]['lesson_audio'] = $lesson_audio[$key]['lesson_audio'];
                       }
                   }
            }
        }
        
        if(!empty($request->file('lesson_audio'))){
        foreach($request->file('lesson_audio') as $key => $image)
            {
                if(!file_exists( public_path().'/questions/'.$image)){
                    $file_extension = explode(".",$image->getClientOriginalName());
                    $file_extension = end($file_extension);
                    $custom_file_name = time().'-'.rand(999,9999).'.'.$file_extension;

                    $audio = $image->storeAs('questions',$custom_file_name);
                }
                $json_data[$key]['lesson_audio'] = $custom_file_name;
                
            }
        }
        
        $basic_lession->lesson_json_data = json_encode($json_data);

        if($basic_lession->save()){
            \Session::flash('flash_message','successfully saved.');
        }



        \Session::flash('flash_message','successfully updated.');
        $redirect_url = route('basic_lessions.index');
        return redirect($redirect_url);
    }


    public function destroy($id)
    {
        $lession = LessionPlus::findOrFail($id);
        $lession->delete();
        \Session::flash('flash_message','successfully deleted.');
        return redirect()->route('basic_lession.index');
    }

}
