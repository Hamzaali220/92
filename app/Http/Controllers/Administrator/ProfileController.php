<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\Post;
use App\Models\State;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class ProfileController extends Controller
{
    function __construct()
    {
    }

    /* For get agents info */
    public function agent(Request $request)
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $skillsarray = explode(',', $view['userdetails']->skills);

            $view['userdetails']->skills = DB::table('agents_users_agent_skills')
                ->whereIn('skill_id', $skillsarray)->get();
            $view['agentskills'] = DB::table('agents_users_agent_skills')->where('status', '1')->get();

            $view['editfield'] = '<a class="profile-edit-button field-edit"><i class="fa fa-pencil"></i></a>';

            return view('dashboard.user.agents.profile', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }


    /* For buyer profile */
    public function buyer(Request $request)
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);

            $view['editfield'] = '<a class="profile-edit-button field-edit"><i class="fa fa-pencil"></i></a>';

            return view('dashboard.user.buyers.profile', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }


    /* Edit profile  */
    public function editfields(Request $request)
    {

        if (Auth::user()) {
            $input_arr = $input_error_arr = $where = $update = array();

            if ($request->exists('phone')) {
                if (strlen(preg_replace('/[^0-9]/', '', $request->input('phone')))  < 10) {
                    return response()->json(array('status' => 'phoneerror'));
                }
            }

            if ($request->exists('phone_home')) {
                if (strlen(preg_replace('/[^0-9]/', '', $request->input('phone_home')))  < 10) {
                    return response()->json(array('status' => 'phone_home'));
                }
            }

            if ($request->exists('phone_work')) {
                if (strlen(preg_replace('/[^0-9]/', '', $request->input('phone_work')))  < 10) {
                    return response()->json(array('status' => 'phone_work'));
                }
            }

            /* For fax number is not blank */
            if ($request->exists('fax_no') && is_null($request->input('fax_no'))) {
                $input_arr['fax_no'] = $request->input('fax_no');
                $input_error_arr['fax_no'] =    'required';
                $validator = Validator::make($input_arr, $input_error_arr);

                if ($validator->fails()) {
                    return response()->json(array('status' => 'faxerror', 'message' => $validator->errors()->all()));
                }
            }
            if ($request->exists('fax_no') && !is_numeric($request->input('fax_no'))) {
                return response()->json(array('status' => 'faxErr', 'message' => "Please fill numeric values."));
            }

            /* For zip code is not blank */
            if ($request->exists('zip_code') && is_null($request->input('zip_code'))) {
                $input_arr['zip_code'] = $request->input('zip_code');
                $input_error_arr['zip_code'] =    'required';
                $validator = Validator::make($input_arr, $input_error_arr);

                if ($validator->fails()) {
                    return response()->json(array('status' => 'ziperror', 'message' => $validator->errors()->all()));
                }
            }
            if ($request->exists('zip_code') && !is_numeric($request->input('zip_code'))) {
                return response()->json(array('status' => 'zipErr', 'message' => "Please fill numeric values."));
            }

            if ($request->exists('address') && is_null($request->input('address'))) {
                $input_arr['address'] =         $request->input('address');
                $input_error_arr['address'] =    'required';
                $validator = Validator::make($input_arr, $input_error_arr);

                if ($validator->fails()) {
                    return response()->json(array('status' => 'addresserror', 'message' => $validator->errors()->all()));
                }
            }

            if ($request->exists('address2') && is_null($request->input('address2'))) {

                $input_arr['address2'] =         $request->input('address2');
                $input_error_arr['address2'] =    'required';

                $validator = Validator::make($input_arr, $input_error_arr);
                if ($validator->fails()) {
                    return response()->json(array('status' => 'addresserror2', 'message' => $validator->errors()->all()));
                }
            }

            if ($request->exists('name') &&  is_null($request->input('name'))) {

                $input_arr['Full Name'] =         $request->input('name');
                $input_error_arr['Full Name'] =    'required';
                $validator = Validator::make($input_arr, $input_error_arr);

                if ($validator->fails()) {
                    return response()->json(array('status' => 'nameerror', 'message' => $validator->errors()->all()));
                }
            }


            if ($request->input('type') == 'employment' && $request->input('post') && !empty($request->input('post'))) {

                $emplo = array();
                for ($i = 0; $i < count($request->input('post')); $i++) {

                    $emplo[] = array('post' => $request->input('post.' . $i), 'organization' => $request->input('organization.' . $i), 'from' => $request->input('from.' . $i), 'to' => $request->input('to.' . $i), 'description' => $request->input('description.' . $i));
                }

                $update[$request->input('type')] = json_encode($emplo);
            } else if ($request->input('type') == 'education' && $request->input('post') && !empty($request->input('post'))) {
                $emplo = array();
                for ($i = 0; $i < count($request->input('post')); $i++) {
                    $emplo[] = array('degree' => $request->input('post.' . $i), 'school' => $request->input('organization.' . $i), 'from' => $request->input('from.' . $i), 'to' => $request->input('to.' . $i), 'description' => $request->input('description.' . $i));
                }
                $update[$request->input('type')] = json_encode($emplo);
            } else {
                foreach ($request->all() as $key => $value) {
                    if ($key != 'id' && $key != '_token') :
                        $update[$key] = $value;
                        if ($key == 'skills' && !empty($value)) {
                            $update[$key] = implode(',', $value);
                        }
                    endif;
                }
            }

            $update['updated_at'] = Carbon::now()->toDateTimeString();
            $where['details_id'] = $request->input('id');
            $userdetails = new Userdetails;
            $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
            return response()->json(array('status' => $resutl, 'message' => ''));
        } else {
            return response()->json(array('status' => 'loginerorr', 'message' => '', 'url' => '/login?usertype=agent'));
        }
    }

    /*edit profiles*/
    public function editagentprofile(Request $request)
    {
        $agentDetails = DB::table('agents_users_details')->where('details_id', Auth::user()->id)->get();

        $user = new User;
        $where = $update = array();
        $rules = array(
            'state_id'                  => 'required',
            'city_id'                      => 'required',
            'licence_number'             => 'required',
            'years_of_expreience'         => 'required',
            'office_address'             => 'required',
            'brokers_name'                 => 'required',
            'terms_and_conditions'         => 'required',
        );
        if ($agentDetails[0]->contract_verification == 0) {
            if (!empty($request->file('statement_document'))) {
                $rules['statement_document'] = 'required|mimes:pdf|max:10000';
            } elseif (empty($request->file('statement_document')) && empty($request->input('statement_document_c'))) {
                $rules['statement_document'] = 'required|mimes:pdf|max:10000';
            }
        }
        $validator = Validator::make($request->all(), $rules, [
            'required' => 'The :attribute field is required',
            'years_of_expreience.required' => "The years of experience field is required"
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        foreach ($request->all() as $key => $value) {
            if ($key != 'id' && $key != '_token' && $key != 'statement_document' && $key != 'statement_document_c') :

                if (($key == 'area' || $key == 'zip_code') && !empty($value)) {
                    $update[$key] = rtrim(implode(',', $value), ',');
                } else {
                    $update[$key] = $value;
                }
            endif;
        }

        if (!empty($request->file('statement_document'))) {
            $statement = $request->file('statement_document');
            $pdffile = time() . '.' . $statement->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/agents_pdf/');
            $statement->move($destinationPath, $pdffile);
            $update['contract_verification'] = 1;
            $update['statement_document'] = url('/assets/img/agents_pdf/') . '/' . $pdffile;
            $userExits = $user->getDetailsByEmailOrId(array('id' => $request->input('id')));
            $emaildata['url']  = url('/agentadmin/agents/view/') . '/' . $userExits->id;
            $emaildata['name'] = ucwords($userExits->name);
            $emaildata['html'] = '<div><h3>Hello Admin,</h3><br><p>
				' . $emaildata['name'] . ' upload a statement document physically <a href="' . $update['statement_document'] . '">sign.pdf</a> .</p>
				<br>
				<p>Clcik <a href="' . $emaildata['url'] . '">here</a> and update this user status.</p><div>';

            Mail::send([], [], function ($message) use ($emaildata) {
                $message->to('92agent@92agents.com', 'kamlesh dhamndhiya')
                    ->subject($emaildata['name'] . ' Agents Statement document')
                    ->setBody($emaildata['html'], 'text/html');
                $message->from('92agent@92agents.com', '92agent@92agents.com');
            });
        } else {
            $update['statement_document'] = $request->input('statement_document_c');
        }

        $update['updated_at'] = Carbon::now()->toDateTimeString();
        $where['details_id'] = $request->input('id');
        $userdetails = new Userdetails;
        $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
        return response()->json(["msg" => "Your Personal data has been updated successfully"]);
    }

    /*edit profiles*/
    public function editagentprofessionalprofile(Request $request)
    {

        $where = $update = array();
        $rules = array(
            'certifications'                   => 'required',
            'specialization'                   => 'required',
        );

        $messages = array();
        $arrayrile = array('degree', 'school', 'educationfrom', 'educationto', 'educationdescription', 'post', 'organization', 'experiencefrom', 'experienceto', 'experiencedescription', 'language', 'speak', 'read', 'write');

        $arrayrile[] = 'year';
        $arrayrile[] = 'sellers_represented';
        $arrayrile[] = 'buyers_represented';
        $arrayrile[] = 'total_dollar_sales';

        foreach ($arrayrile as $value) {
            if (empty($request->input($value)[0])) {
                $messages[$value][0] = $value . ' field is required.';
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails() || !empty($messages)) :
            return response()->json(['error' => array_merge($validator->errors()->messages(), $messages)]);
        endif;

        $notin = array('community_involvement', 'publications', 'associations_awards', 'id', '_token', 'degree', 'school', 'educationfrom', 'educationto', 'educationdescription', 'post', 'organization', 'experiencefrom', 'experienceto', 'experiencedescription', 'year', 'sellers_represented', 'buyers_represented', 'total_dollar_sales', 'language', 'speak', 'read', 'write');


        if ($request->input('degree') && !empty($request->input('degree'))) {

            $emplo = array();
            for ($i = 0; $i < count($request->input('degree')); $i++) {
                if (!empty($request->input('degree.' . $i)) && !empty($request->input('school.' . $i)) && !empty($request->input('educationfrom.' . $i)) && !empty($request->input('educationto.' . $i)) && !empty($request->input('educationdescription.' . $i))) {

                    $emplo[] = array('degree' => $request->input('degree.' . $i), 'school' => $request->input('school.' . $i), 'from' => $request->input('educationfrom.' . $i), 'to' => $request->input('educationto.' . $i), 'description' => $request->input('educationdescription.' . $i));
                }
            }
            $update['real_estate_education'] = json_encode($emplo);
        }

        if ($request->input('post') && !empty($request->input('post'))) {
            $emplo = array();
            for ($i = 0; $i < count($request->input('post')); $i++) {
                if (!empty($request->input('post.' . $i)) && !empty($request->input('organization.' . $i)) && !empty($request->input('experiencefrom.' . $i)) && !empty($request->input('experienceto.' . $i)) && !empty($request->input('experiencedescription.' . $i))) {

                    $emplo[] = array('post' => $request->input('post.' . $i), 'organization' => $request->input('organization.' . $i), 'from' => $request->input('experiencefrom.' . $i), 'to' => $request->input('experienceto.' . $i), 'description' => $request->input('experiencedescription.' . $i));
                }
            }
            $update['industry_experience']      = json_encode($emplo);
        }

        if ($request->input('year') && !empty($request->input('year'))) {
            $emplo = array();
            $total_sales = 0;
            for ($i = 0; $i < count($request->input('year')); $i++) {
                $total_sales = $total_sales + $request->input('total_dollar_sales.' . $i);
                if (!empty($request->input('year.' . $i)) && !empty($request->input('sellers_represented.' . $i)) && !empty($request->input('buyers_represented.' . $i)) && !empty($request->input('total_dollar_sales.' . $i))) {
                    $emplo[] = array('year' => $request->input('year.' . $i), 'sellers_represented' => $request->input('sellers_represented.' . $i), 'buyers_represented' => $request->input('buyers_represented.' . $i), 'total_dollar_sales' => $request->input('total_dollar_sales.' . $i));
                }
            }

            $update['total_sales'] = $total_sales;
            $update['sales_history'] = json_encode($emplo);
        }

        if ($request->input('language') && !empty($request->input('language'))) {
            $emplo = array();
            for ($i = 0; $i < count($request->input('language')); $i++) {
                if (!empty($request->input('language.' . $i)) && !empty($request->input('speak.' . $i)) && !empty($request->input('read.' . $i)) && !empty($request->input('write.' . $i))) {
                    $emplo[] = array('language' => $request->input('language.' . $i), 'speak' => $request->input('speak.' . $i), 'read' => $request->input('read.' . $i), 'write' => $request->input('write.' . $i));
                }
            }
            $update['language_proficiency'] = json_encode($emplo);
        }

        if ($request->input('associations_awards') && !empty($request->input('associations_awards'))) {
            $update['associations_awards'] = implode(",==,", array_filter($request->input('associations_awards')));
        }

        if ($request->input('publications') && !empty($request->input('publications'))) {
            $update['publications'] = implode(",==,", array_filter($request->input('publications')));
        }

        if ($request->input('community_involvement') && !empty($request->input('community_involvement'))) {

            $update['community_involvement'] = implode(",==,", array_filter($request->input('community_involvement')));
        }

        $update['show_individual_yearly_figures'] = '0';
        foreach ($request->all() as $key => $value) {

            if (!in_array($key, $notin)) :
                if ($key == 'certifications' && !empty($value)) {
                    $update[$key] = rtrim(implode(',', $value), ',');
                } else
					if ($key == 'specialization' && !empty($value)) {
                    $update[$key] = rtrim(implode(',', $value), ',');
                } else
					if ($key == 'show_individual_yearly_figures' && !empty($value)) {
                    if ($value == 'on') {

                        $update[$key] = '1';
                    } else {
                        $update[$key] = '0';
                    }
                } else {
                    $update[$key] = $value;
                }
            endif;
        }

        $update['updated_at'] = Carbon::now()->toDateTimeString();
        $where['details_id']  = $request->input('id');
        $userdetails = new Userdetails;
        $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
        return response()->json(["msg" => "Your Personal data has been updated successfully"]);
    }

    /* Edit profile pic */
    public function editprofilepic(Request $request)
    {

        if (Auth::user()) {
            $input_arr = $input_error_arr = $where = $update = array();
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|image|max:2000',
            ], ['image.max' => 'Image should be less then 2MB.']);

            $image = $request->file('image');
            $update['photo'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/profile/');
            $image->move($destinationPath, $update['photo']);
            $where['details_id'] = $request->input('id');
            $userdetails = new Userdetails;
            $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
            return response()->json(array('status' => $resutl, 'message' => $destinationPath));
        } else {
            return response()->json(array('status' => 'loginerorr', 'message' => '', 'url' => '/login?usertype=agent'));
        }
    }

    /*agent settings*/
    public function agentsettings(Request $request)
    {
        if (Auth::user()) {
            $state = new State;
            $user1 = new User;
            $view = array();
            $view['user']                  = $user = Auth::user();
            $userDetails = $user1->getuserdetailsByAny(array('agents_users_details.details_id' => $user->id));
            $view['userdetails'] = $userDetails;

            $user_city     = $state->getCityByAny(array('is_deleted' => '0', 'city_id' => $userDetails->city_id));
            $view['oldCityId'] = $user_city[0]->city_id;
            $view['oldCityName'] = $user_city[0]->city_name;
            $view['oldCityStateId'] = $user_city[0]->state_id;


            $view['securty_questio']     = DB::table('agents_securty_question')
                ->where('is_deleted', '0')->where('status', '1')->get();
            $view['securty_questio_count'] = $securty_questio_count = DB::table('agents_securty_question')->where('is_deleted', '0')->where('status', '1')->get()->count();
            // if($securty_questio_count % 2 == 0){
            //        $view['securty_questio_one'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->limit($securty_questio_count/2)->get();
            //        $view['securty_questio_two'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->offset($securty_questio_count/2)->limit($securty_questio_count)->get();
            //    }
            //    else{
            //        $view['securty_questio_one'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->limit($securty_questio_count+1/2)->get();
            //        $view['securty_questio_two'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->offset($securty_questio_count+1/2)->limit($securty_questio_count)->get();
            //    }

            //dd($view['securty_questio']);
            if ($view['user']->agents_users_role_id == 2) {
                $view['types'] = 'Buy';
            } else {
                $view['types'] = 'Sell';
            }

            $view['editfield']             = '<a class="pull-right profile-edit-button field-edit"><i class="fa fa-pencil"></i></a>';
            $view['segment'] = $request->segments();
            return view('dashboard.user.agents.settings', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /*buyer settings*/

    public function buyersettings(Request $request)
    {

        if (Auth::user()) {
            $state = new State;
            $user1 = new User;
            $view = array();
            $view['user'] = $user = Auth::user();
            $userDetails = $user1->getuserdetailsByAny(array('agents_users_details.details_id' => $user->id));
            // dd($userDetails);
            $view['userdetails'] = $userDetails;
            
            $view['state']     = $state->getStateByAny(array('is_deleted' => '0', 'status' => '1'));
            $view['city']     = $state->getCityByAny(array('is_deleted' => '0'));
            $user_city     = $state->getCityByAny(array('is_deleted' => '0', 'city_id' => $userDetails->city_id));
            $view['oldCityId'] = $user_city[0]->city_id;
            $view['oldCityName'] = $user_city[0]->city_name;
            $view['oldCityStateId'] = $user_city[0]->state_id;

            $view['editfield']      = '<a class="pull-right field-edit"><i class="fa fa-pencil"></i></a>';

            $view['securty_questio'] = DB::table('agents_securty_question')->where('is_deleted', '0')->where('status', '1')->get();
            $view['securty_questio_count'] = $securty_questio_count = DB::table('agents_securty_question')->where('is_deleted', '0')->where('status', '1')->get()->count();
            // if($securty_questio_count % 2 == 0){

            //        $view['securty_questio_one'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->limit($securty_questio_count/2)->get();
            //        $view['securty_questio_two'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->offset($securty_questio_count/2)->limit($securty_questio_count)->get();
            //    }
            //    else{
            //        $view['securty_questio_one'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->limit($securty_questio_count+1/2)->get();
            //        $view['securty_questio_two'] = DB::table('agents_securty_question')->where('is_deleted','0')->where('status','1')->offset($securty_questio_count+1/2)->limit($securty_questio_count)->get();
            //    }

            if ($view['user']->agents_users_role_id == 2) {
                $view['types'] = 'Buy';
            } else {
                $view['types'] = 'Sell';
            }

            $view['segment'] = $request->segments();
            return view('dashboard.user.buyers.settings', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    public function getQuestions($id)
    {
        $securty_questio = DB::table('agents_securty_question')
            ->where('is_deleted', '=', '0')
            ->where('status', '=', '1')
            ->where('securty_question_id', '!=', $id)
            ->get();
        //dd($securty_questio);
        if (!empty($securty_questio)) {
            echo  json_encode($securty_questio);
            exit;
        }
    }


    /*Edit buyer profile*/
    public function editbuyerprofile(Request $request)
    {
        $where = $update = array();
        $rules = array(
            'address'              => 'required',
            'address2'          => 'required',
            'city_id'              => 'required',
            'state_id'          => 'required',
            //'fax_no'            => 'required',
            'zip_code'          => 'required',
            // 'need_Cash_back' 	=> 'required',
            'description'         => 'required',
        );

        $validator = Validator::make($request->all(), $rules, [
            'address.required' => 'The address line field is required.',
            'address2.required' => 'The address line 2 field is required.'
        ]);

        if ($validator->fails()) :
            return response()->json(['error' => $validator->errors()]);
        endif;
        foreach ($request->all() as $key => $value) {
            if ($key != 'id' && $key != 'role_id' && $key != '_token') :
                $update[$key] = $value;

            // if($key=='zip_code' && !empty($value)){
            //$update[$key] = rtrim(implode(',', $value),',');
            // }else{
            // $update[$key] = $value;
            // }
            endif;
        }

        $update['updated_at'] = Carbon::now()->toDateTimeString();
        $where['details_id'] = $request->input('id');
        $userdetails = new Userdetails;

        $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
        return response()->json(["msg" => "Your Personal data has been updated successfully"]);
    }


    /* change password */
    public function changepassword(Request $request)
    {
        $admin_user = auth()->guard('admin')->user();

        $rules = array(
            'oldpassword'              => 'required',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|required_with:password|min:6'
        );

        //password update.
        $oldpassword               = $request->input('oldpassword');
        $password                   = $request->input('password');
        $passwordconf           = $request->input('password_confirmation');
        $messages = array(
            "password.required_with" => "Password and Confirm Password Does Not Match",
            "oldpassword.required" => "Old password is required",
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()]);
        } elseif (Hash::check($oldpassword, $admin_user->password)) {

            //return response()->json(["msg" 	=> $	]);

            $admin_user->fill([
                'password' => Hash::make(request()->input('password'))
            ])->save();
            $user = $admin_user;
            $input_arr['toemail'] = $user->email;
            //$input_arr['toemail'] = "dilip.owlok@gmail.com";
            $input_arr['name'] = $user->name;
            Mail::send('email.changepassword', $input_arr, function ($message) use ($input_arr) {
                $message->to($input_arr['toemail'], $input_arr['name'])
                    ->subject('Change password');
                $message->from("92agent@92agents.com", "92Agents");
            });

            return response()->json(["msg"     => "Password updated successfully"]);
        } else {
            return response()->json(["error"     => array('oldpassword' => array('0' => 'Old password is incorrect.'))]);
        }
    }

    /* post title for buyer and seller */
    public function updateposttitle(Request $request)
    {
        $rules = array(
            'posttitle'         => 'required'
        );
        //password update.
        $posttitle  = $request->input('posttitle');
        $validator     = Validator::make(array('posttitle'    =>    $request->input('posttitle')),    $rules);
        if ($validator->fails()) {
            return response()->json(['error'    => $validator->errors()]);
        } else {
            $post =  new Post;
            $postdetails = $post->getDetailsByUserroleandId($request->input('agents_user_id'), $request->input('agents_users_role_id'));

            if (empty($postdetails)) {
                $postdetailsnew = array();
                $postdetailsnew['agents_user_id'] = $request->input('agents_user_id');
                $postdetailsnew['agents_users_role_id'] = $request->input('agents_users_role_id');
                $postdetailsnew['posttitle'] = $request->input('posttitle');
                DB::table('agents_posts')->insertGetId($postdetailsnew);
            } else {
                $postdetails = Post::find($postdetails->post_id);
                $postdetails->posttitle = $request->input('posttitle');
                $postdetails->updated_at = Carbon::now()->toDateTimeString();
                $postdetails->save();
            }
            return response()->json(["msg" => "Your post details successfully insert!"]);
        }
    }

    /*securtyquestion*/
    public function securtyquestion(Request $request)
    {

        $rules = array(
            'question1'    => 'required',
            'answer1'      => 'required',
            'question2'    => 'required',
            'answer2'      => 'required',
        );

        $validator = Validator::make(array(
            'question1'    => $request->input('question1'),
            'answer1'    => $request->input('answer1'),
            'question2'    => $request->input('question2'),
            'answer2'    => $request->input('answer2'),
        ), $rules, [
            'answer1.required' => 'The answer 1 field is required.',
            'answer2.required' => 'The answer 2 field is required.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {

            $user = User::find($request->input('id'));
            $user->first_login = 2;
            $user->save();
            $postdetails                 = Userdetails::find($request->input('id'));
            $postdetails->question_1    = $request->input('question1');
            $postdetails->answer_1      = $request->input('answer1');
            $postdetails->question_2    = $request->input('question2');
            $postdetails->answer_2      = $request->input('answer2');
            $postdetails->updated_at     = Carbon::now()->toDateTimeString();
            if ($postdetails->save()) {
                return response()->json(["msg" => "Security Questions updated successfully"]);
            } else {
                return response()->json(["msg" => array('error' => 'Please try again in a few minutes.')]);
            }
        }
    }

    /* For agent personal bio */
    public function resume(Request $request)
    {

        if (Auth::user()) {
            $view = array();
            $view['user']          = $user         = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['segment'] = $request->segments();

            return view('dashboard.user.agents.resume', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* For agets questions */
    public function agentsquestions(Request $request)
    {
        if (Auth::user()) {
            $view = array();
            $view['user']          = $user         = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['segment'] = $request->segments();
            return view('dashboard.user.agents.questions', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* For buyer questions */
    public function buyerquestions(Request $request)
    {

        if (Auth::user()) {
            $view = array();
            $view['user']          = $user         = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['segment']     = $request->segments();
            return view('dashboard.user.buyers.questions', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* For state */
    public function state()
    {
        $state = new State;
        return response()->json($state->getStateByAny(array('is_deleted' => '0', 'status' => '1')));
    }

    /* For get city */
    public function city($state_id = null)
    {
        $state = new State;
        if ($state_id != null) {
            // return response()->json($state->getCityByAny(array('is_deleted' => '0')));
            return response()->json($state->getCityByState(array('is_deleted' => '0', 'state_id' => $state_id)));
        } else {
            return response()->json($state->getCityByAny(array('is_deleted' => '0')));
        }
    }

    /* For get area */
    public function area()
    {
        $state = new State;
        return response()->json($state->getAreaByAny(array('is_deleted' => '0', 'status' => '1')));
    }

    /* For certifications */
    public function certifications(Request $request, $id = null)
    {
        $userdetails = new Userdetails;
        $wherein = array();
        if ($request->input('certifications_id')) {
            $wherein['certifications_id'] = $request->input('certifications_id');
        }

        $where = array();
        if ($id != null) {
            $where['certifications_id'] = $id;
        }
        $where['is_deleted'] = '0';
        $where['status'] = '1';
        return response()->json($userdetails->getCertificationsByAny($where, $wherein));
    }

    /* specialization */
    public function specialization($id = null)
    {
        $userdetails = new Userdetails;
        $where = array();
        if ($id != null) {
            $where['skill_id'] = $id;
        }

        $where['is_deleted'] = '0';
        $where['status'] = '1';
        return response()->json($userdetails->getSpecializationByAny($where));
    }

    /* For franchisee */
    public function franchise($id = null)
    {
        $userdetails = new Userdetails;
        $where = array();
        if ($id != null) {
            $where['franchise_id'] = $id;
        }
        $where['is_deleted'] = '0';
        $where['status'] = '1';
        return response()->json($userdetails->getFranchiseByAny($where));
    }

    /* For get skills details  */
    public function skills(Request $request, $id = null)
    {
        $usk = new Agentskills;
        $where = array();
        if ($id != null) {
            $where['skill_id'] = $id;
        }
        $where['is_deleted'] = '0';
        $where['status'] = '1';
        $wherein = array();
        if ($request->input('skill_id')) {
            $wherein['skill_id'] = $request->input('skill_id');
        }
        return response()->json($usk->getskillsByAny($where, $wherein));
    }

    /* For check public connections */
    public function publicConnection(Request $request)
    {
        $uss = new User;
        $uss->usersconection(array('post_id' => $request->input('post_id'), 'to_id' => $request->input('to_id'), 'to_role' => $request->input('to_role'), 'from_id' => $request->input('from_id'), 'from_role' => $request->input('from_role')));
    }

    /* For get public user */
    public function publicUserGet($id = null, $role = null)
    {

        $uss = new User;
        $result = $uss->getDetailsByEmailOrId(array('role_id' => $role, 'id' => $id));
        return response()
            ->json($result);
    }


    /* For applied post for agents */
    public function AppliedPostForAgents()
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $invoice_details = DB::table('agents_selldetails as as')
                ->join('agents_posts as ap', 'as.post_id', '=', 'ap.post_id')
                ->select(
                    'as.sellers_name', 
                    'as.id', 
                    'as.address', 
                    'as.payment_status', 
                    'as.receipt_url', 
                    'as.sale_date', 
                    'as.sale_price',
                    'ap.posttitle'
                )
                ->where(['ap.applied_user_id' => $user->id, 'as.status' => 1])
                ->get();

            $view['invoice_details'] = $invoice_details;
            return view('dashboard.user.agents.appliedpost', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* For connected jobs for agents */
    public function ConnectedJobsForAgents()
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            return view('dashboard.user.agents.connectedjobs', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* get applied post list for agents */
    public function AppliedPostListGetForAgents($limit, $userid, $roleid, $selected = null, $user_role_id = null)
    {

        $post = new Post;
        $result = $post->AppliedPostListGetForAgents($limit, array('agents_users_conections.to_id' => $userid, 'agents_users_conections.to_role' => $roleid, 'agents_posts.agents_users_role_id' =>  $user_role_id), array('agents_users_conections.from_id' => $userid, 'agents_users_conections.from_role' => $roleid, 'agents_posts.agents_users_role_id' =>  $user_role_id), $selected);
        return response()->json($result);
    }



    /* For proposal */
    public function proposal()
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            return view('dashboard.user.agents.proposal', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* For get document info */
    public function documents()
    {
        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            if ($user->agents_users_role_id == 4) :
                return view('dashboard.user.agents.document', $view);
            else :
                return view('dashboard.user.buyers.document', $view);
            endif;
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_i));
        }
    }

    /* For contract details*/
    public function contract()
    {
        // $file="./download/info.pdf";
        //return Response::download("http://www.92agents.com/assets/img/agents_pdf/1536050674.pdf");
        $file = public_path() . "/assets/img/agents_pdf/1536050674.pdf";
        $headers = array(
            'Content-Type: application/pdf',
        );
        //echo public_path(); exit;
        // Response::
        return $response = FacadeResponse::download($file, 'contract.pdf', $headers);
    }
}
