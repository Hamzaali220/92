<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Models\State;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Helper\StripHelper;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SignUpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }



    /* For send main for new user */
    public function NewUserMailSend($data)
    {
        $emaildata = array();
        $emaildata['email']     =     $data['email'];
        $emaildata['rolename']     =     $data['rolename'];
        $emaildata['url']     =       $data['url'];
        $emaildata['name']     =       $data['name'];

        Mail::send('email.activate', $emaildata, function ($message) use ($emaildata) {
            $message->to($emaildata['email'], $emaildata['name'])
                ->subject('Activate your 92Agents ' . $emaildata['rolename'] . ' Account.');
            $message->from('92agent@92agents.com', '92Agents');
        });
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    /*signup step 1*/
    public function signup(Request $request)
    {
        $postStep = $request->input('step');
        $roleId = $request->input('agents_users_role_id');
        $rules = array();
        $rules['agents_users_role_id']  =   ['required', Rule::in(['1', '2', '3', '4'])];
        $rules['fname']                 =   'required';
        $rules['lname']                 =   'required';
        $rules['email']                 =   'required|email';
        $rules['terms_and_conditions']  =   'required';
        $rules['password']              =   'required|min:6';
        $rules['confirm_password']      =   'required|same:password';

        $error_message = array(
            'terms_and_conditions.required' => 'Acceptance of Terms and Conditions is required',
            'fname.required'                => 'The first name is required',
            'lname.required'                => 'The last name is required',
        );

        $validator = Validator::make($request->all(), $rules, $error_message);

        if ($validator->fails()) :
            return response()->json(['error' => $validator->errors(), 'status' => '101']);
        else :
            $user = new User;
            $userExits = $user->getDetailsByEmailOrId(array('email' => $request->input('email')));

            if (empty($userExits)) {
                $activation_link = uniqid();
                $user                       = new User;
                $user->agents_users_role_id = $roleId;
                $user->step                 = $postStep;
                $user->email                = $request->input('email');
                $user->password             = Hash::make($request->input('password'));
                $user->activation_link      = $activation_link;
                $user->save();

                $details                =    array();
                $details['details_id']  =   $user->id;
                $details['name']        =   $request->input('fname') . ' ' . $request->input('lname');
                $details['fname']       =   $request->input('fname');
                $details['lname']       =   $request->input('lname');

                DB::table('agents_users_details')->insertGetId($details);

                $emaildata = array();
                $emaildata['email']     =   $request->input('email');
                $emaildata['rolename']  =   env("user_role_" . $roleId);
                $emaildata['url']       =   url('/') . '/login?usertype=' . $emaildata['rolename'] . '&activation_link=' . $activation_link;
                $emaildata['name']      =   ucwords($details['name']);

                $userDetails = $user->getDetailsByEmailOrId(array('id' => $user->id));
                $this->NewUserMailSend($emaildata);
                return response()->json(['status' => '100', 'userDetails' => $userDetails, 'step' => '1', 'emaildata' => $emaildata]);
            } else {
                if ($userExits->agents_users_role_id == $roleId && $userExits->step == 3) {
                    return response()->json(array('error' => 'Email already exist in our records please use login button.', 'status' => '101'));
                } else {
                    if ($userExits->agents_users_role_id != $roleId && $userExits->agents_users_role_id == 4) {
                        return response()->json(array('error' => 'Email already exist in our records as an agent.', 'status' => '101'));
                    }
                    if (($userExits->agents_users_role_id == 2 || $userExits->agents_users_role_id == 3) && $userExits->step == 3) {
                        return response()->json(array('error' => 'Email already exist .please try with another email in our records as a seller or buyer.', 'status' => '101'));
                    }

                    return response()->json(['status' => '100', 'userDetails'   =>  $userExits, 'step' => '1']);
                }
            }

        endif;
    }

    /*signup step 2*/
    public function signup2(Request $request)
    {
        $postStep = $request->input('step');
        $roleId = $request->input('agents_users_role_id');

        $rules                      = array();
        $rules['id']                = 'required';
        $rules['phone']             = 'required';
        $rules['address_line_1']    = 'required';
        $rules['city']              = 'required';
        $rules['state']             = 'required';
        $rules['zip_code']          = 'required';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) :
            return response()->json(['status' => '101', 'error' => $validator->errors()]);
        else :

            $input_arr['address_line_2'] = $request->input('address_line_2');

            if (!empty($request->input('id')) && User::find($request->input('id')) && Userdetails::find($request->input('id'))) {

                $userdetails = Userdetails::find($request->input('id'));
                $userdetails->phone     = $request->input('phone');
                $userdetails->address   = $request->input('address_line_1');
                $userdetails->address2  = $request->input('address_line_2') != '' ? $request->input('address_line_2') : '';
                $userdetails->state_id  = $request->input('state');
                $userdetails->city_id   = $request->input('city');
                $userdetails->zip_code  = $request->input('zip_code');
                $userdetails->save();

                $user = User::find($request->input('id'));
                $user->step = $postStep;
                $user->save();

                $userDetailssend = $user->getDetailsByEmailOrId(array('id' => $userdetails->details_id));

                if ($roleId == 3 || $roleId == 2) {

                    $post =  new Post;
                    $postdetails = $post->getDetailsByUserroleandId($request->input('id'), $roleId);

                    return response()->json(['status' => '100', 'userDetails' => $userDetailssend, 'postdetails' => $postdetails, 'step' => '2']);
                } else {

                    return response()->json(['status' => '100', 'userDetails' => $userDetailssend, 'step' => '2']);
                }
            } else {

                return response()->json(['status' => '101', 'error' => 'User not found. Please refresh the page and try again.']);
            }
        endif;
    }

    /*signup step 3*/
    public function signup3(Request $request)
    {
        $postStep   = $request->input('step');
        $roleId     = $request->input('agents_users_role_id');
        $user_id    = $request->input('id');

        if (!empty($user_id) && User::find($user_id) && Userdetails::find($user_id)) {

            /*for buyer and seller */
            if ($roleId == 3 || $roleId == 2) {

                $rules                      = array();
                $rules['posttitle'] =   'required';

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) :

                    return response()->json(['status' => '101', 'error' => $validator->errors()]);

                else :
                    $post =  new Post;
                    $postdetails = $post->getDetailsByUserroleandId($user_id, $roleId);

                    if (empty($postdetails)) {

                        $postdetailsnew =   array();
                        $postdetailsnew['agents_user_id']       =   $user_id;
                        $postdetailsnew['agents_users_role_id'] =   $roleId;
                        $postdetailsnew['posttitle']            =   $request->input('posttitle');
                        $postdetailsnew['updated_at']           =   Carbon::now()->toDateTimeString();
                        $postdetailsnew['created_at']           =   Carbon::now()->toDateTimeString();
                        DB::table('agents_posts')->insertGetId($postdetailsnew);
                    } else {

                        $postdetails = Post::find($postdetails->post_id);
                        $postdetails->agents_user_id        =   $user_id;
                        $postdetails->agents_users_role_id  =   $roleId;
                        $postdetails->posttitle             =   $request->input('posttitle');
                        $postdetails->updated_at            =   Carbon::now()->toDateTimeString();
                        $postdetails->created_at            =   Carbon::now()->toDateTimeString();
                        $postdetails->save();
                    }
                    $user           = User::find($user_id);
                    $user->step     = $postStep;
                    $user->save();
                    $userDetailssend    =   $user->getDetailsByEmailOrId(array('id' => $user_id));

                    return response()->json(['status' => '100', 'userDetails' => $userDetailssend, 'step' => '3']);
                endif;
            }

            /*for agents */
            if ($roleId == 4) {

                $rules['licence_number'] =   'required';
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) :

                    return response()->json(['error' => $validator->errors()]);

                else :

                    $userdetails                    = Userdetails::find($user_id);
                    $userdetails->licence_number    = $request->input('licence_number');
                    $userdetails->save();

                    $user           = User::find($user_id);
                    $user->step     = $postStep;
                    $user->save();

                    $userDetailssend    =   $user->getDetailsByEmailOrId(array('id' => $userdetails->details_id));
                    return response()->json(['status' => '100', 'userDetails' => $userDetailssend, 'step' => '3']);

                endif;
            }
        }
        return response()->json(['status' => '101', 'error' => 'User not found. Please refresh the page and try again.']);
    }
}
