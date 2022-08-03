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

class BlogController extends Controller
{

    function __construct()
    {
    }

    /* For get users info for show dashboard view */
    public function index(Request $request)
    {

        if (Auth::user()) {
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['user_type'] = env('user_role_' . $user->agents_users_role_id);
            $view['category'] = DB::table('agents_category')->select('*')->get();
            $view['blogs'] = DB::table('agents_blog')->join('agents_category', 'agents_blog.cat_id', '=', 'agents_category.id')->where('added_by', '=', $user->id)->select('agents_blog.*', 'agents_category.cat_name')->get();
            // dd($view);
            return view('dashboard.user.buyers.blog', $view);
        } else {
            return redirect('/login?usertype=agent');
        }
    }

    /* For check agent status */
    public function blogstore(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $data = $request->except('_token', 'files');
        $data['added_by'] = $id;
        $data['status'] = 1;
        $dd = DB::table('agents_blog')->insert($data);
        $category = DB::table('agents_category')->select('*')->get();
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        $view['user_type'] = env('user_role_' . $user->agents_users_role_id);
        $view['category'] = DB::table('agents_category')->select('*')->get();
        $view['blogs'] = DB::table('agents_blog')->join('agents_category', 'agents_blog.cat_id', '=', 'agents_category.id')->where('added_by', '=', $user->id)->get();
        return redirect('/buyer/blog');
    }

    public function advertisement()
    {
        if (Auth::user()) {
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['user_type'] = env('user_role_' . $user->agents_users_role_id);

            $view['package'] = DB::table('agents_package')->select('*')->where(['status' => 1, 'deleted' => 0])->get();
            return view('dashboard.user.buyers.advertise', $view);
        } else {
            return redirect('/login?usertype=agent');
        }
    }

    public function getSingleBlog($id)
    {
        $res = DB::table('agents_blog')->where('id', '=', $id)->get();
        echo json_encode($res[0]);
    }

    public function singleBlogUpdate(Request $request)
    {
        $data = $request->except('_token', 'files');
        $id = $data['id'];
        unset($data['id']);

        $result = DB::table('agents_blog')->where('id', '=', $id)->update($data);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function delblog($id)
    {
        $res = DB::table('agents_blog')->where('id', '=', $id)->delete();
    }
}
