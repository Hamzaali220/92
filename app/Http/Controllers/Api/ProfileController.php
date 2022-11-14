<?php

namespace App\Http\Controllers\Api;
use App\Events\eventTrigger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\Notification;
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

    public function editFieldsbio(Request $request)
    {
        if (Auth::user()) {
            $input_arr = $input_error_arr = $where = $update = array();
           
                
                
            
            // if($request->input('name')){
            //     if($request->input('name') == '' && empty($request->input('name')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Name field is empty.') );
            //     }
            // }
            
            // if($request->input('description')){
            //     if( $request->input('description') == '' && empty($request->input('description')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Description field is empty.') );
            //     }
            // }
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
                
            
                $update['address']        =   $request->input('address');
                $update['address2']       =   $request->input('address2');
                $update['city_id']       =   $request->input('city_id');
                $update['state_id']       =   $request->input('state_id');
            $update['updated_at'] = Carbon::now()->toDateTimeString();
            $where['details_id'] = $request->input('id');
            $userdetails = new Userdetails;
            //dd($update);
            $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
            return response()->json(array('status' => '100', 'message' => 'Updated successfully.', 'data'=>$resutl));
        } else {
            return response()->json(array('status' => '101', 'message' => 'Error while updating data.'));
        }
    }

    public function profilesettings(Request $request)
    {
        if (Auth::user()) {
            $input_arr = $input_error_arr = $where = $update = array();
           
                
                
            
            // if($request->input('name')){
            //     if($request->input('name') == '' && empty($request->input('name')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Name field is empty.') );
            //     }
            // }
            
            // if($request->input('description')){
            //     if( $request->input('description') == '' && empty($request->input('description')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Description field is empty.') );
            //     }
            // }
              //print_r($request->input());exit;
                if ($request->exists('email')) {
                    //echo "I am working";exit;
                    if ($request->input('email') == '') {
                        return response()->json(array('status' => '101', 'message' => 'email field is empty.'));
                    }
                }
                if ($request->exists('fname')) {
                    //echo "I am working";exit;
                    if ($request->input('fname') == '') {
                        return response()->json(array('status' => '101', 'message' => 'Full Name field is empty.'));
                    }
                }
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
                
            
                $update['address']        =   $request->input('address');
                $update['address2']       =   $request->input('address2');
                $update['city_id']       =   $request->input('city_id');
                $update['state_id']       =   $request->input('state_id');
                $update['fname']       =   $request->input('fname');
                $input_arr['email']       =   $request->input('email');
            $update['updated_at'] = Carbon::now()->toDateTimeString();
            $where['details_id'] = $request->input('id');
            $where2['id'] = $request->input('id');
            $userdetails = new Userdetails;
            $userss = new User;
            //dd($update);
            $resutl2=$userss->inserupdate($input_arr,$where2);
            $resutl = $userdetails->EditFieldsUserdetailsModel($where, $update);
            return response()->json(array('status' => '100', 'message' => 'Updated successfully.', 'data'=>$resutl,'data2'=>$resutl2));
        } else {
            return response()->json(array('status' => '101', 'message' => 'Error while updating data.'));
        }
    }
    public function showbio(Request $request)
    {
        if (Auth::user()) {
            $input_arr = $input_error_arr = $where = $update = array();
           
                
                
            
            // if($request->input('name')){
            //     if($request->input('name') == '' && empty($request->input('name')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Name field is empty.') );
            //     }
            // }
            
            // if($request->input('description')){
            //     if( $request->input('description') == '' && empty($request->input('description')))
            //     {
            //         return response()->json( array('status' => '101','message' => 'Description field is empty.') );
            //     }
            // }
              //print_r($request->input());exit;
                // if ($request->exists('address')) {
                //     //echo "I am working";exit;
                //     if ($request->input('address') == '') {
                //         return response()->json(array('status' => '101', 'message' => 'Address field is empty.'));
                //     }
                // }

                // if ($request->exists('address2')) {
                //     //echo "I am working";exit;
                //     if ($request->input('address2') == '') {
                //         return response()->json(array('status' => '101', 'message' => 'address2 field is empty.'));
                //     }
                // }

                // if ($request->exists('city_id')) {
                //     //echo "I am working";exit;
                //     if ($request->input('city_id') == '') {
                //         return response()->json(array('status' => '101', 'message' => 'City field is empty.'));
                //     }
                // }

                // if ($request->exists('state_id')) {
                //     //echo "I am working";exit;
                //     if ($request->input('state_id') == '') {
                //         return response()->json(array('status' => '101', 'message' => 'State field is empty.'));
                //     }
                // }
                
            
               
            
            $userdetails = Userdetails::find($request->input('id'));
            $userdetails['address']=$userdetails->address;   
            $userdetails['address2']=$userdetails->address2;
            $userdetails['city']=$userdetails->state_id;
            $userdetails['state']=$userdetails->city_id ;
            //dd($update);
            return response()->json(array('status' => '100', 'message' => 'Personal Bio.', 'data'=>$userdetails));
        } else {
            return response()->json(array('status' => '101', 'message' => 'Error while getting data.'));
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
    public function getsecurityquestions(){
        $view['securty_questio'] = DB::table('agents_securty_question')->where('is_deleted', '0')->where('status', '1')->get();
        return response()->json(["status" => "100", "securityquestions" => $view]);
    }
    public function getUserDetails(Request $request){
        $rules = array(
            'id'    => 'required',
        );
        $validator = Validator::make(array(
            'id'    => $request->input('id'),
        ), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {

        $postdetails = Userdetails::find($request->input('id'));
        return response()->json(["status" => "100", "securityquestions" => $postdetails]);}
    }

    

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

    public function contactSend(Request $request){
        $input_arr= array(
                    'name'=>$request->input('name'),
                    'email'=>$request->input('email'),
                    'message'=>$request->input('message'),
                    'contactNo'=>$request->input('contactNo'),
                    'countrycode'=>$request->input('countrycode'),

            );
            $msg = 'Dear ,'.$request->input('name').'<br/>Your query has been successfully submitted. Our representative will contact you shortly.<br />Thanks for your interest.<br /><br /><br />Regards<br />92Agents.com';
            $acknowledgeMsgData= array(
                    'name'=>'Admin',
                    'email'=>'Support@92agents.com',
                    'message'=>$msg,
                    'receiver'=>$request->input('email')
            );
            $input_error_arr = array(
                    'name'=>'required',
                    'email'=>'required|email',
                    'message'=>'required',
                    // 'contactNo'=>'required|min:10|numeric',
                    // 'countrycode'=>'required',
            );

        $validator = Validator::make($input_arr,$input_error_arr);

        if($validator->fails()){
            return response()->json(['status' => '100', 'response' => $validator]);
        }else{
            //$input_arr['contactNo']=$request->input('contactNo');
            $input_arr['msg']=$request->input('message');
                /*Mail::send('email.contact', $input_arr, function($message) use ($input_arr) {
                    $message->to($input_arr['email'], $input_arr['name'])
                    ->subject('Contact us your 92Agents ');
                    $message->from('92agent@92agents.com','92Agents');
                });*/
                Mail::send('email.contact', $input_arr, function($message) use ($input_arr) {
                    $message->to('92agent@92agents.com','92Agents')
                    ->subject('Contact us your 92Agents');
                    $message->from($input_arr['email'], $input_arr['name']);
                });
                $acknowledgeMsgData['msg'] = $acknowledgeMsgData['message'];
                Mail::send('email.acknowledge', $acknowledgeMsgData, function($message) use ($acknowledgeMsgData) {
                    $message->to($acknowledgeMsgData['receiver'],'92Agents')
                    ->subject('Thanks to contact 92Agents');
                    //dd($message);
                    $message->from($acknowledgeMsgData['email'], $acknowledgeMsgData['name']);
                });
                return response()->json(['status' => '200', 'success'=>'Thank you! Your message has been sent successfully. We will contact you very soon!']);
                // return Redirect::back()->with('success','<h4><span class="glyphicon glyphicon-ok"></span> Thank you!</h4>Your message has been sent successfully. We will contact you very soon!');
        }
        
}



    // public function personalBio(Request $request)
    // {
    //     if (Auth::user()) {
    //         $view = array();
    //         $view['user'] = $user = Auth::user();
    //         $view['userdetails'] = $userdetails = Userdetails::find($user->id);



    //         // $view['userdetails']->real_estate_education = json_decode($view['userdetails']->real_estate_education);
    //         // $view['userdetails']->industry_experience = json_decode($view['userdetails']->industry_experience);
    //         // $view['userdetails']->language_proficiency = json_decode($view['userdetails']->language_proficiency);
    //         // $view['userdetails']->education = json_decode($view['userdetails']->education);
    //         // $view['userdetails']->employment = json_decode($view['userdetails']->employment);
    //         // $view['userdetails']->sales_history = json_decode($view['userdetails']->sales_history);

    //         $view['agentcertifications'] = DB::table('agents_certifications')->get();
    //         $view['agentspecializations'] = DB::table('agents_users_agent_skills')->get();
    //         //echo '<pre>'; print_r($view); exit;
    //         $view['segment'] = $request->segments();
    //         return response()->json(['status' => '100', 'response' => $view]);
    //     } else {
    //         return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
    //     }
    // }


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










    // public function postAgentPayment(Request $request)
    // {

    //     $response = [];
    //     $validator = Validator::make($request->all(), [
    //         'stripeToken' => 'required',
    //         'sell_ids' => 'required'
    //     ]);


    //     $input = $request->all();
    //     if ($validator->passes()) {
    //         $sell_ids = explode(',', $request->input('sell_ids'));
    //         # get the price of package
    //         $sell_details = DB::table('agents_selldetails')->select('*')->whereIn('id', $sell_ids)->get();
    //         $user =  Auth::user();
    //         $userdetails = Userdetails::find($user->id);

    //         if ($sell_details) {

    //             try {
    //                 $token = $_POST['stripeToken'];
    //                 $total_sell = 0;
    //                 foreach ($sell_details as $sell) {
    //                     $per_10 = $sell->sale_price * 10 / 100;
    //                     $per_10_03 = round($per_10 * 3 / 100, 2);
    //                     $total_sell += $per_10_03;
    //                 }

    //                 $payment_id = DB::table('agents_payment')->insertGetId(
    //                     [
    //                         'amount' => ($total_sell),
    //                         'discount' => '0',
    //                         'taxes' => '0',
    //                         'payment' => 'Stripe',
    //                         'user_id' => $user->id,
    //                         'stripeToken' => $token
    //                     ]
    //                 );


    //                 \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //                 // `source` is obtained with Stripe.js; see https://stripe.com/docs/payments/accept-a-payment-charges#web-create-token
    //                 $payment_response = \Stripe\Charge::create([
    //                     'amount' => ($total_sell * 100),
    //                     'currency' => 'inr',
    //                     'source' => $token,
    //                     'description' => 'Agent paid for sell'
    //                 ]);

    //                 if ($payment_response->status == 'succeeded') {
    //                     $payment_update_arr = array(
    //                         'transaction_id' => $payment_response->balance_transaction,
    //                         'stripe_order_no' => $payment_response->id,
    //                         'updated_at' => date('Y-m-d h:i:s')
    //                     );

    //                     #update payment details
    //                     $updates = DB::table('agents_payment')->where('payment_id', $payment_id)
    //                         ->update($payment_update_arr);
    //                     $sell_details_arr = array(
    //                         'payment_id' => $payment_id,
    //                         'receipt_url' => $payment_response->receipt_url,
    //                         'payment_status' => 1,
    //                         'updated_ts' => date('Y-m-d h:i:s')
    //                     );

    //                     $sell_updates = DB::table('agents_selldetails')->whereIn('id', $sell_ids)
    //                         ->update($sell_details_arr);


    //                     $response['status'] = 1;
    //                     $response['message'] = 'Payment has been completed successfully';
    //                     $response['receipt_url'] = $payment_response->receipt_url;
    //                 } else {
    //                     $response['status'] = 0;
    //                     $response['message'] = 'Payment Failed! Something went wrong';
    //                 }
    //             } catch (Exception $e) {
    //                 $response['status'] = 0;
    //                 $response['message'] = $e->getMessage();
    //             }
    //         } else {
    //             $response['status'] = 0;
    //             $response['message'] = 'Invalid input provided. Please try again';
    //         }
    //     } else {
    //         $response['status'] = 0;
    //         $response['message'] = 'Invalid inputs provided. Please try again';
    //     }

    //     $view['user'] = $user = Auth::user();
    //     $view['userdetails'] = $userdetails = Userdetails::find($user->id);
    //     $view['user_type'] = env('user_role_' . $user->agents_users_role_id);

    //     $view['status'] = $response['status'];
    //     $view['message'] = $response['message'];
    //     // $view['receipt_url'] = $response['receipt_url'];

    //     return view('dashboard.user.agents.payment-status', $view);
    // }




    public function paymentagents(Request $request)
    {
        $rules = array(
            'payment'              => 'required',
            // 'stripeToken'       => 'required',
            'post_id'           => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
            // return response()->json(['status' => '100', 'response' => $view]);
        }
        $payment = $request->input('payment');
        $user      =  Auth::user();
        $userdetails = Userdetails::find($user->id);
        $post      =  Post::find($request->input('post_id'));

        try{

            $stripe = new \Stripe\StripeClient(
                'sk_test_51KUW4BBOKSpISjU5dMtfnTMLz3NyFpykp1aPGS7BxVIDaGfL5rvOzo2j5yWehRH3LTLaZ7HCFA5H9g15MPSwVx4R00EMXZ0mrh'
              );
              $stripettoken=$stripe->tokens->create([
                'card' => [
                  'number' => $request->input('card_number'),
                  'exp_month' => $request->input('card_expiry_month'),
                  'exp_year' => $request->input('card_expiry_year'),
                  'cvc' => $request->input('cvc'),
                ],
              ]);
              
        }
        catch (\Exception $ex) {
            return response()->json(["tokenErrorCustom" => $ex->getMessage()]);
        }

        try {
            
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            // \Stripe\Stripe::setApiKey('sk_test_51KUW4BBOKSpISjU5dMtfnTMLz3NyFpykp1aPGS7BxVIDaGfL5rvOzo2j5yWehRH3LTLaZ7HCFA5H9g15MPSwVx4R00EMXZ0mrh');

            if ($user->customer_id == null && $user->customer_id == '') {
                $customer = \Stripe\Customer::create(array(
                    'email'     => $user->email,
                    'source'     => $stripettoken['id']
                ));
                $customerid = $customer->id;
            } else {
                $customerid = $user->customer_id;
            }

            $charge = \Stripe\Charge::create(array(
                'customer'     => $customerid,
                'amount'     => $payment,
                'currency'     => 'usd'
            ));
            if (!empty($charge) && $charge->id != '') {

                $user = User::find($user->id);
                $user->customer_id = $customerid;
                if ($request->input('saved')) {
                    $user->card_number          = $request->input('card_number');
                    $user->name_on_card      = $request->input('name_on_card');
                    $user->cvc                  = $request->input('cvc');
                    $user->card_expiry_year  = $request->input('card_expiry_year');
                    $user->card_expiry_month = $request->input('card_expiry_month');
                } else {
                    $user->card_number          = '';
                    $user->name_on_card      = '';
                    $user->cvc                  = '';
                    $user->card_expiry_year  = '';
                    $user->card_expiry_month = '';
                }
                $user->save();

                $post->mark_complete = 1;
                $post->closing_date  = Carbon::now()->toDateTimeString();
                $post->agent_payment = $payment;
                $post->save();

                $userfun = new User;
                $datapayment = array();
                $datapayment['payment']         = 'Stripe';
                $datapayment['post_id']         = $request->input('post_id');
                $datapayment['user_id']         = $user->id;
                $datapayment['stripe_id']         = $charge->id;
                $datapayment['transaction_id']     = $charge->balance_transaction;
                $datapayment['stripeToken']     = $stripettoken['id'];
                $datapayment['created_at']         = Carbon::now()->toDateTimeString();
                $datapayment['updated_at']         = Carbon::now()->toDateTimeString();
                $userfun->paymentdetailsadd($datapayment);

                // $noti = new Notification;
                // $notifiy = array();
                // $notifiy['sender_id']                    = $request->input('sender_id');
                // $notifiy['sender_role']                  = $request->input('sender_role');
                // $notifiy['receiver_id']                  = $request->input('sender_id');
                // $notifiy['receiver_role']                = $request->input('sender_role');
                // $notifiy['notification_type']            = $request->input('notification_type');
                // $notifiy['notification_message']         = $request->input('notification_message');
                // $notifiy['notification_item_id']         = $user->id;
                // $notifiy['notification_child_item_id']   = $request->input('post_id');
                // $notifiy['notification_post_id']         = $request->input('post_id');
                // $notifiy['created_at']                   = Carbon::now()->toDateTimeString();
                // $notifiy['updated_at']                   = Carbon::now()->toDateTimeString();
                // $noti->inserupdate($notifiy);
                // $noti->inserupdate(array('show' => '1'), array(
                //     'notification_type' => '14', 'notification_child_item_id' => $request->input('sender_id'), 'notification_post_id' => $request->input('post_id'), 'sender_id' => $request->input('receiver_id'), 'sender_role' => $request->input('receiver_role'), 'receiver_id' => $request->input('sender_id'), 'receiver_role' => $request->input('sender_role')
                // ));

                // event(new eventTrigger(array($notifiy, $notifiy, 'NewNotification')));

                $emaildata['url']       = url('/search/post/details/') . '/' . $request->input('post_id');
                $emaildata['email']     = $user->email;
                $emaildata['name']      = ucwords($userdetails->name);
                $emaildata['posttitle'] = ucwords($post->posttitle);
                $emaildata['html']      = '<div>
				<h3>Hello ' . $emaildata['name'] . ',</h3>
				
				<br>

				<p>Visit post <a href="' . $emaildata['url'] . '">' . $emaildata['posttitle'] . '</a> </p>
				<br>
				<br>
				<center><a href="' . URL('/') . '"> www.92Agents.com </a></center>
				<div>';

                Mail::send([], [], function ($message) use ($emaildata) {
                    $message->to($emaildata['email'], $emaildata['name'])
                        ->subject('Your payment is done for post " ' . $emaildata['posttitle']. ' "')
                        ->setBody($emaildata['html'], 'text/html');
                    $message->from('92agent@92agents.com', '92agent@92agents.com');
                });

                return response()->json(["msg" => "Your Payment successfully for post (" + $post->posttitle + ")!"]);
            } else {
                return response()->json(["erroraaa" => $charge,'token'=>$stripettoken]);
            }
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage(),'token'=>$stripettoken]);
        }
    }
    public function saveCard(Request $request){
        $rules = array(
            'name_on_card'              => 'required',
            'card_number'       => 'required',
            'cvc'           => 'required',
            'card_expiry_year'           => 'required',
            'card_expiry_month'           => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
            // return response()->json(['status' => '100', 'response' => $view]);
        }
        else{
            $id =  Auth::user()->id;
        $user = User::find($id);
        $user->card_number          = $request->input('card_number');
        $user->name_on_card      = $request->input('name_on_card');
        $user->cvc                  = $request->input('cvc');
        $user->card_expiry_year  = $request->input('card_expiry_year');
        $user->card_expiry_month = $request->input('card_expiry_month'); 
        $user->save();
        return response()->json(['message' => 'card has been saved','user'=>$user]);
        }
    }






















}
