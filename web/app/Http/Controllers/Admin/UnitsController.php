<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Units;
use DB;

class UnitsController extends Controller
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
        return view('admin.units.index');
    }
    public function create()
    {
        $level = DB::select("SELECT * FROM levels");
        return view('admin.units.unit_add', compact('level'));
    }
    public function store(request $request )
    {
        $request->validate([
            'unit_name' => 'required',
        ]);
        $input = $request->all();
        Units::create($input);
        \Session::flash('flash_message','successfully saved.');
       
        return redirect()->route('units.index');

   }
   public function edit($id)
    {
        $unit = Units::findOrFail($id);
        $unit['level'] = DB::select("SELECT * FROM levels");

        return view('admin.units.edit', compact('unit'));
        
    }


    public function update(Request $request, $id)
    {

        $unit = Units::findOrFail($id);

        $request->validate([
            'unit_name' => 'required',
        ]);

        $input = $request->all();
        $unit->fill($input)->save();
        \Session::flash('flash_message','successfully updated.');
        return redirect()->route('units.index');
    }


    public function destroy($id)
    {
        $unit = Units::findOrFail($id);
        $unit->delete();
        \Session::flash('flash_message','successfully deleted.');
        return redirect()->route('units.index');
    }

}