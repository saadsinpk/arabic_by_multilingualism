<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Levels;
use DB;

class LevelsController extends Controller
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
        return view('admin.levels.index');
    }
    public function create()
    {
        $unit = DB::select("SELECT * FROM units");
        return view('admin.levels.level_add', compact('unit'));
    }
    public function store(request $request )
    {
        // dd($request->all());
        $request->validate([
            'level_name' => 'required',
        ]);
        $input = $request->all();
        $input['level_unit'] = json_encode($request->level_unit);
        
        Levels::create($input);
        \Session::flash('flash_message','successfully saved.');
       
        return redirect()->route('levels.index');

   }
   public function edit($id)
    {
        $level = Levels::findOrFail($id);
        $level['level_unit'] = json_decode($level['level_unit'],true);
        $level['unit'] = DB::select("SELECT * FROM units");
 
        return view('admin.levels.edit', compact('level'));
        
    }


    public function update(Request $request, $id)
    {

        $level = Levels::findOrFail($id);

        $request->validate([
            'level_name' => 'required',
        ]);

        $input = $request->all();
        $input['level_unit'] = json_encode($request->level_unit);
        $level->fill($input)->save();
        \Session::flash('flash_message','successfully updated.');
        return redirect()->route('levels.index');
    }


    public function destroy($id)
    {
        $level = Levels::findOrFail($id);
        $level->delete();
        \Session::flash('flash_message','successfully deleted.');
        return redirect()->route('levels.index');
    }

}