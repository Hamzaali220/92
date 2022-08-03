<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Models\State;

class AgentadminController extends Controller
{
    /**
     * Display a dashboard of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = auth()->guard('admin')->user();
        $view['sellersbuyerscount'] = DB::table('agents_users')->where('is_deleted', '0')->whereIn('agents_users_role_id', [2, 3])->count();
        $view['agentscount'] = DB::table('agents_users')->where(array('agents_users_role_id' => '4', 'is_deleted' => '0'))->count();
        $view['postcount'] = DB::table('agents_posts')->where('is_deleted', '0')->count();
        $view['post_question'] = DB::table('agents_question')->where('is_deleted', '0')->count();
        $view['postsecurty_question'] = DB::table('agents_securty_question')->where('is_deleted', '0')->count();
        $view['post_certifications'] = DB::table('agents_certifications')->where('is_deleted', '0')->count();
        $view['post_franchise'] = DB::table('agents_franchise')->where('is_deleted', '0')->count();
        $view['postarea'] = DB::table('agents_area')->where('is_deleted', '0')->count();
        $view['postcity'] = DB::table('agents_city')->where('is_deleted', '0')->count();
        $view['poststate'] = DB::table('agents_state')->where('is_deleted', '0')->count();
        return view('admin.pages.dashboard', $view);
    }

    /* For all users */
    public function users()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.usersList');
        //dd($user);
    }

    /* For change password view */
    public function changepassword()
    {
        $view['user'] = auth()->guard('admin')->user();
        return view('admin.pages.passwordchange', $view);
    }

    /* For area view */
    public function areas()
    {
        //echo 'welcome dashboard';
        $user = auth()->guard('admin')->user();
        return view('admin.pages.area.areaList');
        //dd($user);
    }

    /* Show date and time */
    public function mmddyyy($date = Null)
    {
        $formate = "";
        if (!empty($date) && $date != "0000-00-00 00:00:00") :
            $formate = date('M d Y', strtotime($date));
        endif;
        return $formate;
    }

    /* Get area list */
    public function getAreaList()
    {

        $state = new State;
        $list = $state->getAreaList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list['result'] as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->area_name) ? ucwords(strtolower($result->area_name)) : '';
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';
            //$row[] ='<a href="" <span class="label label-success"> <i class="fa fa-edit"></i> Edit</span></a>';
            $row[] =  '<a class="btn btn-success" href="editArea/' . $result->area_id . '">
						<i class="fa fa-pencil fa-xs"></i></a>
						<button class="btn btn-danger" onClick ="confirm_function(\'' . $result->area_id . '\',\'Are you sure, you want to delete this record? \');">
						<i class="fa fa-trash-o fa-xs"></i></button>';
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : '',
            "recordsTotal" => intval($list['num']),
            "recordsFiltered" => intval($list['num']),
            "data" => $data,
        );
        echo json_encode($output);
    }

    /* Delete area */
    public function deleteArea(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_area')->where(array('area_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
            //$DbModel->update_service($ids_arr,array('paid_status'=>'1'));
            endif;
        }
    }

    /* For post details */
    public function postdetails($userid = null, $roleid = null, $post_id = null)
    {
        $user = new User;
        $view['user'] = $user->getDetailsByEmailOrId(array('id' => $userid));
        $post = new Post;
        $view['post'] = $post->getDetailsBypostid(array('agents_posts.post_id' => $post_id));
        if ($view['post']->agents_users_role_id == 2) {
            $view['types'] = 'Buy';
        } else {
            $view['types'] = 'Sell';
        }
        return view('admin.pages.post.postdetails', $view);
    }

    /* For All show post in admin */
    public function Post($value = '')
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.post.postlist');
    }

    /* For get all posts show in admin. */
    public function getPostList($value = '')
    {
        $postlist = new Post;
        $list = $postlist->getPostList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list['result'] as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->posttitle) ? ucwords(strtolower($result->posttitle)) : '';
            $row[] = isset($result->address1) ? $result->address1 : '';
            $row[] = isset($result->name) ? $result->name : '';
            $row[] = isset($result->role_name) ? $result->role_name : '';
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';

            $row[] =  $result->state == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->post_id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->post_id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';

            $row[] = '<a class="btn btn-info" href="' . url("/agentadmin/post/details/") . '/' . $result->agents_user_id . '/' . $result->agents_users_role_id . '/' . $result->post_id . '">View</a>
					 <button class="btn btn-danger" onClick ="confirm_function(\'' . $result->post_id . '\',\'Are you sure, you want to delete this record? ? \');">Delete</button>';
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : '',
            "recordsTotal" => intval($list['num']),
            "recordsFiltered" => intval($list['num']),
            "data" => $data,
        );
        echo json_encode($output);
    }

    /* For delete post */
    public function deletePost(Request $request)
    {
        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_posts')->where(array('post_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
            endif;
        }
    }
}
