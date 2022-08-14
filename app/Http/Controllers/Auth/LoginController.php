<?php

namespace App\Http\Controllers\Auth;

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
use Carbon\Carbon;

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

    /* For login process */
    public function login(Request $request)
    {

        # added google re-captcha validation
        $rules = array(
            'email'                 => 'required|email',
            'password'                 => 'required|min:6'
        );
        $input_arr = array(
            'password'              => $request->input('password'),
            'email'                 => $request->input('email'),
            'agents_users_role_id'     => $request->input('agents_users_role_id')
        );
        $validator = Validator::make($input_arr, $rules);
        if ($validator->fails()) :
            return Redirect::back()->withErrors($validator)->withInput();
        else :
            $user = new User;
            $data1 = $data2 = [];
            if ($input_arr['agents_users_role_id'] == 3 || $input_arr['agents_users_role_id'] == 2) {
                $data1 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => 2));
                $data2 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => 3));
            }

            $data = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => $input_arr['agents_users_role_id']));
            if (!empty($data1) || !empty($data2)) {

                if (!Hash::check($input_arr['password'], $data->password)) {
                    return Redirect::back()->withErrors(["check" => "Email and password combination is incorrect!"])->withInput();
                }
                if ($data->status == 0) {
                    return Redirect::back()->withErrors(["check" => "Your account is not active."])->withInput();
                }
                if ($input_arr['agents_users_role_id'] == 4 && ($input_arr['agents_users_role_id'] != $data->agents_users_role_id)) {
                    return Redirect::back()->withErrors(["check" => "Email not found in the Agents database!"])->withInput();
                }
                if ($input_arr['agents_users_role_id'] == 1 && ($input_arr['agents_users_role_id'] != $data->agents_users_role_id)) {
                    return Redirect::back()->withErrors(["check" => "Email not found in the Administrator database!"])->withInput();
                }
                if (($input_arr['agents_users_role_id'] == 2 || $input_arr['agents_users_role_id'] == 3) && (!in_array($data->agents_users_role_id, array('2', '3')))) {
                    return Redirect::back()->withErrors(["check" => "Email not found in the Buyer/Seller database!"])->withInput();
                }
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) :
                    $userupdate = User::find(Auth::user()->id);
                    $userupdate->agents_users_role_id    =    $input_arr['agents_users_role_id'];
                    $userupdate->login_status            =     'Online';
                    $userupdate->updated_at            =     Carbon::now()->toDateTimeString();
                    $userupdate->save();
                    return redirect('/dashboard');
                endif;
                return redirect()->back()->withInput($request->only('email', 'remember'));
            }
            return Redirect::back()->withErrors(["email" => "This email address does not exist."])->withInput();
        endif;
    }

    /* login api check credentials */
    public function login_api(Request $request)
    {
        # validations added for re-captcha by mishrar
        $rules = array(
            'email'                 => 'required|email',
            'password'                 => 'required|min:6',
         //   'g-recaptcha-response' => 'required|captcha'
        );
        $input_arr = array(
            'password'              => $request->input('password'),
            'email'                 => $request->input('email'),
            'agents_users_role_id'     => $request->input('agents_users_role_id'),
        //    'g-recaptcha-response' => $request->input('g-recaptcha-response')
        );
        $validator = Validator::make($input_arr, $rules);
        if ($validator->fails()) :
            return response()->json(['error' => $validator->errors()]);
        else :
            $user = new User;
            $data1 = $data2 = [];
            if ($input_arr['agents_users_role_id'] == 2 || $input_arr['agents_users_role_id'] == 3) {
                $data1 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => 2));
                $data2 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => 3));
            } else {
                $data1 = $user->getByEmailOrId(array('email' => $input_arr['email'], 'role' => $input_arr['agents_users_role_id']));
            }

            if (!empty($data1) || !empty($data2)) {
                $data = (!empty($data1)) ? $data1 : $data2;

                // Check if user is deleted
                if ($data->is_deleted == 1) {
                    return response()->json(["check" => "Email not found in the database!"]);
                }

                if (!Hash::check($input_arr['password'], $data->password)) {
                    return response()->json(["check" => "Email and password combination is incorrect!"]);
                }
                if ($data->status == 0) {
                    return response()->json(["check" => "Your account is not active."]);
                }
                if ($data->agent_status == 3) {
                    return response()->json(["check" => "Your account is permanantly suspended please contact admin."]);
                }
                if ($input_arr['agents_users_role_id'] == 4 && ($input_arr['agents_users_role_id'] != $data->agents_users_role_id)) {
                    return response()->json(["check" => "Email not found in the Agents database!"]);
                }
                if ($input_arr['agents_users_role_id'] == 1 && ($input_arr['agents_users_role_id'] != $data->agents_users_role_id)) {
                    return response()->json(["check" => "Email not found in the Administrator database!"]);
                }
                if (($input_arr['agents_users_role_id'] == 2 || $input_arr['agents_users_role_id'] == 3) && (!in_array($data->agents_users_role_id, array('2', '3')))) {
                    return response()->json(["check" => "Email not found in the Buyer/Seller database!"]);
                }
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) :
                    $userupdate = User::find(Auth::user()->id);
                    $userupdate->agents_users_role_id    =    $input_arr['agents_users_role_id'];
                    $userupdate->login_status            =     'Online';
                    $userupdate->updated_at            =     Carbon::now()->toDateTimeString();
                    $userupdate->fcm_token            =     $request->filled('fcm_token') ? $request->fcm_token : NULL;
                    $userupdate->device_type            =     $request->filled('device_type') ? $request->device_type : NULL;
                    $userupdate->save();
                    return response()->json(["success" => "success", 'data' => $userupdate->toArray()]);
                endif;
                // return redirect()->back()->withInput($request->only('email', 'remember'));
            }
            return response()->json(["email" => "This email address does not exist."]);
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
