<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Helper\StripHelper;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller {
	private $sp;
    function __construct(StripHelper $sp){
        $this->sp = $sp;
        // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }


	public function blogs()
	{
		$blogs = DB::table('agents_blog as blog')
				->join('agents_category as cat', 'blog.cat_id', '=', 'cat.id')
				->join('agents_users as role', 'blog.added_by', '=', 'role.id')
				->join('agents_users_roles as userole', 'role.agents_users_role_id', '=', 'userole.role_id')
				->join('agents_users_details as user', 'role.id', '=', 'user.details_id')
				->select('blog.id', 'blog.title', 'blog.description', 'blog.created_date', 'blog.view', 'cat.cat_name', 'user.name', 'userole.role_name')
				->orderBy('blog.id','DESC')->skip(0)
				->take(5)->get();

		$category = DB::table('agents_category')->get();
        return view('front.publicPage.blogs',['blogs'=>$blogs,'category'=>$category]);
	}
	/* For redirect terms & condition view */
	public function terms(Request $request){
		return view('front.publicPage.terms');
	}

	/* For redirect newTerms view */
	public function newTerms(Request $request){
		return view('front.publicPage.new-terms');
	}

	/* For redirect bestShoots view */
	public function bestShoots(Request $request){
		return view('front.publicPage.bestShoots');
	}

	/* For redirect incredible content view */
	public function incredibleContent(Request $request){
		return view('front.publicPage.incredibleContent');
	}

	/* For redirect privacy view */
	public function privacy(Request $request){
		return view('front.publicPage.privacy');
	}

	/* For redirect about us view */
	public function aboutus(Request $request){
		return view('front.publicPage.about');
	}

	/* For redirect buyers view */
	public function buyers(Request $request){
		return view('front.publicPage.buyers');
	}

	/* For redirect sellers view */
	public function sellers(Request $request){
		return view('front.publicPage.sellers');
	}

	/* For redirect agents  view */
	public function agent(Request $request){
		return view('front.publicPage.agents');
	}

	/* For redirect contact view */
	public function contact(Request $request){
		return view('front.publicPage.contact');
	}

	/* For send contact */
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
						'contactNo'=>'required|min:10|numeric',
						'countrycode'=>'required',
				);

			$validator = Validator::make($input_arr,$input_error_arr);

			if($validator->fails()){
				return Redirect::back()->withErrors($validator)->withInput();
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
				return Redirect::back()->with('success','<h4><span class="glyphicon glyphicon-ok"></span> Thank you!</h4>Your message has been sent successfully. We will contact you very soon!');
			}
	}

	public function index(Request $request,$stype=null){
		$view=array();
		$state = new State;
		//$view['state'] = $state->getStateByAny(array('is_deleted' => '0'));
		//$view['city'] = $state->getCityByAny(array('is_deleted' => '0'));
		//$view['area'] = $state->getAreaByAny(array('is_deleted' => '0'));

		$view['stype'] = $stype;
		$user = new User;
        $view['agents'] = $user->getforeUsersByAnyonly(0,array( 'agents_users.agents_users_role_id' => '4','agents_users.is_deleted' => '0','agents_users.status' => '1' ) );
		return view('front.publicPage.index',$view);
	}

	/* For login process */
	public function login(Request $request){
		$view=array();
		if(isset($_REQUEST['activation_link']) && !empty($_REQUEST['activation_link'])){
			$user = new User;
			$checkav = $user->getByanydata(array('activation_link' => $_REQUEST['activation_link']));

			if(!empty($checkav)){

				$uu = User::find($checkav->id);
				$uu->activation_link = '';
				$uu->status = '1';
				$uu->updated_at = Carbon::now()->toDateTimeString();
				$uu->save();
				$view['activation_link'] = array('class' => 'success' ,'msg' => 'Your account has been activated successfully. You can now login');
				$view['type'] = env('user_role_'.$checkav->agents_users_role_id);
						}else{
				$view['activation_link'] = array('class' => 'danger' ,'msg' =>'Your account is already activated . You can now login');
			}
		}
		$view['usertype'] = isset($_REQUEST['usertype']) ? $_REQUEST['usertype'] : '';
		return view('front.publicPage.login',$view);
	}

	/* For reset view redirect */
	public function reset(Request $request){
		return view('front.publicPage.reset');
	}

	/* For check mail process */
	public function checkemail(Request $request) {
		$roleId = $request->input('agents_users_role_id');
		$email  = $request->input('email');
	 	$rules = array(
         	'email'         => 'required|email',
        );
		$validator = Validator::make($request->all(),$rules);
		if(!$validator->fails()):
			$user= new User;
			$userExits = $user->getDetailsByEmailOrId( array( 'email'=> $email ) );
			if(!empty($userExits)){

				if($userExits->agents_users_role_id == $roleId && $userExits->step == 3 ){

					return response()->json(['error'=>array('Email already exist in our records please use login button.')]);
				}else{
				if ($userExits->agents_users_role_id != $roleId && $userExits->agents_users_role_id == 4) {

					return response()->json(['error'=>array('Email already exist in our records as an agent.')]);
				}
				if (($userExits->agents_users_role_id == 2 || $userExits->agents_users_role_id == 3) && $userExits->step == 3 ) {

					return response()->json(['error'=>array('Email already exist .please try with another email in our records as a seller or buyer.')]);
				}

					return response()->json(['userDetails'=>$userExits,'step'=>'1']);
				}
			}
		endif;
	}

	/* For send mail new user */
	public function NewUserMailSend(Request $request)
	{
		$emaildata = array();
		$emaildata['email'] 	= 	$request->input('email');
		$emaildata['rolename'] 	= 	$request->input('rolename');
		$emaildata['url'] 		=	$request->input('url');
		$emaildata['name'] 		=	$request->input('name');
		Mail::send('email.activate', $emaildata, function($message) use ($emaildata) {
            $message->to($emaildata['email'], $emaildata['name'])
	                ->subject('Activate your 92Agents '.$emaildata['rolename'].' Account.');
	    });
	    if (Mail::failures()) {
	        // return response showing failed emails
	        return response()->json([	'success'	=> 'fail']);
	    }
	    else{
	    	return response()->json([	'success'	=> 'send']);
	    }

	}

	/*signup step 1*/
	public function signup(Request $request){


		$postStep = $request->input('step');
		$roleId = $request->input('agents_users_role_id');

		$rules = array();
		// $rules['roleId']				=	'required';
		$rules['fname']					=	'required|string|min:3|max:30';
		$rules['lname']					=	'required|string|min:3|max:30';
		$rules['email']					=	'required|email|unique:agents_users';
		$rules['terms_and_conditions']	=	'required';
		$rules['password']				=	'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!#$%^&*@]).*$/';
		$rules['confirm_password']		=	'required|same:password|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!#$%^&*@]).*$/';

		$error_message=array(
			'terms_and_conditions.required' => 'Acceptance of Terms and Conditions is required',
			'fname.required' 				=> 'The first name is required',
			'lname.required' 				=> 'The last name is required',
		);

		$validator = Validator::make($request->all(),$rules,$error_message);

		if($validator->fails()):
		   return response()->json([ 'error'=> $validator->errors() ]);
		else:
			$user= new User;
			$userExits = $user->getDetailsByEmailOrId( array( 'email'=> $request->input('email') ) );

			if(empty($userExits)){

				$activation_link = uniqid();
				$user 						= new User;
				$user->agents_users_role_id = $roleId;
				$user->step 				= $postStep;
				$user->email 				= $request->input('email');
				$user->password 			= Hash::make($request->input('password'));
                $user->activation_link 		= $activation_link;
                $user->api_token=Hash::make((string) time());
				$user->save();

				$details  				=	 array();
				$details['details_id']	=	$user->id;
				$details['name']		=	$request->input('fname').' '.$request->input('lname');
				$details['fname']		=	$request->input('fname');
				$details['lname']		=	$request->input('lname');

				DB::table('agents_users_details')->insertGetId($details);

				$emaildata = array();
				$emaildata['email'] 	= 	$request->input('email');
				$emaildata['rolename'] 	= 	env("user_role_".$roleId);
				$emaildata['url'] 		=	url('/').'/login?usertype='.$emaildata['rolename'].'&activation_link='.$activation_link;
				$emaildata['name'] 		=	ucwords($details['name']);

				$userDetails= $user->getDetailsByEmailOrId( array( 'id' => $user->id ) );
				return response()->json([ 'userDetails' => $userDetails, 'step' => '1', 'emaildata' => $emaildata] );

			}else{

				if($userExits->agents_users_role_id == $roleId && $userExits->step == 3 ){
				return response()->json([	'msg'	=>	array('error' => 'Email already exist in our records please use login button.')	]);
				}else{
				if ($userExits->agents_users_role_id != $roleId && $userExits->agents_users_role_id == 4) {
				return response()->json([	'msg'	=>	array('error' => 'Email already exist in our records as an agent.')	]);
				}
				if (($userExits->agents_users_role_id == 2 || $userExits->agents_users_role_id == 3) && $userExits->step == 3 ) {
				return response()->json([	'msg'	=>	array('error' => 'Email already exist .please try with another email in our records as a seller or buyer.')	]);
				}
				return response()->json([	'userDetails'	=>	$userExits,	'step'=>'1'	]);
				}
			}

		endif;
	}

	/*signup step 2*/
	public function signup2(Request $request){
		$postStep = $request->input('step');
		$roleId = $request->input('agents_users_role_id');

		$rules 						= array();
		$rules['id']				='required';
		$rules['phone'] 			='required';
		$rules['address_line_1']	='required';
		$rules['city']				='required';
		$rules['state']				='required';
		$rules['zip_code']			='required';

		$validator = Validator::make($request->all(),$rules);

		if($validator->fails()):
			return response()->json( [ 'error' => $validator->errors() ] );
		else:

			$input_arr['address_line_2'] = $request->input('address_line_2');

			if(!empty($request->input('id')) && User::find($request->input('id')) && Userdetails::find($request->input('id'))){

				$userdetails = Userdetails::find($request->input('id'));
				$userdetails->phone 	= $request->input('phone');
				$userdetails->address 	= $request->input('address_line_1');
				$userdetails->address2 	= $request->input('address_line_2') !='' ? $request->input('address_line_2') : '';
				$userdetails->state_id 	= $request->input('state');
				$userdetails->city_id 	= $request->input('city');
				$userdetails->zip_code 	= $request->input('zip_code');
				$userdetails->save();

				$user = User::find($request->input('id'));
				$user->step= $postStep;
				$user->save();

				$userDetailssend= $user->getDetailsByEmailOrId( array( 'id' => $userdetails->details_id ) );

				if($roleId == 3 || $roleId == 2){

				   $post =  new Post;
				   $postdetails = $post->getDetailsByUserroleandId( $request->input('id'), $roleId );

				   return response()->json([ 'userDetails' => $userDetailssend, 'postdetails' => $postdetails, 'step' => '2' ]);

				}else{

				   return response()->json([ 'userDetails'=> $userDetailssend, 'step' => '2' ]);
				}

			}else{

				   return response()->json([ 'msg' => array('error' => 'User not found. Please refresh the page and try again.') ]);
			}
		endif;
	}

	/*signup step 3*/
	public function signup3(Request $request){
		$postStep 	= $request->input('step');
		$roleId 	= $request->input('agents_users_role_id');
		$user_id 	= $request->input('id');

		if(!empty($user_id) && User::find($user_id) && Userdetails::find($user_id)){

		   /*for buyer and sellere */
			if($roleId == 3 || $roleId == 2){

				$rules 						= array();
			   	$rules['posttitle']	=	'required';

			   	$messages = [
				    'posttitle.required' => 'Post Title field is required.',
				];

			   	$validator = Validator::make($request->all(),$rules, $messages);

			   	if( $validator->fails()):
					dd('fails mw=e hn');
				   return response()->json([ 'error' => $validator->errors() ]);

			   	else:
				   	$post =  new Post;
				   	$postdetails = $post->getDetailsByUserroleandId($user_id,$roleId);

					if(empty($postdetails)){

						$postdetailsnew	=	array();
						$postdetailsnew['agents_user_id']		=	$user_id;
						$postdetailsnew['agents_users_role_id']	=	$roleId;
						$postdetailsnew['posttitle']			=	$request->input('posttitle');
						$postdetailsnew['updated_at']			= 	Carbon::now()->toDateTimeString();
						$postdetailsnew['created_at']			= 	Carbon::now()->toDateTimeString();
						DB::table('agents_posts')->insertGetId($postdetailsnew);
					}else{
						dd('new post if main hn');
						$postdetails = Post::find($postdetails->post_id);
						$postdetails->agents_user_id 		=	$user_id;
						$postdetails->agents_users_role_id 	=	$roleId;
						$postdetails->posttitle 			= 	$request->input('posttitle');
						$postdetails->updated_at 			= 	Carbon::now()->toDateTimeString();
						$postdetails->created_at 			= 	Carbon::now()->toDateTimeString();
						$postdetails->save();
					}
						$user 			= User::find($user_id);
						$user->step 	= $postStep;
						$user->save();
						$userDetailssend 	= 	$user->getDetailsByEmailOrId( array( 'id' => $user_id ) );

						return response()->json([ 'userDetails' => $userDetailssend, 'step' => '3' ]);
				endif;
			}

		   	/*for agents */
			if($roleId == 4){

			   $rules['licence_number']	=	'required';
			   $validator = Validator::make($request->all(),$rules);

				if($validator->fails()):

					return response()->json([ 'error' => $validator->errors() ]);

				else:

					$userdetails 					= Userdetails::find($user_id);
					$userdetails->licence_number 	= $request->input('licence_number');
					$userdetails->save();

					$user 			= User::find($user_id);
					$user->step 	= $postStep;
					$user->save();

					$userDetailssend	= 	$user->getDetailsByEmailOrId( array( 'id' => $userdetails->details_id ) );
					return response()->json([ 'userDetails' => $userDetailssend, 'step' => '3' ]);

				endif;
			}
		}
		return response()->json(['msg'=>array('error' => 'User not found. Please refresh the page and try again.')]);

	}


	public function singleblogs($id,$title)
	{
		$view = DB::table('agents_blog')->whereRaw('id = '.$id)->increment('view', 1);
		$detail = DB::table('agents_blog as blog')
				->join('agents_category as cat', 'blog.cat_id', '=', 'cat.id')
				->join('agents_users as role', 'blog.added_by', '=', 'role.id')
				->join('agents_users_roles as userole', 'role.agents_users_role_id', '=', 'userole.role_id')
				->join('agents_users_details as user', 'role.id', '=', 'user.details_id')
				->select('blog.id', 'blog.title', 'blog.description', 'blog.created_date', 'blog.view', 'cat.cat_name', 'user.name', 'userole.role_name')
				->whereRaw('blog.id = '.$id)->first();

		$category = DB::table('agents_category')->get();
		$comment = DB::table('agents_blog_comment')->whereRaw("blog_id='".$id."'")->get();
		return view('front.publicPage.singleblog',['title'=>$title,'id'=>$id,'detail'=>$detail,'category'=>$category,'comment'=>$comment]);
	}
	public function categoryblogs($id,$title)
	{
		// $view = DB::table('agents_blog')->whereRaw('id = '.$id)->increment('view', 1);
		$detail = DB::table('agents_blog as blog')
				->join('agents_category as cat', 'blog.cat_id', '=', 'cat.id')
				->join('agents_users as role', 'blog.added_by', '=', 'role.id')
				->join('agents_users_roles as userole', 'role.agents_users_role_id', '=', 'userole.role_id')
				->join('agents_users_details as user', 'role.id', '=', 'user.details_id')
				->select('blog.id', 'blog.title', 'blog.description', 'blog.created_date', 'blog.view', 'cat.cat_name', 'user.name', 'userole.role_name')
				->whereRaw('cat.id = '.$id)->get();

		$category = DB::table('agents_category')->get();
		return view('front.publicPage.catergory_blogs',['title'=>$title,'id'=>$id,'blogs'=>$detail,'category'=>$category]);
	}
	public function savecomment(Request $request)
	{
		$data = $request->all();

		$rules = array(
			'comment'             	=> 'required'
			);

		$validator = Validator::make($data,$rules);

		if(	$validator->fails()	){
			return response()->json([ 'error'=> $validator->errors() ]);
		}

		$insert_arr = array(
			'blog_id' => $data['blog_id'],
			'comment_name' => $data['comment_name'],
			'email' => $data['email'],
			'comment' => $data['comment']
		);


		$res = DB::table('agents_blog_comment')->insert($insert_arr);
		if($res==1){
			$data['ctime']=date('d-m-y h:i a');
			$data['success']='ok';
			return json_encode($data);
		}
		else{
			$data['success']='err';
			return json_encode($data);
		}

	}

	public function showadvertise()
	{
		$packages = DB::table('agents_package')->get();
		return view('front.publicPage.advertise',['packages'=>$packages]);
	}
}
