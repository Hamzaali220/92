<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**

     * Create a new authentication controller instance.

     *

     * @return void

     */

    public function __construct()

    {

    }

    /* Check login role like usr or admin */
    public function getAdminLogin()

    {

        if (Auth::guard('admin')->user()) return redirect()->route('admin.dashboard');

        return view('admin.pages.login');

    }

    /* For authentication */
    public function adminAuth(Request $request)

    {

        if (Auth::guard('admin')->user()) return redirect()->route('admin.dashboard');

        $rules = array(

            'email'                 => 'required|email',

            'password'              => 'required|min:5'

        );

        $input_arr = array(

            'password'              => $request->input('password'),

            'email'                 => $request->input('email'),

        );

        $validator = Validator::make($input_arr,$rules);

        if( $validator->fails() ):

            return Redirect::back()->withErrors($validator)->withInput();

        else:

            $user= new User;

            $data = $user->getByEmailOrId( array('email' => $input_arr['email'],'role'=>1) );

            if(!empty($data)){



                if(!Hash::check($input_arr['password'], $data->password)){

                    return Redirect::back()->withErrors(["check" => "Email and password combination is incorrect!"])->withInput();

                }

                if($data->status == 0){

                    return Redirect::back()->withErrors(["check" => "Your account is not active."])->withInput();

                }

                if($data->agents_users_role_id != 1){

                    return Redirect::back()->withErrors(["check" => "Email not found in the Administrator database!"])->withInput();

                }



                if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->remember)):

                    $userupdate = User::find(Auth::guard('admin')->user()->id);

                    $userupdate->login_status           =   'Online';

                    $userupdate->updated_at         =   Carbon::now()->toDateTimeString();

                    $userupdate->save();

                    return redirect('agentadmin/dashboard');

                endif;



                return redirect()->back()->withInput($request->only('email', 'remember'));

            }

            return Redirect::back()->withErrors(["email" => "This email address does not exist."])->withInput();

        endif;

    }

    /* For logout */
    public function logout() {

        if(Auth::check()){
             $userupdate = User::find(Auth::guard('admin')->user()->id);

            $userupdate->login_status           =   'Offline';

            $userupdate->updated_at         =   Carbon::now()->toDateTimeString();

            $userupdate->save();
        }


        Auth::guard('admin')->logout();

        return Redirect::to('/agentadmin');

    }

}

