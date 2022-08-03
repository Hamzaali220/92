<?php

namespace App\Http\Controllers\Administrator\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class BuyerSearchController extends Controller
{

    function __construct()
    {
    }

    /* For buyers and seller psot's */
    public function index()
    {
        if (Auth::user() && Auth::user()->agents_users_role_id == 4) {
            $response = $this->checkProfileCompletion(Auth::user()->id);
            if ($response == 0) {
                Session::flash('profileCompletion', 'Yes');
                return redirect('profile/agent/personal');
            }

            $state = new State;
            $view = array();
            $view['user']        = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['city']        = $state->getCityByAny(array('is_deleted' => '0'));
            $view['state']       = $state->getStateByAny(array('is_deleted' => '0', 'status' => '1'));
            $view['search_post'] = Session::has('search_post') ? Session::get('search_post') : '';
            return view('dashboard.user.search.postsearch', $view);
        } else {
            // $view['search_post'] = Session::has('search_post') ? Session::get('search_post') : '';
            // return view('front.publicPage.search.postsearch',$view);
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* Post for agents */
    public function postForAgents(Request $request)
    {

        $user_id = $request->input('userId');
        $query = DB::table('agents_users_details')->where('details_id', $user_id)->get();

        $office_address = $query[0]->office_address;
        $state = $query[0]->state_id;
        $city = $query[0]->city_id;
        $licence = $query[0]->licence_number;
        $experience = $query[0]->years_of_expreience;
        $broker_name = $query[0]->brokers_name;
        $contractVerification = $query[0]->contract_verification;
        $values = array(
            'office_address' => $office_address,
            'state' => $state,
            'city' => $city,
            'licence' => $licence,
            'experience' => $experience,
            'broker' => $broker_name
        );

        $value_count = count($values);

        if (!empty($office_address) && !empty($state) && !empty($city) && !empty($licence) && !empty($experience) && !empty($broker_name) && $contractVerification == 2) :
            return 1;
        else :
            return 0;
        endif;
    }

    public function checkProfileCompletion($userId)
    {
        $user_id = $userId;
        $query = DB::table('agents_users_details')->where('details_id', $user_id)->get();

        $office_address = $query[0]->office_address;
        $state = $query[0]->state_id;
        $city = $query[0]->city_id;
        $licence = $query[0]->licence_number;
        $experience = $query[0]->years_of_expreience;
        $broker_name = $query[0]->brokers_name;
        $contractVerification = $query[0]->contract_verification;
        $values = array(
            'office_address' => $office_address,
            'state' => $state,
            'city' => $city,
            'licence' => $licence,
            'experience' => $experience,
            'broker' => $broker_name
        );

        $value_count = count($values);

        if (!empty($office_address) && !empty($state) && !empty($city) && !empty($licence) && !empty($experience) && !empty($broker_name) && $contractVerification == 2) :
            return 1;
        else :
            return 0;
        endif;
    }

    /* Post list info  */
    public function postlist(Request $request, $limit = null)
    {

        Session::put('search_post', $request->all());
        $post = new Post;
        $result = $post->getSearchAnyByAny($limit, $request->all());
        //echo '<pre>'; print_r($result); die;
        return response()->json($result);
    }

    /* For post details info show inside the post detail view */
    public function postdetails(Request $request, $id)
    {
        if (Auth::user() && Auth::user()->agents_users_role_id == 4) {
            if (empty($id)) {
                return redirect()->back();
            }
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $post = new Post;
            $view['post'] = $post->getDetailsBypostid(array('agents_posts.post_id' => $id));


            $post_sell_details = $post->getSellDetails($id, $user->id);

            if (isset($post_sell_details[0])) {
                $sell_details = $post_sell_details[0];

                $agent_comission = $sell_details->agent_comission;
                $commission_rate = $sell_details->comission_92agent;

                $agent_commission_amount = (($agent_comission / 100) * $sell_details->sale_price);
                $our_commision = (($commission_rate / 100) * $agent_commission_amount);

                $view['post_sell_details'] = $sell_details;
                $view['commission_amount'] = $our_commision;
            }

            if ($view['post']->agents_users_role_id == 2) {
                $view['types'] = 'Buy';
            } else {
                $view['types'] = 'Sell';
            }

            $review = DB::table('agents_rating')->where(['rating_item_parent_id' => $id, 'rating_item_id' => Auth::user()->id])->first();
            $view['review'] = $review;

            $getAppliedPostsBySelectedAgent = $post->getAppliedPostsBySelectedAgent($view['post']->applied_user_id);
            // $getAppliedPostsBySelectedAgent > 5 &&
            if ($view['post']->agent_payment != 'completed' && $view['post']->closing_date != '') {
                $view['agentPaymentStatus'] = true;
            } else {
                $view['agentPaymentStatus'] = false;
            }
            //dd($view);

            # notes history
            $notes_history = DB::table('agents_notes')
                ->select('*')
                ->where(['notes_type' => 5, 'notes_item_parent_id' => $id, 'sender_id' => $user->id])
                ->get();
            $view['notes_history'] = $notes_history;


            $view['uri_segment'] = $request->segment(5) ? $request->segment(5) : '';




            return view('dashboard.user.search.postdetails', $view);
        } else {

            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /*buyer seller details show and get post list*/
    public function buyerdetails($id, $roleid)
    {
        if (Auth::user() && Auth::user()->agents_users_role_id == 4) {
            if (empty($id)) {
                return redirect()->back();
            }
            $state = new State;
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);

            $user = new User;

            $view['buyer'] = $user->getuserdetailsByAny(array('agents_users.id' => $id));
            // $view['state']  = $state->getStateByAny(array('state_id' => $view['buyer']->state_id,'is_deleted' => '0') ,'first');
            // $view['city']  = $state->getCityByAny(array( 'city_id' => $view['buyer']->city_id,'is_deleted' => '0') ,'first');

            if ($roleid == 2) {
                $view['types'] = 'Buy ';
            } else {
                $view['types'] = 'Sell ';
            }
            $view['roleid'] = $roleid;

            // $post = new Post;
            // $view['post'] = $post->getpostmultipalByAny( array( 'agents_user_id' => $view['buyer']->id ,'agents_users_role_id' => $view['buyer']->agents_users_role_id,'applied_post' =>'2') );
            return view('dashboard.user.search.buyerdetails', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    public function switchuser(Request $request)
    {
        $data = array();
        $userid = $request->input('userId');
        $data['agents_users_role_id'] = $request->input('role');
        $query = DB::table('agents_users')->where('id', $userid)->update($data);
        return response()->json(["result" => $query]);
    }
}
