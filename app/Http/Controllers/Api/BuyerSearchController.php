<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class BuyerSearchController extends Controller
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
    public function postlist(Request $request, $limit = null)
    {

        Session::put('search_post', $request->all());
        $post = new Post;
        $result = $post->getSearchAnyByAny($limit, $request->all());

        return response()->json(['status' => '100', 'response' => $result['result']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

            if ($view['post']->agents_users_role_id == 2) {
                $view['types'] = 'Buy';
            } else {
                $view['types'] = 'Sell';
            }

            $view['uri_segment'] = $request->segment(5) ? $request->segment(5) : '';

            return view('dashboard.user.search.postdetails', $view);
        } else {
            // $post = new Post;

            // $view['post'] = $post->getDetailsBypostid( array( 'agents_posts.post_id' => $id ) );

            // if($view['post']->agents_users_role_id==2){
            // $view['types'] = 'Buy';
            // }else{
            // $view['types'] = 'Sell';
            // }
            // $view['uri_segment'] = $request->segment(5) ? $request->segment(5) : '';
            // return view('front.publicPage.search.postdetails',$view);
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id $roleid
     * @return \Illuminate\Http\Response
     */
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

        $query = DB::table('agents_users')->where(['id' => $userid])->update($data);
        $response = [];
        if ($query) {
            $response['status'] = '200';
            $response['message'] = 'User switched successfully';
        } else {
            $response['status'] = '400';
            $response['message'] = 'Failed to switch user';
        }
        return response()->json(["result" => $response]);
    }
}
