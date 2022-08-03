<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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
        /*post count*/
        $query = DB::table('agents_posts as a')->select('a.*', 'b.name', 'c.role_name');
        $query->Join('agents_users_details as b', 'b.details_id', '=', 'a.agents_user_id');
        $query->Join('agents_users_roles as c', 'c.role_id', '=', 'a.agents_users_role_id');
        $query->where('a.is_deleted', '0');
        $view['postcount'] = $query->count();
        //$view['postcount'] = DB::table('agents_posts')->where('is_deleted','0')->count();
        /*post count*/
        /*post question*/
        $query = DB::table('agents_question as a')->select('a.*', 'b.role_name');
        $query->Join('agents_users_roles as b', 'b.role_id', '=', 'a.question_type');
        $query->where(array('a.is_deleted' => '0', 'a.add_by' => '1', 'a.add_by_role' => '1'));
        $view['post_question'] = $query->count();
        //$view['post_question'] = DB::table('agents_question')->where('is_deleted','0')->count();
        /*post question*/
        $view['postsecurty_question'] = DB::table('agents_securty_question')->where('is_deleted', '0')->count();
        $view['post_certifications'] = DB::table('agents_certifications')->where('is_deleted', '0')->count();
        $view['post_franchise'] = DB::table('agents_franchise')->where('is_deleted', '0')->count();
        $view['postarea'] = DB::table('agents_area')->where('is_deleted', '0')->count();
        $view['postcity'] = DB::table('agents_city')->where('is_deleted', '0')->count();
        $view['poststate'] = DB::table('agents_state')->where('is_deleted', '0')->count();

        $email = $user['email'];
        $id = $user['id'];
        if ($id == 1) {
            $data = DB::table('agents_users_details')->select('name')->where('details_id', '=', $id)->first();
            session()->regenerate();
            session(['userid' => $id]);
            session(['username' => 'Administrator']);
        } else {
            $data = DB::table('agents_employee')->select('*')->where('email', $email)->first();

            session()->regenerate();
            session(['userid' => $data->email]);
            session(['username' => $data->empname]);
            session(['user_access_data' => $data]);
        }
        // $data['view']=$view;
        // $view['user']=$user;

        return view('admin.pages.dashboard', $view);
    }

    /* For suer list inside the admin */
    public function users()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.usersList');
    }

    public function conent()
    {
        // $user = auth()->guard('admin')->user();
        $words = DB::table('agents_bad_contents')->first();
        return view('admin.pages.post.validatepost', ['words' => $words]);
    }
    public function yash()
    {
        return ["deh chaate.. deh koni.."];
    }

    public function updatewords(Request $request)
    {

        $word = $request->input('words');
        DB::table('agents_bad_contents')->where(array('id' => '1'))->update(array('words' => $word));

        $words = DB::table('agents_bad_contents')->first();
        return view('admin.pages.post.validatepost', ['words' => $words, 'success' => 'ok']);
    }

    /* For reset password view */
    public function changepassword()
    {
        $view['user'] = auth()->guard('admin')->user();
        return view('admin.pages.passwordchange', $view);
    }

    /* For area list view iside the admin */
    public function areas()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.area.areaList');
    }

    /* For date and time */
    public function mmddyyy($date = Null)
    {
        $formate = "";
        if (!empty($date) && $date != "0000-00-00 00:00:00") :
            $formate = date('M d Y', strtotime($date));
        endif;
        return $formate;
    }

    /* Get area list info */
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

    /* For delete area inside the admin */
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

    /* For post details inside the admin */
    public function postdetails($userid = null, $roleid = null, $post_id = null)
    {
        $user = new User;
        $view['user'] = $user->getDetailsByEmailOrId(array('id' => $userid));
        $post = new Post;
        $view['post'] = $post->getDetailsBypostid(array('agents_posts.post_id' => $post_id));

        // list all the agents for select box
        $agentslist = DB::table('agents_users as au')
            ->join('agents_users_details as ad', 'au.id', '=', 'ad.details_id')
            ->select('id', 'name')
            ->where(['au.agents_users_role_id' => 4, 'au.agent_status' => 1])
            ->get();

        // get the selected agent
        $selectedagentdetail = DB::table('agents_users as au')
            ->leftJoin('agents_users_details as ad', 'au.id', '=', 'ad.details_id')
            ->leftJoin('agents_posts as ap', 'ap.applied_user_id', '=', 'au.id')
            ->select('id', 'name')
            ->where(['ap.post_id' => $post_id])
            ->first();

        // get sell details
        $selldetails = DB::table('agents_selldetails')
            ->select('*')
            ->where(['post_id' => $post_id, 'status' => 1])
            ->first();

        $view['selldetails'] = $selldetails;

        $view['selectedagentdetail'] = $selectedagentdetail;


        $view['agentslist'] = $agentslist;
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
            $row[] = isset($result->created_at) ? est_std_datetime($result->created_at) : '';

            if ((isset(session('user_access_data')->postlistchange) && session('user_access_data')->postlistchange == 1) or session("userid") == 1) {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->post_id . '\',0,\'Are you sure, you want to deactive this record? \');">Active</button>' :
                    '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->post_id . '\',1,\'Are you sure, you want to active this record? \');">Deactive</button>';
            } else {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">Deactive</button>';
            }

            //print_r($result);exit;

            /* $row[] = '<a class="btn btn-info" href="'.url("agentadmin/conversation/conversationdetails").'/'.$result->conversation_id.'">View</a>
					 <button class="btn btn-danger" onClick ="confirm_function(\''.$result->post_id.'\',\'Are you sure, you want to delete this record?\');">Delete</button>';  */

            if ((isset(session('user_access_data')->postlistchange) && session('user_access_data')->postlistchange == 1) or session("userid") == 1) {
                $row[] = '<a class="btn btn-info" href="' . url("/agentadmin/post/details/") . '/' . $result->agents_user_id . '/' . $result->agents_users_role_id . '/' . $result->post_id . '">View</a>
					 <button class="btn btn-danger" onClick ="confirm_function(\'' . $result->post_id . '\',\'Are you sure, you want to delete this record?\');">Delete</button>';
            } else {
                $row[] = 'No access';
            }

            $data[] = $row;
        }  //exit;

        $output = array(
            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : '',
            "recordsTotal" => intval($list['num']),
            "recordsFiltered" => intval($list['num']),
            "data" => $data,
        );

        echo json_encode($output);
    }

    /* For delete post in the admin */
    public function deletePost(Request $request)
    {
        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_posts')->where(array('post_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
                $value = $request->input('value');
                DB::table('agents_posts')->where(array('post_id' => $id))->update(array('status' => $value));
            endif;
        }
    }

    /*Select agent for the post*/
    public function selectagent($postid, $agentid)
    {
        // update post applied_user_id with agentid
        $updated = DB::table('agents_posts')->where('post_id', $postid)->update(['applied_user_id' => $agentid]);
        if ($updated) {
            $view['c_status'] = 'success';
            $view['c_message'] = 'Agent selected successfully';
        } else {
            $view['c_status'] = 'failed';
            $view['c_message'] = 'Failed to select agents for the post';
        }

        return redirect(url()->previous())->with($view);
    }

    /*Select agent for the post*/
    public function selectagentbyadmin(Request $request)
    {
        $agentid = $request->input('saagent_id');
        $postid = $request->input('sapost_id');

        $updated = DB::table('agents_posts')->where('post_id', $postid)->update(['applied_user_id' => $agentid]);

        // update agent
        DB::table('agents_posts')->where('post_id', $postid)->update(['applied_user_id' => $agentid]);

        if ($updated) {
            $view['c_status'] = 'success';
            $view['c_message'] = 'Agent selected successfully';
        } else {
            $view['c_status'] = 'failed';
            $view['c_message'] = 'Failed to select agents for the post';
        }

        return redirect(url()->previous())->with($view);
    }
}
