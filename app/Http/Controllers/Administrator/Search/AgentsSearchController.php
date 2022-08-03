<?php

namespace App\Http\Controllers\Administrator\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\State;
use App\Models\Post;
use App\Models\ClosingDateQuery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AgentsSearchController extends Controller
{
    function __construct()
    {
    }

    /* For agents search job view */
    public function index()
    {
        if (Auth::user() && Auth::user()->agents_users_role_id != 4) {
            $state = new State;
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['city']        = $state->getCityByAny(array('is_deleted' => '0'));
            $view['state']       = $state->getStateByAny(array('is_deleted' => '0', 'status' => '1'));
            $view['search_post'] = Session::has('search_post') ? Session::get('search_post') : ['searchinputtype'=>''];

            // fetch the ad
            $horizontal_ads = DB::table('agents_advertise as ap')
                ->join('agents_package as pa', 'ap.package_id', '=', 'pa.package_id')
                ->select('ap.id', 'ap.ad_link', 'ap.ad_banner', 'ap.ad_content', 'pa.image', 'pa.content')
                ->where(['ap.status' => 1, 'pa.type' => 'HORIZONTAL'])
                ->get();

            $view['horizontal_ads'] = $horizontal_ads;

            // echo"<pre>"; print_r($view); exit;
            return view('dashboard.user.search.agentsearch', $view);
        } else {
            // $view['search_post'] = Session::has('search_post') ? Session::get('search_post') : '';
            // return view('front.publicPage.search.agentsearch',$view);
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    public function inputclosingdate()
    {
        if (Auth::user() && Auth::user()->agent_status != 2) {
            return redirect('/dashboard');
        }
        $user = Auth::user();
        $closingDateQueryObj = new ClosingDateQuery;

        $forPost = $closingDateQueryObj
            ->with('post', 'agent', 'agentdetails', 'buyerorseller', 'buyerorsellerdetails')
            ->where([
                ['agent_id', '=', $user->id],
                ['status', '=', '1']
            ])
            ->first();
        if ($forPost != null) {
            $forPost =  $forPost->toarray();
        }

        //dd($forPost);
        $view['forPost'] = $forPost;
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        return view('dashboard.user.search.inputclosingdate', $view);
    }

    public function closingdatecronjob()
    {
        $allPosts = DB::table('agents_posts')
            ->where([
                ['closing_date', '!=', ''],
                ['applied_user_id', '!=', '']
            ])
            ->get();
        foreach ($allPosts as $post) {
            $duration = 30;
            $selectedAgent = $post->applied_user_id;
            $lastSentMail = DB::table('closingdate_queries')
                ->where([
                    ['post_id', '=', $post->post_id]

                ])
                ->orderBy('created_at', 'desc')
                ->first();
            if (!empty($lastSentMail)) {
                $countingStartDate = $lastSentMail->created_at;
            } else {
                $countingStartDate = $post->agent_select_date;
            }
            $countingEndDate = date("d-m-Y", strtotime('+30 days', strtotime($countingStartDate)));
            $todayDate = strtotime(date("d-m-Y"));
            $diff = strtotime($countingEndDate) - $todayDate;



            if ($diff == 0) {
                $userDetails = DB::table('agents_users')
                    ->join('agents_users_details', 'agents_users.id', '=', 'agents_users_details.details_id')
                    ->where([['id', '=', $post->applied_user_id]])
                    ->first();
                /* Send email to agent. */
                $msg = 'Dear ,' . $userDetails->name . '<br/>Your account has been temporary suspended please login to activate it.<br /><br /><br />Regards<br />92Agents.com';
                $acknowledgeMsgData = array(
                    'name' => 'Admin',
                    'email' => 'Support@92agents.com',
                    'message' => $msg,
                    'receiver' => $userDetails->email
                );
                $acknowledgeMsgData['msg'] = $acknowledgeMsgData['message'];
                Mail::send('email.acknowledge', $acknowledgeMsgData, function ($message) use ($acknowledgeMsgData) {
                    $message->to($acknowledgeMsgData['receiver'], '92Agents')
                        ->subject('Thanks to contact 92Agents');
                    //dd($message);
                    $message->from($acknowledgeMsgData['email'], $acknowledgeMsgData['name']);
                });

                /* Send email to agent. */

                /* Update agent's data. */
                $data = array(
                    'post_id' => $post->post_id,
                    'agent_id' => $post->applied_user_id,
                    'sellerorbuyer_id' => $post->agents_user_id,
                    'sellerorbuyer_role' => $post->agents_users_role_id,
                    'agent_role' => $post->agents_users_role_id,
                    'select_date' => $post->agent_select_date,

                );
                $result = DB::table('closingdate_queries')->insert([
                    $data
                ]);
                if ($result) {
                    DB::table('agents_users')
                        ->where('id', $post->applied_user_id)
                        ->update(['agent_status' => '2']);
                }


                /* Update agent's data. */
            }
        }
        exit;
    }

    public function inputclosingdatestore(Request $request)
    {

        if ($request->exists('donthaveclosingdate') && $request->input('donthaveclosingdate') == 'on') {
            $rules = array(
                'comments' => 'required',
            );
        } else {
            $rules = array(
                'closing_date' => 'required',
            );
        }


        $user_id = Auth::user()->id;

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->ajax()) {
                $res = array(
                    'status' => 2,
                    'message' => 'Validation Failed',
                    'errors' => $validator->errors()
                );
            } else {
                $res = array(
                    'status' => 2,
                    'message' => 'Validation Failed',
                    'errors' => $validator->errors()
                );
            }
            return response()->json($res);
        } //if validator fails
        $userObj = new User;
        $post = new Post;
        $user = $userObj->find(Auth::user()->id);
        $closingDateQueryObj = new ClosingDateQuery;
        //print_r($user);exit;
        if ($request->exists('donthaveclosingdate') && $request->input('donthaveclosingdate') == 'on') {
            $data = array(
                'comments' => $request->input('comments'),
                'status' => 0,
            );
            // print_r($data);exit;
            // echo $request->input('closingqueryid');exit;
            $closingQueryObj = $closingDateQueryObj::find($request->input('closingqueryid'));
            $result = $closingQueryObj->update($data);
            //echo $result;exit;
            if ($result) {

                if ($user->update(['agent_status' => '1'])) {
                    $res = array(
                        'status' => 1,
                        'message' => 'Added Successfully',
                        'alert_class' => 'alert-success',
                        'alert_message' => 'Added Successfully',
                    );
                } else {
                    $res = array(
                        'status' => 2,
                        'message' => 'Un-Successful Operation',
                        'alert_class' => 'alert-danger',
                        'alert_message' => 'Un-Successful Operation',
                    );
                }
            } else {
                $res = array(
                    'status' => 2,
                    'message' => 'Un-Successful Operation',
                    'alert_class' => 'alert-danger',
                    'alert_message' => 'Un-Successful Operation',
                );
            }
        } else {
            $data = array(
                'closing_date' => $request->input('closing_date'),
                'updated_at' => Carbon::now()->toDateTimeString()
            );

            $postDetails = $post->getAppliedPostsBySelectedAgent(Auth::user()->id);
            //echo $postDetails;exit;
            if ($postDetails == '' || $postDetails <= 5) {
                $data['agent_payment'] = 'completed';
                /* Save Payment Data */
                $transactionId = strtotime(date("d-m-y h:i:s")) . $request->input('postid') . Auth::user()->id . rand(00000, 99999);
                $paymentDetails = array(
                    'amount' => 0.00,
                    'discount' => 0.00,
                    'taxes' => 0.00,
                    'payment' => 'Stripe',
                    'post_id' => $request->input('postid'),
                    'user_id' => Auth::user()->id,
                    'transaction_id' => $transactionId,
                    'stripe_order_no' => '',
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s")
                );
                DB::table('agents_payment')->insert($paymentDetails);
                /* Save Payment Data */
            }
            $postId = $post->find($request->input('postid'));
            if ($postId->update($data)) {
                if ($user->update(['agent_status' => '1'])) {
                    $res = array(
                        'status' => 1,
                        'message' => 'Added Successfully',
                        'alert_class' => 'alert-success',
                        'alert_message' => 'Added Successfully',
                    );
                } else {
                    $res = array(
                        'status' => 2,
                        'message' => 'Un-Successful Operation',
                        'alert_class' => 'alert-danger',
                        'alert_message' => 'Un-Successful Operation',
                    );
                }
            } else {
                $res = array(
                    'status' => 2,
                    'message' => 'Un-Successful Operation',
                    'alert_class' => 'alert-danger',
                    'alert_message' => 'Un-Successful Operation',
                );
            }
        }
        return response()->json($res);
    }

    /* For agent list info */
    public function agentslist(Request $request, $limit = null)
    {
        Session::put('search_post', $request->all());
        $user = new User;
        $result = $user->getSearchUsersByAny($limit, $request->all());        //echo '<pre>'; print_r($result); die;
        return response()->json($result);
    }


    /* For agents detail show on the view page */
    public function agentsdetails(Request $request, $id)
    {
        $state = new State;
        if (Auth::user() && Auth::user()->agents_users_role_id != 4) {
            if (empty($id)) {
                return redirect()->back();
            }
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $user = new User;
            $view['agents'] = $user->getuserdetailsByAny(array('agents_users.id' => $id));
            //dd($view['agents']);
            if ($view['agents'] != null) {
                $view['state']  = $state->getStateByAny(array('state_id' => $view['agents']->state_id, 'is_deleted' => '0', 'status' => '1'), 'first');
                $view['City']  =  $state->getCityByAny(array('city_id' => $view['agents']->city_id, 'is_deleted' => '0'), 'first');
            }

            // echo"<pre>"; print_R($view); exit;
            if ($view['agents'] != null && $view['user']->agents_users_role_id == 2) {
                $view['types'] = 'Buy';
            } else {
                $view['types'] = 'Sell';
            }

            $post = new Post;
            if ($request->segment(5)) {

                $view['post'] = $post->getpostmultipalByAny(array('post_id' => $request->segment(5), 'agents_user_id' => $view['user']->id)); #,'agents_users_role_id' => $view['user']->agents_users_role_id
                if (empty($view['post'])) {
                    return redirect('dashboard');
                }
            } else {

                $view['post'] = $post->getpostmultipalByAny(array('agents_user_id' => $view['user']->id, 'agents_users_role_id' => $view['user']->agents_users_role_id, 'applied_post' => 2, 'final_status' => 1, 'final_status' => 0));
            }
            $view['uri_segment'] = $request->segment(6) ? $request->segment(6) : '';
            //dd($view);
            $query = DB::table('agents_review')->select('*')
                ->join('agents_users_details', 'agents_review.sender_id', '=', 'agents_users_details.details_id')->where('agent_id', '=', $id)->get();
            $view['blog'] = $query;
            $avg = DB::table('agents_review')->where('agent_id', '=', $id)->avg('star');
            $view['avg'] = $avg;

            return view('dashboard.user.search.agentsdetails', $view);
        } else {
            // $user = new User;
            // $view['agents'] = $user->getDetailsByEmailOrId( array( 'id' => $id ) );
            // if($view['agents']->agents_users_role_id==2){
            // $view['types'] = 'Buy';
            // }else{
            // $view['types'] = 'Sell';
            // }
            // $view['uri_segment'] = $request->segment(6) ? $request->segment(6) : '';
            // return view('front.publicPage.search.agentsdetails',$view);
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    public function addcomment(Request $request)
    {
        $data = array();
        $id = Auth::user()->id;
        $agentid = $request->agent_id;
        $data = $request->all();
        $data['sender_id'] = $id;

        $query = DB::table('agents_review')->select('*')->where('agent_id', '=', $agentid)->where('sender_id', '=', $id)->count();

        if ($query == 0) {
            $qry = DB::table('agents_review')->insert($data);
            $data['success'] = 'ok';
        } else {
            $data['success'] = 'err';
        }

        return json_encode($data);
    }
}
