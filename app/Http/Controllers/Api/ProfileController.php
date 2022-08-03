<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\Post;
use App\Models\SecurtyQuestion;
use App\Models\State;
use App\Models\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class ProfileController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function agent(Request $request)
    {
        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::with(['city', 'state'])->where('details_id', '=', $view['user']->id)->first();
            $view['state_and_city'] = State::with('stateAndCity')->get();
            $skillsarray = explode(',', $view['userdetails']->skills);
            $view['userdetails']->skills = DB::table('agents_users_agent_skills')
                ->whereIn('skill_id', $skillsarray)
                ->get();

            $view['agentskills'] = DB::table('agents_users_agent_skills')->get();
            $proposals = app('App\Http\Controllers\Api\ProposalsController')->show('0', Auth::user()->id, '4');
            $documents = app('App\Http\Controllers\Administrator\UploadAndShareController')->show('0', Auth::user()->id, '4');
            $view['proposals'] = $proposals->original['result'];
            $view['documents'] = $documents->original['result'];
            $photo = $view['userdetails']->photo;
            if (!empty($photo)) {
                $url = url('/assets/img/profile/' . $photo);
            } else {
                $url = "";
            }
            $view['userdetails']->photo = $url;
            $view['userdetails']->education = json_decode($view['userdetails']->education);
            $view['userdetails']->employment = json_decode($view['userdetails']->employment);
            $string = strip_tags($view['userdetails']->description);
            $string = preg_replace('/\s+/', ' ', trim($string));
            $string = str_replace("&nbsp;", "", $string);
            $view['userdetails']->description = $string;
            return response()->json(array('status' => '100', 'response' => $view));
        } else {
            return response()->json(array('status' => '101', 'response' => 'No data available'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */

    public function buyer(Request $request)
    {
        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::with(['city', 'state'])->where('details_id', '=', $view['user']->id)->first();
            $view['state_and_city'] = State::with('stateAndCity')->get();
            $photo = $view['userdetails']->photo;
            if (!empty($photo)) {
                $url = url('/assets/img/profile/' . $photo);
            } else {
                $url = "";
            }
            $view['userdetails']->photo = $url;
            $string = strip_tags($view['userdetails']->description);
            $string = preg_replace('/\s+/', ' ', trim($string));
            $string = str_replace("&nbsp;", "", $string);
            $view['userdetails']->description = $string;
            return response()->json(array('status' => '100', 'response' => $view));
        } else {
            return response()->json(array('status' => '101', 'response' => 'No Data Available'));
        }
    }


    /* For edit fields */
    public function editFields(Request $request)
    {
        if (Auth::user()) {
            $input_arr = $input_error_arr = $where = $update = array();
            if ($request->input('name') && empty($request->input('name'))) {
                $input_arr['Full Name']  =  $request->input('name');
                $input_error_arr['name'] =  'required';
                $validator = Validator::make($input_arr, $input_error_arr);
                if ($validator->fails()) {
                    return response()->json(array('status' => 'nameerror', 'message' => $validator->errors()->all()));
                } else {
                    foreach ($request->all() as $key => $value) {
                        if ($key != 'id' && $key != '_token') :
                            $update[$key] = $value;
                            if ($key == 'skills' && empty($value)) {
                                $update[$key] = implode(',', $value);
                            }
                        endif;
                    }
                }
            }
            // if($request->input('name')){
            //     if($request->input('name') == '' && empty($request->input('name')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Name field is empty.') );
            //     }
            // }
            foreach ($request->all() as $key => $value) {
                if ($key != 'id' && $key != '_token') :
                    $update[$key] = $value;
                    if ($key == 'skills' && empty($value)) {
                        $update[$key] = implode(',', $value);
                    }
                endif;
            }
            if ($request->exists('name')) {
                //echo "I am working";exit;
                if ($request->input('name') == '') {
                    return response()->json(array('status' => '101', 'message' => 'Name field is empty.'));
                }
            }
            // if($request->input('description')){
            //     if( $request->input('description') == '' && empty($request->input('description')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Description field is empty.') );
            //     }
            // }
            if ($request->exists('description')) {
                //echo "I am working";exit;
                if ($request->input('description') == '') {
                    return response()->json(array('status' => '101', 'message' => 'Description field is empty.'));
                }
            } else {
                //print_r($request->input());exit;
                if ($request->exists('address')) {
                    //echo "I am working";exit;
                    if ($request->input('address') == '') {
                        return response()->json(array('status' => '101', 'message' => 'Address field is empty.'));
                    }
                }

                if ($request->exists('address2')) {
                    //echo "I am working";exit;
                    if ($request->input('address2') == '') {
                        return response()->json(array('status' => '101', 'message' => 'address2 field is empty.'));
                    }
                }

                if ($request->exists('city_id')) {
                    //echo "I am working";exit;
                    if ($request->input('city_id') == '') {
                        return response()->json(array('status' => '101', 'message' => 'City field is empty.'));
                    }
                }

                if ($request->exists('state_id')) {
                    //echo "I am working";exit;
                    if ($request->input('state_id') == '') {
                        return response()->json(array('status' => '101', 'message' => 'State field is empty.'));
                    }
                }
                if ($request->exists('phone')) {
                    //echo "I am working";exit;
                    if ($request->input('phone') == '') {
                        return response()->json(array('status' => '101', 'message' => 'Phone field is empty.'));
                    }
                }
                if ($request->exists('phone_home')) {
                    //echo "I am working";exit;
                    if ($request->input('phone_home') == '') {
                        return response()->json(array('status' => '101', 'message' => 'Home phone field is empty.'));
                    }
                }
                if ($request->exists('phone_work')) {
                    //echo "I am working";exit;
                    if ($request->input('phone_work') == '') {
                        return response()->json(array('status' => '101', 'message' => 'Work phone field is empty.'));
                    }
                }

                if ($request->exists('fax_no')) {
                    //echo "I am working";exit;
                    if ($request->input('fax_no') == '') {
                        return response()->json(array('status' => '101', 'message' => 'Fax field is empty.'));
                    }
                }
                if ($request->exists('zip_code')) {
                    //echo "I am working";exit;
                    if ($request->input('zip_code') == '') {
                        return response()->json(array('status' => '101', 'message' => 'Zip code field is empty.'));
                    }
                }
            }

            $update['updated_at'] = Carbon::now()->toDateTimeString();
            $where['details_id'] = $request->input('id');
            $userdetails = new Userdetails;
            //dd($update);
            $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
            return response()->json(array('status' => '100', 'message' => 'Updated successfully.'));
        } else {
            return response()->json(array('status' => '101', 'message' => 'Error while updating data.'));
        }
    }

    /**
     * edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function editFields(Request $request){
        if(Auth::user()){
            $input_arr = $input_error_arr = $where = $update = array();
            if( $request->input('name') && empty( $request->input('name') ) ):
            $input_arr['Full Name'] = 		$request->input('name');
            $input_error_arr['Full Name'] =	'required';
            $validator = Validator::make( $input_arr,$input_error_arr );

            if( $validator->fails() ):
                return response()->json( array( 'status' => 'nameerror','message' => $validator->errors()->all() ) );
            endif;
            endif;
            //echo '<pre>'; print_r($request->input('employment')); echo '</pre>';exit;
            if($request->input('type') == 'employment' && $request->input('employment') && !empty($request->input('employment'))){
            	if($request->input('type') == '' || $request->input('employment') == ''){
            		return response()->json( array('status' =>'101','response' => 'Employment/Type field is empty.') );
            	}else{
            		$update[$request->input('type')] = $request->input('employment');
            	}

            }else if($request->input('type')=='education' && $request->input('education') && !empty($request->input('education'))){
		if($request->input('type') == '' || $request->input('employment') == ''){
            		return response()->json( array('status' =>'101','response' => 'Education/Type field is empty.') );
            	}else{
            		$update[$request->input('type')] = $request->input('education');
            	}
            }else{
            	foreach ($request->all() as $key => $value) {

                    if($key != 'id' && $key != '_token'):

                        $update[$key] = $value;

                    if($key=='skills' && !empty($value)){
                        $update[$key] = implode(',', $value);
                    }
                    endif;
                }
            }
            $update['updated_at'] = Carbon::now()->toDateTimeString();
            $where['details_id'] = $request->input('id');
            $userdetails = new Userdetails;
            $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
            return response()->json( array('status' =>'100','response' => 'updated') );
        }else{
            return response()->json( array('status' => '101','response' => 'error') );
        }
    }*/
    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editagentprofile(Request $request)
    {
        $user = new User;
        $where = $update = array();
        $rules = array(
            'state_id'                  => 'required',
            'city_id'                      => 'required',
            'licence_number'         => 'required',
            'years_of_expreience'         => 'required',
            'office_address'         => 'required',
            'brokers_name'             => 'required',
            'terms_and_conditions'         => 'required',
        );
        if (!empty($request->file('statement_document'))) {
            $rules['statement_document'] = 'required|mimes:pdf|max:10000';
        } elseif (empty($request->file('statement_document')) && empty($request->input('statement_document_c'))) {
            $rules['statement_document'] = 'required|mimes:pdf|max:10000';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('status' => '101', 'message' => $validator->errors()));
        }
        foreach ($request->all() as $key => $value) {
            if ($key != 'id' && $key != '_token' && $key != 'statement_document' && $key != 'statement_document_c') :
                $update[$key] = $value;
            endif;
        }

        if (!empty($request->file('statement_document'))) {
            $statement = $request->file('statement_document');
            $pdffile = time() . '.' . $statement->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/agents_pdf/');
            $statement->move($destinationPath, $pdffile);
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
        return response()->json(array('status' => '100', 'message' => 'Your personal bio has been update successfully!'));
    }
    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editagentprofessionalprofile(Request $request)
    {
        $where = $update = array();
        $notin = array('community_involvement', 'publications', 'associations_awards', 'id', '_token', 'degree', 'school', 'educationfrom', 'educationto', 'educationdescription', 'post', 'organization', 'experiencefrom', 'experienceto', 'experiencedescription', 'year', 'sellers_represented', 'buyers_represented', 'total_dollar_sales', 'language', 'speak', 'read', 'write');

        if ($request->input('real_estate_education') && !empty($request->input('real_estate_education'))) {

            $update['real_estate_education'] = $request->input('real_estate_education');
        }
        if ($request->input('industry_experience') && !empty($request->input('industry_experience'))) {
            $update['industry_experience']      = $request->input('industry_experience');
        }
        if ($request->input('year') && !empty($request->input('year'))) {
            $update['sales_history'] = $request->input('sales_history');
        }
        if ($request->input('language') && !empty($request->input('language'))) {

            $update['language_proficiency'] = $request->input('language');
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
        $update['certifications'] = $request->input('certifications');
        $update['specialization'] = $request->input('specialization');
        $update['associations_awards'] = $request->input('associations_awards');
        $update['publications'] = $request->input('publications');
        $update['community_involvement'] = $request->input('community_involvement');
        $update['additional_details'] = $request->input('additional_details');

        $update['updated_at'] = Carbon::now()->toDateTimeString();
        //echo '<pre>'; print_r($update); echo '</pre>';exit;
        $where['details_id']  = $request->input('id');
        $userdetails = new Userdetails;
        $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
        return response()->json(["status" => "100", "message" => "Your Professional bio has been update successfully!"]);
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editprofilepic(Request $request)
    {
        /*$res=array(
                            'status'=>'101',
                            'message'=>'Failure',
                        );
                        return response()->json($res);  */

        if (Auth::user()) {
            $input_arr = $input_error_arr = $where = $update = array();
            $validations = [
                /*'image' => 'required|mimes:jpeg,png,jpg,gif,svg|image|max:2000',
                    	'image.max' => 'Image should be less then 2MB.'*/];
            $validator = Validator::make($request->all(), $validations);
            if ($validator->fails()) {
                $res = array(
                    'status' => '101',
                    'message' => 'Failure',
                    'errors' => $validator->errors()
                );
                return response()->json($res);
            }

            $user = Auth::user();

            $image = $request->file('image');
            $update['photo'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/profile/');
            $image->move($destinationPath, $update['photo']);
            $where['details_id'] = $user->id;
            $userdetails = new Userdetails;
            $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
            $url = url('/assets/img/profile/' . $update['photo']);

            return response()->json(array('status' => '100', 'response' => $url, 'message' => 'Uploaded Successfully'));
        } else {
            return response()->json(array('status' => '101', 'error' => "error"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function agentsettings(Request $request)
    {
        if (Auth::user()) {

            $state = new State;
            $user1 = new User;

            $view = array();
            $view['user']                  = $user = Auth::user();
            $view['userdetails']         = $user1->getuserdetailsByAny(array('agents_users_details.details_id' => $user->id));
            $view['securty_questio']     = DB::table('agents_securty_question')->where('is_deleted', '0')->get();
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
            $view['user']          = $user         = Auth::user();
            $view['userdetails'] = $user1->getuserdetailsByAny(array('agents_users_details.details_id' => $user->id));
            $view['state']                 = $state->getStateByAny(array('is_deleted' => '0'));
            $view['city']                 = $state->getCityByAny(array('is_deleted' => '0'));

            $view['securty_questio'] = DB::table('agents_securty_question')->where('is_deleted', '0')->get();

            return response()->json(array('status' => '100', 'response' => $view));
        } else {
            return response()->json(array('status' => '101', 'response' => 'error'));
        }
    }

    /*Edit buyer profile*/
    public function editbuyerprofile(Request $request)
    {
        $where = $update = array();

        $rules = array(
            'address'              => 'required',
            'city_id'              => 'required',
            'state_id'          => 'required',
            'zip_code'          => 'required',
            // 'need_Cash_back' 	=> 'required',
            'description'         => 'required',
        );


        $validator = Validator::make($request->all(), $rules);

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
        $rules = array(
            'oldpassword'              => 'required',
            'password'              => 'required|min:5|confirmed',
            'password_confirmation' => 'required|required_with:password|min:5'
        );

        $oldpassword               = $request->input('oldpassword');
        $password                   = $request->input('password');
        $passwordconf           = $request->input('password_confirmation');
        $messages = array(
            "password.required_with" => "Password and Confirm Password Does Not Match",
            "oldpassword.required" => "The old Password is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => '101', 'error' => $validator->errors()]);
        } elseif (Hash::check($oldpassword, Auth::user()->password)) {


            request()->user()->fill([
                'password' => Hash::make(request()->input('password'))
            ])->save();
            return response()->json(["status" => "100", "response"     => "Your password has been changed successfully!"]);
        } else {
            return response()->json(["status" => "101", "error"     => " Old password incorrect."]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateposttitle(Request $request)
    {
        $rules = array(
            'posttitle'         => 'required'
        );
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

    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
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
        ), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $user = User::find($request->input('id'));
            $user->first_login = 2;
            $user->save();
            $postdetails                  = Userdetails::find($request->input('id'));
            $postdetails->question_1    = $request->input('question1');
            $postdetails->answer_1      = $request->input('answer1');
            $postdetails->question_2    = $request->input('question2');
            $postdetails->answer_2      = $request->input('answer2');
            $postdetails->updated_at      = Carbon::now()->toDateTimeString();
            if ($postdetails->save()) {

                return response()->json(["status" => "100", "response" => "Security message has been successfully updated."]);
            } else {

                return response()->json(["status" => "100", "response" => 'Please try again in a few minutes.']);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function resume(Request $request)
    {
        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);



            $view['userdetails']->real_estate_education = json_decode($view['userdetails']->real_estate_education);
            $view['userdetails']->industry_experience = json_decode($view['userdetails']->industry_experience);
            $view['userdetails']->language_proficiency = json_decode($view['userdetails']->language_proficiency);
            $view['userdetails']->education = json_decode($view['userdetails']->education);
            $view['userdetails']->employment = json_decode($view['userdetails']->employment);
            $view['userdetails']->sales_history = json_decode($view['userdetails']->sales_history);

            $view['agentcertifications'] = DB::table('agents_certifications')->get();
            $view['agentspecializations'] = DB::table('agents_users_agent_skills')->get();
            //echo '<pre>'; print_r($view); exit;
            $view['segment'] = $request->segments();
            return response()->json(['status' => '100', 'response' => $view]);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }


    /* get list of franchise */
    public function franchise($id = null)
    {
        $userdetails = new Userdetails;
        $where = array();
        if ($id != null) {
            $where['franchise_id'] = $id;
        }
        $where['is_deleted'] = '0';
        return response()->json(['status' => '100', 'response' => $userdetails->getFranchiseByAny($where)]);
    }

    public function publicConnection(Request $request)
    {
        $uss = new User;
        $uss->usersconection(array('post_id' => $request->input('post_id'), 'to_id' => $request->input('to_id'), 'to_role' => $request->input('to_role'), 'from_id' => $request->input('from_id'), 'from_role' => $request->input('from_role')));
    }

    /* get applied posts for agent  */
    public function AppliedPostListGetForAgents(Request $request)
    {
        $limit = '0';
        $userid = $request->input('agents_user_id');
        $roleid = $request->input('agents_users_role_id');
        $selected = $request->input('selected');
        $post = new Post;
        $result = $post->AppliedPostListGetForAgents($limit, array('agents_users_conections.to_id' => $userid, 'agents_users_conections.to_role' => $roleid), array('agents_users_conections.from_id' => $userid, 'agents_users_conections.from_role' => $roleid), $selected);
        return response()->json(['status' => '100', 'posts' => $result['result']]);
    }
}
