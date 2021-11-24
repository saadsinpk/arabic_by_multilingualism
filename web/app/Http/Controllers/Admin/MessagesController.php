<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Messages;
use Auth;

class MessagesController extends Controller
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
        return view('admin.messages.index');
    }
    public function show()
    {
        return view('admin.messages.message_view');
    }
    public function store(request $request )
    {
        $request->validate([
            'message' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['sendbyuser'] = Auth::user()->id;
        Messages::create($input);
        \Session::flash('flash_message','successfully saved.');
       
        return redirect()->route('messages.index');

   }
   public function edit($id)
    {
        $messages = Messages::where('user_id',$id)->first();
        if($messages === null){
          $messages['user_id'] = $id;
        }
        $messages_all = Messages::where('user_id',$id)->get();
        return view('admin.messages.message_view', compact('messages','messages_all'));
        
    }


    public function update(Request $request, $id)
    {
       $request->validate([
            'message' => 'required',
        ]);
       // echo $id;
       // dd($request->all());
       $user_id = Auth::user()->id;
        // $message = Messages::where('user_id',$id)->first();
        // if(isset($message)){
            $messag = new Messages;
            $messag->message = $request->message;
            $messag->user_id = $id;
            $messag->sendbyuser = $user_id;
            $messag->save();
            //Messages::create($input);
        // }
        
        // $message->fill($input)->save();
        \Session::flash('flash_message','successfully added.');
        return redirect()->route('messages.index');
    }
     public function add(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $$input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['sendbyuser'] = Auth::user()->id;
        Messages::create($input);
        \Session::flash('flash_message','successfully saved.');
        \Session::flash('flash_message','successfully updated.');
        return redirect()->route('messages.index');
    }



    public function destroy($id)
    {
        $message = Messages::findOrFail($id);
        $message->delete();
        \Session::flash('flash_message','successfully deleted.');
        return redirect()->route('messages.index');
    }

   
}