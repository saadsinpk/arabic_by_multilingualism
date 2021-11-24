<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LessionPlus;
use App\Models\Levels;
use App\Models\Units;
use Illuminate\Http\File;
use DB;
use Response;

class LessionPlusController extends Controller
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
        return view('admin.basic_plus_lession.index');
    }
    public function create()
    {
        $level = DB::select("SELECT * FROM levels");
        return view('admin.basic_plus_lession.add_plus_lession', compact('level'));
    }
    public function store(request $request )
    {
        $request->validate([
            'lesson_title' => 'required'
        ]);
        
        $basic_lession = new LessionPlus;
        $basic_lession->lesson_title = $request->lesson_title;
        $basic_lession->lesson_level = $request->lesson_level;
        $basic_lession->lesson_unit = $request->lesson_unit;
        $basic_lession->lesson_content = $request->lesson_content;
        $basic_lession->lesson_content_2 = $request->lesson_content_2;
        if ($request->file('lesson_audio')!=null){
            $custom_file_name = time().'-'.$request->file('lesson_audio')->getClientOriginalName();
            $audio = $request->file('lesson_audio')->storeAs('lesson_audio',$custom_file_name);
            $basic_lession->lesson_audio = $custom_file_name;
        }
        $input = $request->all();
        if(!empty($request->word_arabic)){
            foreach ($request->word_arabic as $key => $value) {
               $json_data[$key]['word_arabic'] = $value;
               $json_data[$key]['word_english'] = $request->word_english[$key];
               $json_data[$key]['word_meaning'] = $request->word_meaning[$key];
            }
        }

        if(!empty($request->file('word_audio'))){
        foreach($request->file('word_audio') as $key => $image)
            {
                $filename = $image->getClientOriginalName();
                $audio = $image->storeAs('lesson_audio',$filename);
                $json_data[$key]['word_audio'] = $filename;
                
            }
        }
        $basic_lession->lesson_tags = json_encode($json_data);
        if($basic_lession->save()){
            \Session::flash('flash_message','successfully saved.');
        }
       
        return redirect()->route('basic_lession_plus.index');

   }
   public function edit($id)
    {
        $lession_plus = LessionPlus::findOrFail($id);
        $lession_plus['units'] = Units::select('*')->get();
        $lession_plus['level'] = DB::select("SELECT * FROM levels");

        return view('admin.basic_plus_lession.edit', compact('lession_plus'));
        
    }


    public function update(Request $request, $id)
    {

        $lession_plus = LessionPlus::findOrFail($id);
        $input = $request->all();
        $request->validate([
            'lesson_title' => 'required'
        ]);
        if ($request->file('lesson_audio')!=null){
            $custom_file_name = time().'-'.$request->file('lesson_audio')->getClientOriginalName();
            $audio = $request->file('lesson_audio')->storeAs('lesson_audio',$custom_file_name);
            $input['lesson_audio'] = $custom_file_name;
        }
        $total_words = 0;
        $word_audios = json_decode($lession_plus['lesson_tags'],true);
        if(!empty($request->word_arabic)){
            $total_words = count($request->word_arabic);
            foreach ($request->word_arabic as $key => $value) {
               $json_data[$key]['word_arabic'] = $value;
               $json_data[$key]['word_english'] = $request->word_english[$key];
               $json_data[$key]['word_meaning'] = $request->word_meaning[$key];
               if(isset($word_audios[$key]['word_audio']) && $word_audios[$key] !=''){
                    $json_data[$key]['word_audio'] = $word_audios[$key]['word_audio'];
                }
            }
        }
        if(!empty($request->file('word_audio'))){
        foreach($request->file('word_audio') as $key => $image)
            {
                if(!file_exists( public_path().'lesson_audio/'.$image)){
                    
                    $filename = $image->getClientOriginalName();
                    $audio = $image->storeAs('lesson_audio',$filename);
                }
                $json_data[$key]['word_audio'] = $filename;
                
            }
        }
        // dd($json_data);
        if(isset($json_data)){
            $input['lesson_tags'] = json_encode($json_data);
        }
        

        $input['total_words'] = $total_words;
        // $input['lesson_content'] = json_encode($request->lesson_content);
        $lession_plus->fill($input)->save();
        \Session::flash('flash_message','successfully updated.');
        return redirect()->route('basic_lession_plus.index');
    }


    public function destroy($id)
    {
        $lession_plus = LessionPlus::findOrFail($id);
        $lession_plus->delete();
        \Session::flash('flash_message','successfully deleted.');
        return redirect()->route('basic_lession_plus.index');
    }

    public function get_unit($id){
        // $levels = Levels::findOrFail($id);
        // $unit_ids = json_decode($levels['level_unit'],true);
        $units = DB::select("SELECT * FROM units WHERE unit_level = '".$id."'");
        // $units = Units::whereIn('unit_level', $id)->get();
         $data ='';
        if(!empty($units)){
            foreach ($units as $key => $unit) {
                $data .= '<option value="'.$unit->unit_id.'">'.$unit->unit_name.'</option>';
            }
        }
        return Response::json(array(
                    'success' => true,
                    'data'   => $data
                )); 
        
    }

}
