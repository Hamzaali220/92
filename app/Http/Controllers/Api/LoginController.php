<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Userdetails;
use Carbon\Carbon;
// Laravel\Passport\PassportServiceProvider::class,

class LoginController extends Controller
{
    /*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $rules = array(
            'email'                 => 'required|email',
            'password'                 => 'required'
        );
        
        $input_arr = array(
            'password'              => $request->input('password'),
            'email'                 => $request->input('email'),
            'agents_users_role_id'     => $request->input('agents_users_role_id')
        );
        $validator = Validator::make($input_arr, $rules);
        
        if ($validator->fails()) :
            return response()->json(['error' => $validator->errors()]);
            else :
                $user = new User;
                
                $data1 = $data2 = [];
                if ($input_arr['agents_users_role_id'] == 3 || $input_arr['agents_users_role_id'] == 2) {
                    $data1 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => 2));
                    $data2 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => 3));
                } else {
                    $data1 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => $input_arr['agents_users_role_id']));
                }
                
                $data = (!empty($data1)) ? $data1 : $data2;
                
            // $data = $user->getByEmailOrId(array('email'=>$input_arr['email'], 'role'=>$input_arr['agents_users_role_id']));

            if (!empty($data)) {
                
                if (!Hash::check($input_arr['password'], $data->password)) {
                    return response()->json(["error" => "Email and password combination is incorrect!", "status" => '101']);
                }

                if ($data->is_deleted == 1) {
                    return response()->json(["check" => "Email not found in the database!"]);
                }

                if ($data->status == 0) {
                    return response()->json(["error" => "Your account is not active.", "status" => '101']);
                }
                if ($input_arr['agents_users_role_id'] == 4 && ($input_arr['agents_users_role_id'] != $data->agents_users_role_id)) {
                    return response()->json(["error" => "Email not found in the Agents database!", "status" => '101']);
                }
                if ($input_arr['agents_users_role_id'] == 1 && ($input_arr['agents_users_role_id'] != $data->agents_users_role_id)) {
                    return response()->json(["error" => "Email not found in the Administrator database!", "status" => '101']);
                }
                if (($input_arr['agents_users_role_id'] == 2 || $input_arr['agents_users_role_id'] == 3) && (!in_array($data->agents_users_role_id, array('2', '3')))) {
                    return response()->json(["error" => "Email not found in the Buyer/Seller database!", "status" => '101']);
                }
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) :
                    
                    $userupdate = User::find(Auth::user()->id);
                    $userupdate->agents_users_role_id    =    $input_arr['agents_users_role_id'];
                    $userupdate->login_status            =     'Online';
                    $userupdate->updated_at            =     Carbon::now()->toDateTimeString();
                    $userupdate->save();
                    $user = $request->user();

// dd($user);
                    # User details
                    $userdetails = Userdetails::find(Auth::user()->id);
                    $details_arr = array(
                        'full_name' => $userdetails->name,
                        'fname' => $userdetails->fname,
                        'lname' => $userdetails->lname,
                        'profile_pic' => url('/assets/img/profile/' . $userdetails->photo)
                    );
                    $tokenResult = $user->createToken('Personal Access Token');
                    // dd($user);
                    $token = $tokenResult->token;
                    if ($request->remember_me)
                        $token->expires_at = Carbon::now()->addWeeks(1);
                    $token->save();
                    // dd($token);
                    return response()->json([
                        'status' => '100',
                        'access_token' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString(),
                        'user' => $userupdate,
                        'user_details' => $details_arr
                    ]);
                endif;
            }
            return response()->json(['error' => "This email address does not exist", 'status' => '101']);
        endif;
    }

    /* For logout or session destroy */
    public function logout()
    {
        $userupdate = User::find(Auth::user()->id);
        $userupdate->login_status =     'Offline';
        $userupdate->updated_at    = Carbon::now()->toDateTimeString();
        $userupdate->save();
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }
}
