<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Api\User;
use Validator;
use JWTAuth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Mail;
use App\Mail\OtpSend;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Notifications\Notifiable;
use DB;

class AuthController extends Controller
{
	use SendsPasswordResetEmails;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        // /$this->middleware('jwt.verify', ['except' => ['login', 'register']]);

    }

    

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
    		'email' => 'required|email',
    		'password' => 'required|string|min:6',
    	]);

    	if ($validator->fails()) {
    		return response()->json($validator->errors(), 422);
    	}

    	if (! $token = JWTAuth::attempt($validator->validated())) {
    		return response()->json(['error' => 'Unauthorized'], 401);
    	}

    	$user = JWTAuth::user();
    	$token = JWTAuth::fromUser($user);

        $user_id = JWTAuth::user()->id;

    	return response()->json(compact('token'),201);
    	

    }
    public function verify_otp(Request $request){
        $validator = Validator::make($request->all(), [
            'user_otp' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $users = User::where('user_otp', '=', $request->input('user_otp'))->where('user_otp_time', '>=', date('Y-m-d H:i:s'))->first();
        if ($users === null) {
            return response()->json(['message' => 'Otp not match or expire.'],400);
        } else {
            if($users->user_ban == 1){
                $token = JWTAuth::fromUser($users);
                return $this->createNewToken($token,$users);
            }else{

                return response()->json(['message' => 'redirect to login.'],200);
            }

        }
    }
    public function resend_otp(Request $request){
        $validator = Validator::make($request->all(), [
            'user_otp' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::where('user_otp', '=', $request->input('user_otp'))->where('user_otp_time', '>=', date('Y-m-d H:i:s'))->first();
        if ($user === null) {
            return response()->json(['message' => 'Otp not match or expire.'],400);
        } else {
           $otp = $this->generateOTP();
            $date = Carbon::now('UTC')->addHour(12)->format('Y-m-d H:i:s');
            $user->user_otp = $otp;
            $user->user_otp_time = $date;
            if($user->save()){
                $user['title'] = 'Hi Your otp is below';
                $user['otp'] = $otp;
                Mail::to($user->email)->send(new OtpSend($user));
                return response()->json(['message' => 'Otp successfully sent for password reset request.',
                    'otp'=>$otp,
                ],200);
            }
        }
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'first_name' => 'required|string|max:255',
    		'last_name' => 'required|string|max:255',
    		'email' => 'required|email|max:255|unique:users',
    		'password' => 'required|string|min:6',
    	]);

    	if($validator->fails()){
    		return response()->json($validator->errors()->toJson(), 400);
    	}
        $level = DB::select("SELECT * FROM levels WHERE level_min_marks = '0'");
        if(isset($level[0])) {
            $level_id = $level[0]->level_id;
        }

    	$user = User::create([
    		'name' => $request->get('first_name').' '.$request->get('last_name'),
    		'username' => $request->get('email'),
    		'email' => $request->get('email'),
    		'firstname' => $request->get('first_name'),
    		'lastname' => $request->get('last_name'),	
            'usergroup' => 2,
            'user_points' => 0,
    		'user_level' => $level_id,
    		'password' => Hash::make($request->get('password')),
    	]);
    	$otp = $this->generateOTP();
    	$date = Carbon::now('UTC')->addHour(12)->format('Y-m-d H:i:s');
    	$user->user_otp = $otp;
    	$user->user_otp_time = $date;
    	if($user->save()){
    		$user['title'] = 'Hi Your otp is below';
    		$user['otp'] = $otp;
    		Mail::to($user->email)->send(new OtpSend($user));
          //  Mail::send('emails.send', ['data'=>$data], function ($message) use ($user) {
          //   $message->subject('Otp Verifcation');
          //     $message->from('ahmad@mail.com', 'Ahmad');
          //     $message->to($user->email);
          // });
    		return response()->json(['message' => 'Otp successfully sent.',
    			'otp'=>$otp,
    		],200);
    	}
    	
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
    Auth::guard('api')->logout();

    return response()->json([
        'status' => 'success',
        'message' => 'logout'
    ], 200);
}

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
    	return $this->createNewToken(JWTAuth::refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
    	return response()->json(JWTAuth::user());
    }

    public function userCheckSubscription() {
        $user_membership = JWTAuth::user()->user_membership;
        $response = array("user_membership" => $user_membership);
        return response($response, 200);
    }

    public function userCheckLevel() {
        $user_level = JWTAuth::user()->user_level;
        $level = DB::select("SELECT * FROM levels WHERE level_id = '".$user_level."'");
        if(isset($level[0])) {
            $response = array("Level_id" => $level[0]->level_id, 'Level_name' => $level[0]->level_name);
            return response($response, 200);
        } else {
            return '';
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token,$users){
    	return response()->json([
    		'access_token' => $token,
    		'token_type' => 'bearer',
    		'expires_in' => JWTAuth::factory()->getTTL() * 60,
    		'user' => $users
    	]);
    }

    public function forgot_password(Request $request)
    {
    	$input = $request->all();
    	$rules = array(
    		'email' => "required|email",
    	);
    	$arr = array();
    	$validator = Validator::make($input, $rules);
    	if ($validator->fails()) {
    		$arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
    	}
    	$user = User::where('email', '=', $request->email)->first();
    	if($user != null){
    		$otp = $this->generateOTP();
    		$date = Carbon::now('UTC')->addHour(12)->format('Y-m-d H:i:s');
    		$user->user_otp = $otp;
    		$user->user_otp_time = $date;
    		if($user->save()){
    			$user['title'] = 'Hi Your otp is below';
    			$user['otp'] = $otp;
    			Mail::to($user->email)->send(new OtpSend($user));
    			return response()->json(['message' => 'Otp successfully sent for password reset request.',
    				'otp'=>$otp,
    			],200);
    		}
    	}
    	return response()->json(['message' => 'Email not found '
    ],200);
            // } else {
            //     try {
            //         $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            //             $message->subject($this->getEmailSubject());
            //         });
            //         dd($response);
            //         switch ($response) {
            //             case Password::RESET_LINK_SENT:
            //                 return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
            //             case Password::INVALID_USER:
            //                 return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
            //         }
            //     } catch (\Swift_TransportException $ex) {
            //         $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            //     } catch (Exception $ex) {
            //         $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            //     }
            // }
            // return \Response::json(array("status" => 200, "message" => 'Password reset request sent.', "data" => array()));
            //return \Response::json($arr);
    }

    public function change_password(Request $request)
    {
    	$user = '';
    	$input = $request->all();
    	if(isset($request->user_otp)){
    		$rules = array(
    			'user_otp' => 'required|numeric',
	                // 'old_password' => 'required',
    			'new_password' => 'required|min:6',
    			'confirm_password' => 'required|same:new_password',
    		);
    		$user = User::where('user_otp', '=', $request->input('user_otp'))->where('user_otp_time', '>=', date('Y-m-d H:i:s'))->first();
		    	if ($user === null) {
		    		return response()->json(['message' => 'Otp not match or expire.'],400);
		    	}
    		$validator = Validator::make($input, $rules);
    		if ($validator->fails()) {
    			$arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
    		} else {
    			try {
    				if ((Hash::check(request('new_password'), $user->password)) == true) {
    					$arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
    				} else {
    					User::where('id', $user->id)->update(['password' => Hash::make($input['new_password'])]);
    					$arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());

    				}
    			} catch (\Exception $ex) {
    				if (isset($ex->errorInfo[2])) {
    					$msg = $ex->errorInfo[2];
    				} else {
    					$msg = $ex->getMessage();
    				}
    				$arr = array("status" => 400, "message" => $msg, "data" => array());
    			}
    		}
    		if($user->user_ban == 1){
    			$token = JWTAuth::fromUser($user);
    			return $this->createNewToken($token,$user);
    		}
    		return \Response::json($arr);
    	}else if(isset($request->old_password)){
    		$user = JWTAuth::user();
    		$user =User::findOrFail(11);
    		$rules = array(
    			'old_password' => 'required',
    			'new_password' => 'required|min:6',
    			'confirm_password' => 'required|same:new_password',
    		);

    		$validator = Validator::make($input, $rules);
    		if ($validator->fails()) {
    			$arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
    		} else {
    			try {
    				if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
    					$arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
    				} 
    				else if ((Hash::check(request('new_password'), $user->password)) == true) {
    					$arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
    				} else {
    					User::where('id', $user->id)->update(['password' => Hash::make($input['new_password'])]);
    					$arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());

    				}
    			} catch (\Exception $ex) {
    				if (isset($ex->errorInfo[2])) {
    					$msg = $ex->errorInfo[2];
    				} else {
    					$msg = $ex->getMessage();
    				}
    				$arr = array("status" => 400, "message" => $msg, "data" => array());
    			}
    		}
    		if($user->user_ban == 1){
    			$token = JWTAuth::fromUser($user);
    			return $this->createNewToken($token,$user);
    		}
    		return \Response::json($arr);
    	}


    }

    public function generateOTP(){
    	$otp = mt_rand(1000,9999);
    	return $otp;
    }

  public function getEmailUseOrNo(Request $request, $id) {
        $user = User::where('email', '=', $id)->first();
        if(!empty($user)) {
            $response = json_encode( array("status"=>'error', 'message'=>'Email already in use'));
            return response($response, 200);
        } else {
            $response = json_encode( array("status"=>'success', 'message'=>'Email not in use'));
            return response($response, 200);

        }
  }


  public function getFacebookDelete(Request $request) {
    $array = array('success'=>true,'status'=>200);
    echo json_encode($array); 
  }

  public function getFacebookLogin(Request $request, $id) {
    $user_details = "https://graph.facebook.com/me?fields=name,email&access_token=".$id;
    $response = file_get_contents($user_details);
    $response_decode = json_decode($response);

    if(isset($response_decode->email)) {
        $password = $response_decode->id.'123';
        $name = $response_decode->name;
        $email = $response_decode->email;
        $status = DB::select("SELECT * FROM `users` WHERE `email` = '".$email."'");
        if(count($status) >= 1) {
            $status = $status[0];
            if ($status === null) {
            } else {
                if($status->user_ban == 1){
                    $users = User::where('id', '=', $status->id)->first();
                    $token = JWTAuth::fromUser($users);
                    return $this->createNewToken($token,$users);
                }else{
                    return response()->json(['message' => 'redirect to login.'],200);
                }
            }
        } else {
            $level = DB::select("SELECT * FROM levels WHERE level_min_marks = '0'");
            if(isset($level[0])) {
                $level_id = $level[0]->level_id;
            }

            $user = User::create([
                'name' => $name,
                'username' => $email,
                'email' => $email,
                'firstname' => $name,
                'lastname' => '', 
                'usergroup' => 2,
                'user_points' => 0,
                'user_level' => $level_id,
                'password' => Hash::make('123456789'),
            ]);
            $users = User::where('email', '=', $email)->first();
            $token = JWTAuth::fromUser($users);
            return $this->createNewToken($token,$users);
        }
    }
    return response($response, 200);
  }

  public function doAppleLogin(Request $request,$id){
       
        $token = $id;
        $email = $token.'@arabiclanguageapp.co.uk';
        $email = str_replace('.','',$email);
        $status = DB::select("SELECT * FROM `users` WHERE `email` = '".$email."'");
        if(count($status) >= 1) {
            $status = $status[0];
            if ($status === null) {
            } else {
                if($status->user_ban == 1){
                    $users = User::where('id', '=', $status->id)->first();
                    $token = JWTAuth::fromUser($users);
                    return $this->createNewToken($token,$users);
                }else{
                    return response()->json(['message' => 'redirect to login.'],200);
                }
            }
        }
        else {
            $level = DB::select("SELECT * FROM levels WHERE level_min_marks = '0'");
            if(isset($level[0])) {
                $level_id = $level[0]->level_id;
            }

            $user = User::create([
                'name' => 'Apple User',
                'username' => $email,
                'email' => $email,
                'firstname' => 'Apple User',
                'lastname' => '', 
                'usergroup' => 2,
                'user_points' => 0,
                'user_level' => $level_id,
                'password' => Hash::make('123456789'),
            ]);
            $users = User::where('email', '=', 'ahmed@mail.com')->first();
            $token = JWTAuth::fromUser($users);
            return $this->createNewToken($token,$users);
        }
    }

}