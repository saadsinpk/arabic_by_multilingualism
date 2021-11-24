<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use DB;

class UserController extends Controller
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
        return view('admin.users.index');
    }
    public function create()
    {
        $level = DB::select("SELECT * FROM levels");
        return view('admin.users.add_user', compact('level'));
    }
    public function store(request $request )
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'usergroup' => 'required|numeric',
            'firstname' => 'required',
            'lastname' => 'required',
            'language' => 'required',
            'notification' => 'required',
            'user_ban' => 'required',
            'user_membership' => 'required',
            'password' => 'required|string|min:6',
        ]);
        $input = $request->all();
        $input['name'] = $request->firstname.' '.$request->lastname;
        $input['password'] = Hash::make($request->password);
        User::create($input);
        \Session::flash('flash_message','successfully saved.');
       
        return redirect()->route('users.index');
        
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }  


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user['levels'] = DB::select("SELECT * FROM levels");
        return view('admin.users.edit', compact('user'));        
    }


    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if(isset($request->password)) {
            $request->validate([
                'email' => 'required|email|max:255|unique:users,id,'.$user->id,
                'username' => 'required|max:255|unique:users,id,'.$user->id,
                'usergroup' => 'required|numeric',
                'firstname' => 'required',
                'lastname' => 'required',
                'language' => 'required',
                'notification' => 'required',
                'user_ban' => 'required',
                'user_membership' => 'required',
                'password' => 'required|string|min:6',
            ]);

            $input = $request->all();
            $input['name'] = $request->firstname.' '.$request->lastname;
            $input['password'] = Hash::make($request->password);
        } else {
            $request->validate([
                'email' => 'required|email|max:255|unique:users,id,'.$user->id,
                'username' => 'required|max:255|unique:users,id,'.$user->id,
                'usergroup' => 'required|numeric',
                'firstname' => 'required',
                'lastname' => 'required',
                'user_level' => 'required',
                'language' => 'required',
                'notification' => 'required',
                'user_ban' => 'required',
                'user_membership' => 'required',
            ]);

            $input = $request->all();
            $input['name'] = $request->firstname.' '.$request->lastname;
            unset($input['password']);
        }   
        $user->fill($input)->save();
        \Session::flash('flash_message','successfully updated.');
        return redirect()->route('users.index');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index');
    }
    public function user_transaction($id)
    {
        $user = $id;
        return view('admin.users.user_transaction', compact('user'));
    }

    public function login_status($id)
    {
        $user = $id;
        return view('admin.users.login_status', compact('user'));        
    }

    public function question_status($id)
    {
        $user = $id;
        return view('admin.users.question_status', compact('user'));        
    }

    public function lesson_status($id)
    {
        $user = $id;
        return view('admin.users.lesson_status', compact('user'));        
    }

    public function revision_status($id)
    {
        $user = $id;
        return view('admin.users.revision_status', compact('user'));        
    }

    public function remind_status($id)
    {
        $user = $id;
        return view('admin.users.remind_status', compact('user'));        
    }
}