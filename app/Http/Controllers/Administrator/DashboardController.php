<?php

namespace App\Http\Controllers\Administrator;

use App\Events\eventTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    function __construct()
    {
    }

    /* For get users info for show dashboard view */
    public function index(Request $request)
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['user_type'] = env('user_role_' . $user->agents_users_role_id);
            $view['securty_questio'] = DB::table('agents_securty_question')->where('is_deleted', '0')->get();
            $view['blogs'] = DB::table('agents_blog')->select('*')->where('status', '0')->get();
            $details_id = $view['userdetails']->details_id;
            $view['agentStatus'] = DB::table('agents_users')->where('id', $details_id)->get();

            // fetch the ad

            $horizontal_ads = DB::table('agents_advertise as ap')
                ->join('agents_package as pa', 'ap.package_id', '=', 'pa.package_id')
                ->select('ap.id', 'ap.ad_link', 'ap.ad_banner', 'ap.ad_content', 'pa.image', 'pa.content')
                ->where(['ap.status' => 1, 'pa.type' => 'HORIZONTAL'])
                ->get();

            $view['horizontal_ads'] = $horizontal_ads;


            // get the pending count
            $post = new Post();

            $pending_count = ($post->get_pending_closed_count($user->id)) ? $post->get_pending_closed_count($user->id) : 0;
            $view['pending_post_count'] = $pending_count;

            //print_r($user->agents_users_role_id); die;
            if ($user->agents_users_role_id == '1') :
                return view('dashboard.user.administrators.dashboard', $view);
            elseif ($user->agents_users_role_id == '2' || $user->agents_users_role_id == '3') :
                return view('dashboard.user.buyers.dashboard', $view);
            elseif ($user->agents_users_role_id == '4') :
                return view('dashboard.user.agents.dashboard', $view);
            else :

                return view('dashboard.user.administrators.dashboard', $view);
            endif;
        } else {
            return redirect('/login?usertype=agent');
        }
    }

    /* For check agent status */
    public function agentStatus(Request $request)
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['user_type'] = env('user_role_' . $user->agents_users_role_id);

            $details_id = $view['userdetails']->details_id;
            $view['agentStatus'] = DB::table('agents_users')->where('id', $details_id)->get();
            // print_r($view['agentStatus'][0]->status); die;
            $status = $view['agentStatus'][0]->status;
            return $status;
        } else {
            return redirect('/login?usertype=agent');
        }
    }
}
