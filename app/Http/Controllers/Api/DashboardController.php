<?php

namespace App\Http\Controllers\Api;

use App\Events\eventTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Models\Compare;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display the specified resource.
     *
     * @param  array  $where int $limit
     * @return array
     */
    public function getDetailsByAny($limit, $where = null)
    {
        $query = DB::table('agents_compare')
            ->select('agents_compare.*', 'agents_users.login_status', 'agents_users_details.details_id', 'agents_users_details.name', 'agents_users_details.photo', 'agents_users_details.description')
            ->join("agents_users_details", DB::raw("FIND_IN_SET(agents_users_details.details_id,agents_compare.compare_item_id)"), ">", DB::raw("'0'"))
            ->leftjoin("agents_users", 'agents_users.id', '=', 'agents_users_details.details_id');
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('agents_compare.created_at', 'DESC');
        $count = $query->count();
        $result = $query->get();
        return $result;
    }
    /**
     * Display Selected Posts on dashboard.
     *
     * @param  int  $agents_user_id,$agents_users_role_id
     * @return \Illuminate\Http\Response
     */
    public function selectedPosts(Request $request)
    {
        $agents_user_id = $request->input('agents_user_id');
        $agents_users_role_id = $request->input('agents_users_role_id');
        $post = new Post;
        if ($agents_users_role_id == "4") {

            $result = $post->AppliedPostListGetForAgents('0', array('agents_users_conections.to_id' => $agents_user_id, 'agents_users_conections.to_role' => $agents_users_role_id), array('agents_users_conections.from_id' => $agents_user_id, 'agents_users_conections.from_role' => $agents_users_role_id), '1');
            return response()->json(['status' => '100', 'selectedPosts' => $result['result']]);
        } else {

            $where = array('agents_posts.is_deleted' => '0', 'agents_posts.agents_user_id' => $agents_user_id, 'agents_posts.agents_users_role_id' => $agents_users_role_id);
            $query = DB::table('agents_posts')->select('agents_posts.*', 'agents_users.id', 'agents_users.agents_users_role_id', 'agents_users_details.name', 'agents_users_details.description', 'agents_users_details.address2', 'agents_users_details.city_id', 'agents_users_details.zip_code', 'agents_users_details.years_of_expreience', 'agents_users_details.brokers_name', 'agents_users_details.total_sales');

            $query->Join('agents_users', 'agents_users.id', '=', 'agents_posts.applied_user_id');

            $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_posts.applied_user_id');

            $query->leftjoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state');
            $result = $query->where('agents_posts.is_deleted', '0')->where($where)->get();
            return response()->json(['status' => '100', 'selectedPosts' => $result]);
        }
    }
    /*get applied agents on a post */
    public function AppliedAgentsListGetForBuyer($post_id, $userid, $roleid)
    {
        $post = new Post;
        $query1 = DB::table('agents_users_conections as m')

            ->join('agents_users_details as u', function ($join) {

                $join->on('u.details_id', '=', 'm.to_id')

                    ->orOn('u.details_id', '=', 'm.from_id');
            })

            ->leftJoin('agents_state', 'agents_state.state_id', '=', 'u.state_id')

            ->leftJoin('agents_city', 'agents_city.city_id', '=', 'u.city_id')

            ->join('agents_users', 'agents_users.id', '=', 'u.details_id')

            ->where(function ($query) use ($post_id, $userid, $roleid) {

                $query->whereRaw(DB::raw(
                    'CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . '

                THEN m.from_id = u.details_id

                WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . '

                THEN m.to_id = u.details_id END'
                ));
            })

            ->Join('agents_users_roles', 'agents_users_roles.role_id', '=', 'agents_users.agents_users_role_id')

            ->where(array('m.post_id' => $post_id))

            ->select('agents_users.id', 'agents_users.agents_users_role_id', 'u.brokers_name', 'agents_state.state_name', 'agents_city.city_name', 'm.*', 'u.name', 'u.description', 'u.photo', 'u.years_of_expreience', 'u.details_id', DB::raw('(CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . ' THEN m.from_role  WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . ' THEN m.to_role END) AS details_id_role_id'), DB::raw('(CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . ' THEN "to"  WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . ' THEN "from" END) AS is_user'), 'agents_users.login_status', 'agents_users_roles.role_name')

            ->orderBy('m.created_at', 'DESC');

        $queryunion = $query1;

        $result = $queryunion->get();

        $obj = [];

        foreach ($result as $value) {

            $agentscompare = $post->checkcompare($value, $post_id, $userid, $roleid);

            $post_share_count = $post->getspecificnotificationbypost_id($value, $post_id, $userid, $roleid);

            $post_messages_count = $post->getspecificmessagenotificationbypost_id($value, $post_id, $userid, $roleid);

            $obj[] = (object) array_merge((array) $value, (array) $post_messages_count, (array) $post_share_count, (array) $agentscompare);
        }

        $result = $obj;

        return $result;
    }

    public function getSelectedDetailsByAny($where = null, $record = null)
    {
        $query = DB::table('agents_posts')->select(
            'agents_posts.*',
            'agents_users.id',
            'agents_users.agents_users_role_id',
            'agents_users.login_status',
            'agents_users.api_token',
            'agents_users_details.name',
            'agents_users_details.photo',
            'agents_users_details.description',
            'agents_users_details.address',
            'agents_users_details.address2',
            'agents_users_details.city_id',
            'agents_users_details.zip_code',
            'agents_users_details.years_of_expreience',
            'agents_users_details.brokers_name',
            'agents_users_details.total_sales',
            'agents_state.state_name'
        );

        $query->Join('agents_users', 'agents_users.id', '=', 'agents_posts.applied_user_id');

        $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_posts.applied_user_id');

        $query->leftjoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state');

        if ($where != null) {

            $query->where($where);
        }

        $query->where('agents_posts.is_deleted', '0');

        $query->where('agents_posts.applied_post', '1');

        $query->orderBy('agents_posts.updated_at', 'DESC');

        $data = $query->first();
        if (!empty($data)) {
            return array($data);
        } else {
            return array();
        }
    }

    /*get buyer/seller posts*/
    public function BuyerPosts(Request $request)
    {
        $agents_user_id = $request->input('agents_user_id');
        $agents_users_role_id = $request->input('agents_users_role_id');
        $post = new Post;

        $where = array('agents_posts.is_deleted' => '0', 'agents_posts.agents_user_id' => $agents_user_id, 'agents_posts.agents_users_role_id' => $agents_users_role_id);

        $query = DB::table('agents_posts')->select('agents_posts.*', 'agents_users.login_status', 'agents_users.api_token', 'agents_users_details.name', 'agents_users_details.description', 'agents_state.state_name', 'agents_city.city_name');

        $query->Join('agents_users', 'agents_users.id', '=', 'agents_posts.agents_user_id');

        $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');

        $query->leftjoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state');

        $query->leftjoin('agents_city', 'agents_city.city_id', '=', 'agents_posts.city');

        $query->where($where);

        $query->orderBy('agents_posts.created_at', 'DESC');

        $result = $query->get();

        $obj = [];

        foreach ($result as $value) {
            $value->details = strip_tags($value->details);
            $arr = json_decode($value->best_features);
            $value->description = strip_tags($value->description);


            $comp = $this->getDetailsByAny('0', array('agents_compare.post_id' => $value->post_id, 'agents_compare.sender_id' => $agents_user_id, 'agents_compare.sender_role' => $agents_users_role_id));
            $value->list = $comp;
            if (!empty($arr)) {
                $arr = json_decode($value->best_features);
            } else {
                $arr = Null;
            }
            $date = date('d-M-Y h:i A', strtotime($value->created_at));
            $value->created_at = $date;

            $value->best_features = $arr;

            $post = new Post;

            $selectedAgent =  $this->getSelectedDetailsByAny(array('agents_posts.post_id' => $value->post_id), 'first');

            $value->selectedAgent = $selectedAgent;
            foreach ($value->selectedAgent as $sagent) {
                $sagent->description = strip_tags($sagent->description);
            }

            $res = $this->AppliedAgentsListGetForBuyer($value->post_id, $agents_user_id, $agents_users_role_id);
            $value->applied_agent = $res;
            foreach ($value->applied_agent as $aagent) {
                $aagent->description = strip_tags($aagent->description);
            }

            $post_view_count = $post->postviewcountandagentlist($value, $where);

            $obj[] = (object) array_merge((array) $value, (array) $post_view_count, (array)$comp);
        }

        return response()->json(['status' => '100', 'posts' => $obj,'data'=>'nono']);
    }



    /*get post details */
    public function PostDetailsForBuyer(Request $request)
    {
        $post_id = $request->input('post_id');
        $agents_users_role_id = $request->input('agents_users_role_id');
        $agents_user_id = $request->input('agents_user_id');

        if (Auth::user()) {
            $view = array();

            $view['user'] = $user = Auth::user();

            $view['userdetails'] = $userdetails = Userdetails::find($user->id);


            $post = new Post;

            $view['post'] = $post->getDetailsBypostid(array('agents_posts.post_id' => $post_id));

            if (!empty($view['post']->best_features)) {

                $view['post']->best_features = json_decode($view['post']->best_features);
            } else {
                $view['post']->best_features = null;
            }

            $view['list'] = $this->getDetailsByAny('0', array('agents_compare.post_id' => $post_id, 'agents_compare.sender_id' => $agents_user_id, 'agents_compare.sender_role' => $agents_users_role_id));
            $view['appliedAgent'] = $this->AppliedAgentsListGetForBuyer($post_id, $agents_user_id, $agents_users_role_id);
            $view['selectedAgent'] =  $this->getSelectedDetailsByAny(array('agents_posts.post_id' => $post_id), 'first');


            return response()->json(['status' => '100', 'response' => $view]);
        } else {

            return response()->json(['status' => '101', 'response' => 'error']);
        }
    }

    /*create new post*/
    public function store(Request $request)

    {

        if ($request->input('agents_users_role_id') == 3) {

            $rules = array(

                'post_title'               => 'required',

                'details'                  => 'required',

                'address_Line_1'           => 'required',

                'city'                     => 'required',

                'state'                    => 'required',

                'zip'                      => 'required|digits:5|numeric',

                'when_do_you_want_to_sell' => 'required',

                'need_Cash_back'           => 'required',

            );

            $validator = Validator::make($request->all(), $rules);


            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors()]);
            }

            $postdetailsnew = array();

            $postdetailsnew['posttitle']                           = $request->input('post_title');

            $postdetailsnew['details']                             = $request->input('details');

            $postdetailsnew['address1']                            = $request->input('address_Line_1');

            $postdetailsnew['address2']                            = $request->input('address2');

            $postdetailsnew['city']                                = $request->input('city');

            $postdetailsnew['state']                               = $request->input('state');

            $postdetailsnew['zip']                                 = $request->input('zip');

            $postdetailsnew['when_do_you_want_to_sell']            = $request->input('when_do_you_want_to_sell');

            $postdetailsnew['need_Cash_back']                      = $request->input('need_Cash_back');

            $postdetailsnew['interested_short_sale']               = $request->input('interested_short_sale');

            $postdetailsnew['got_lender_approval_for_short_sale']  = $request->input('got_lender_approval_for_short_sale');

            $postdetailsnew['home_type']                           = $request->input('home_type');

            $postdetailsnew['agents_users_role_id']                = $request->input('agents_users_role_id');

            $postdetailsnew['agents_user_id']                      = $request->input('agents_user_id');
            $postdetailsnew['best_features']                       = $request->input('best_features');
        } else {

            $rules = array(

                'post_title'         => 'required',

                'details'            => 'required',

                // 'city'               => 'required',

                'state'              => 'required',

                // 'area'               => 'required',

                'when_u_want_to_buy' => 'required',

                'price_range'        => 'required',

                'home_type'          => 'required',

                'need_Cash_back'     => 'required',

            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors()]);
            }

            $postdetailsnew = array();

            $postdetailsnew['posttitle']                       = $request->input('post_title');

            $postdetailsnew['details']                         = $request->input('details');

            $postdetailsnew['city']                            = $request->input('city');

            $postdetailsnew['state']                           = $request->input('state');

            $postdetailsnew['area']                            = $request->input('area');

            $postdetailsnew['when_do_you_want_to_sell']        = $request->input('when_u_want_to_buy');

            $postdetailsnew['price_range']                     = $request->input('price_range');

            $postdetailsnew['home_type']                       = $request->input('home_type');

            $postdetailsnew['firsttime_home_buyer']            = $request->input('firsttime_home_buyer') ? $request->input('firsttime_home_buyer') : '0';

            $postdetailsnew['do_u_have_a_home_to_sell']        = $request->input('do_u_have_a_home_to_sell') ? $request->input('do_u_have_a_home_to_sell') : '0';

            $postdetailsnew['if_so_do_you_need_help_selling']  = $request->input('if_so_do_you_need_help_selling') ? $request->input('if_so_do_you_need_help_selling') : '0';

            $postdetailsnew['interested_in_buying']            = $request->input('interested_in_buying') ? $request->input('interested_in_buying') : '0';

            $postdetailsnew['bids_emailed']                    = $request->input('bids_emailed');

            $postdetailsnew['do_you_need_financing']           = $request->input('do_you_need_financing');

            $postdetailsnew['need_Cash_back']                  = $request->input('need_Cash_back');

            $postdetailsnew['agents_users_role_id']            = $request->input('agents_users_role_id');

            $postdetailsnew['agents_user_id']                  = $request->input('agents_user_id');

            /*if(!empty($request->input('zip')) && $request->input('zip') != ''){

                $value = array_values(array_filter($request->input('zip')));

                $postdetailsnew['zip'] = rtrim(implode(',', $value),',');

            }*/
        }

        $postdetailsnew['post_type'] = $request->input('agents_users_role_id');

        $Post = new Post;

        if (empty($request->input('id'))) {

            $postdetailsnew['created_at'] = Carbon::now()->toDateTimeString();

            $post_id = $Post->inserupdate($postdetailsnew);

            $this->CheckAlreadyConnectedUserSendNotification($postdetailsnew, $post_id);

            return response()->json(["status" => "100", "response" => "Your post has been added successfully"]);
        } else {

            $postdetailsnew['updated_at'] = Carbon::now()->toDateTimeString();

            $Post->inserupdate($postdetailsnew, array('post_id' => $request->input('id')));


            return response()->json(["status" => "100", "response" => "Your post has been updated successfully"]);
        }
    }

    /* For chek already connected user send notification */
    public function CheckAlreadyConnectedUserSendNotification($postdetailsnew, $post_id)
    {
        $query1 = DB::table('agents_users_conections');
        if ($postdetailsnew != null) :

            $query1->where(function ($query) use ($postdetailsnew) {

                $query->where(array('to_id'    => $postdetailsnew['agents_user_id'], 'to_role'    => $postdetailsnew['agents_users_role_id']));
            })

                ->orWhere(function ($query) use ($postdetailsnew) {

                    $query->where(array('from_id' => $postdetailsnew['agents_user_id'], 'from_role'   => $postdetailsnew['agents_users_role_id']));
                });

        endif;

        $query1->select('post_id', DB::raw('(CASE WHEN to_id = ' . $postdetailsnew['agents_user_id'] . ' AND to_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN from_role  WHEN from_id = ' . $postdetailsnew['agents_user_id'] . '  AND from_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN to_role END) AS role_id'), DB::raw('(CASE WHEN to_id = ' . $postdetailsnew['agents_user_id'] . ' AND to_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN from_id  WHEN from_id = ' . $postdetailsnew['agents_user_id'] . '  AND from_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN to_id END) AS id'));

        $query1->orderBy('created_at', 'DESC');

        $result = $query1->get();

        $count = count($result);

        $userdd = DB::table('agents_users_details')->select('*')

            ->where(array('details_id' => $postdetailsnew['agents_user_id']))

            ->first();

        if (!empty($count) && $count != 0) {

            foreach ($result as $key => $value) {

                $notifiy = array(

                    'sender_id'         => $postdetailsnew['agents_user_id'], 'sender_role'       => $postdetailsnew['agents_users_role_id'],

                    'receiver_id'       => $value->id, 'receiver_role'     => $value->role_id

                );

                $notifiy['notification_type']            = 12;

                $notifiy['notification_message']         = $userdd->name . ' upload a new post(' . $postdetailsnew['posttitle'] . ')';

                $notifiy['notification_item_id']         = $post_id;

                $notifiy['notification_child_item_id']   = $value->id;

                $notifiy['status']                       = 1;

                $notifiy['updated_at']                   = Carbon::now()->toDateTimeString();

                DB::table('agents_notification')->insertGetId($notifiy);

                event(new eventTrigger(array($notifiy, $value, 'NewNotification')));
            }
        }
    }

    /*get applied agents for a post */
    public function AppliedAgents(Request $request)

    {

        $user = Auth::user();
        $post_id = $request->input('post_id');
        $agentid = $request->input('agent_id');

        $userdetails = Userdetails::find($user->id);

        $post = Post::find($post_id);

        $post->applied_post     = '1';

        $post->applied_user_id  = $agentid;

        $post->updated_at       = Carbon::now()->toDateTimeString();

        $post->agent_select_date     = Carbon::now()->toDateTimeString();
        $post->cron_time     = Carbon::now()->toDateTimeString();

        $post->save();

        $user = new User;

        $agentdata = $user->getDetailsByEmailOrId(array('id' => $agentid));

        $notification = new Notification;

        $where = array();

        $where['sender_id']                    = $post->agents_user_id;

        $where['sender_role']                  = $post->agents_users_role_id;

        $where['receiver_id']                  = $agentdata->id;

        $where['receiver_role']                = $agentdata->agents_users_role_id;

        $where['notification_type']            = 13;

        $where['notification_message']         = $userdetails->name . ' select you for post (' . $post->posttitle . ')';

        $where['notification_item_id']         = $post_id;

        $where['notification_post_id']         = $post_id;

        $where['notification_child_item_id']   = $agentdata->id;

        $where['created_at']                   =  Carbon::now()->toDateTimeString();

        $where['updated_at']                   =  Carbon::now()->toDateTimeString();

        $result = $notification->inserupdate($where);

        event(new eventTrigger(array($where, $result, 'NewNotification')));



        $emaildata['url']       = url('/search/post/details/') . '/' . $post_id . '/13';

        $emaildata['email']     = $agentdata->email;

        $emaildata['name']      = ucwords($agentdata->name);

        $emaildata['posttitle'] = ucwords($post->posttitle);

        $emaildata['html']      = '<div>

        <h3>Hello ' . $emaildata['name'] . ',</h3>

        <br>

        <p>

            ' . $userdetails->name . ' select you for post `' . $emaildata['posttitle'] . '`

        </p>

        <br>



        <p>Visit post <a href="' . $emaildata['url'] . '">' . $emaildata['posttitle'] . '</a> </p>

        <br>

        <br>

        <center><a href="' . URL('/') . '"> www.92Agents.com </a></center>

        <div>';



        Mail::send([], [], function ($message) use ($emaildata) {

            $message->to($emaildata['email'], $emaildata['name'])

                ->subject('You are selected for post " ' . $emaildata['posttitle'] . ' "')

                ->setBody($emaildata['html'], 'text/html');

            $message->from('92agent@92agents.com', '92agent@92agents.com');
        });

        return response()->json(['response' => $result, 'status' => '100', 'applied_post' => $post->applied_post, 'applied_user_id' => $agentdata->id]);
    }
}
