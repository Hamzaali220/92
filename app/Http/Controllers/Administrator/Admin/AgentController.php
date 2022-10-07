<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\State;
use App\Models\ClosingDateQuery;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;

class AgentController extends Controller
{
    /* For shwo agents list in admin. */
    public function agents()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.agent.agentList');
    }

    /* Agent delete inside the admin */
    public function agent($id = null)
    {
        $user = auth()->guard('admin')->user();
        $result = array();
        $state = new State;
        $Users = new User;
        $agentskills = new Agentskills();
        $city =  $state->getCityByAny(array('is_deleted' => '0'));
        $states =  $state->getStateByAny(array('is_deleted' => '0'));
        $area =  $state->getAreaByAny(array('is_deleted' => '0'));
        $skills = $agentskills->getskillsByAny(array('is_deleted' => '0'));
        if (!empty($id)) :
            $result = $Users->getDetailsByEmailOrId(array('id' => $id));
        endif;

        $view = array(
            'result' => $result,
            'city' => $city,
            'states' => $states,
            'area' => $area,
            'skills' => $skills
        );

        return view('admin.pages.agent.agent', $view);
    }

    /* For agents view */
    public function agentsview($id = null, $role = null)
    {
        // $user = auth()->guard('admin')->user();
        $user = new User;
        $view['user'] = $user->getDetailsByEmailOrId(array('id' => $id));
        $view['userdetails'] = $user->GetAllTableJoinUserDataByAnyFirst(array('agents_users.id' => $id));

        if ($view['userdetails']->skills != null) :
            $skillsarray = explode(',', $view['userdetails']->skills);
            $view['userdetails']->skills = DB::table('agents_users_agent_skills')
                ->whereIn('skill_id', $skillsarray)
                ->get();
        endif;

        if ($view['userdetails']->specialization != null) :
            $specialization_array = explode(',', $view['userdetails']->specialization);
            $specialization = DB::table('agents_users_agent_skills')
                ->whereIn('skill_id', $specialization_array)->get();
            $all_specializations = array();
            foreach ($specialization as $single_specialization) {
                $all_specializations[] = $single_specialization->skill;
            }

            $view['userdetails']->specialization = implode(',', $all_specializations);
        endif;

        if ($view['userdetails']->franchise != null && $view['userdetails']->franchise != 'other') :
            $franchise = DB::table('agents_franchise')->select('franchise_name')
                ->where('franchise_id', $view['userdetails']->franchise)
                ->first();
            $view['userdetails']->franchise = $franchise->franchise_name;
        endif;

        if ($view['userdetails']->area != null) :
            $areaarray = explode(',', $view['userdetails']->area);
            $view['userdetails']->area = DB::table('agents_area')
                ->whereIn('area_id', $areaarray)
                ->get();
        endif;

        if ($view['userdetails']->city_id != null) {
            $city_data = DB::table('agents_city')->where('city_id', $view['userdetails']->city_id)->get();
            $view['userdetails']->city_name = $city_data[0]->city_name;
        } else {
            $view['userdetails']->city_name = "-";
        }

        if ($view['userdetails']->certifications != null) :
            $certificationsarray = explode(',', $view['userdetails']->certifications);
            $view['userdetails']->certifications = DB::table('agents_certifications')
                ->whereIn('certifications_id', $certificationsarray)
                ->get();
        endif;
        $view['role'] = $role;
        // echo '<pre>';
        // print_r($view['userdetails']);
        // die;
        return view('admin.pages.agent.view', $view);
    }

    public function save(Request $request)
    {
        $rules = array(
            'name'  => 'required',
            'email'  => 'required|email',
            'address'  => 'required',
            'phone'  => 'required',
            'city'  => 'required',
            'state'  => 'required',
        );

        $input_arr = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
        );

        $validator = Validator::make($input_arr, $rules);
        if ($validator->fails()) :
            return Redirect::back()->withErrors($validator)->withInput();
        else :
            $id = $request->input('id') ? $request->input('id') : '';

            $data_arrUser = array(
                'agents_users_role_id' => '4',
                'email' => $request->input('email'),
                //'password'=>Hash::make('123123'),
                //'created_at'=>date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                //'status'=>'1',
                //'step'=>'3',
                'is_deleted' => '0',
            );

            $userId = DB::table('agents_users')->where(array('id' => $id))->update($data_arrUser);
            if (!empty($id)) :

                $data_arr = array(
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'address2' => $request->input('address2'),
                    'phone' => $request->input('phone'),
                    'city_id' => $request->input('city'),
                    'state_id' => $request->input('state'),
                    'phone_work' => $request->input('phone_work'),
                    'phone_home' => $request->input('phone_home'),
                    'fax_no' => $request->input('phone'),
                    'zip_code' => $request->input('city'),
                );
                $Iddetails = DB::table('agents_users_details')->where(array('details_id' => $id))->update($data_arr);
                return Redirect::back()->with('success', 'User profile has been updated successfully.');
            endif;
            return Redirect::back()->with('dbError', 'Oops Something went wrong !!');
        endif;
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

    public function checkDocument()
    {
        $user = new User;
        $userDetails[] = $user->getDetailsByEmailOrId(array('id' => $_REQUEST['userId']));
        $userDetails['userdetails'] = $user->GetAllTableJoinUserDataByAnyFirst(array('agents_users.id' => $_REQUEST['userId']));
        echo json_encode($userDetails);
        exit;
    }

    /* For get agent list */
    public function getAgentList()
    {
        $post = new Post();
        $Userdetails = new Userdetails;
        $_REQUEST['roleId'] = "4";
        $list = $Userdetails->getAgentList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);

        $data = array();
        $no = $_REQUEST['start'];

        foreach ($list['result'] as $result) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->name) ? ucwords(strtolower($result->name)) : '';
            $row[] = isset($result->email) ? ucfirst(strtolower($result->email)) : '';
            $row[] = isset($result->address) ? ucfirst(strtolower($result->address)) : '';
            $row[] = isset($result->phone) ? ucfirst(strtolower($result->phone)) : '';
            //$row[] =isset($result->created_at)?$this->mmddyyy($result->created_at):'';

            if (isset(session('user_access_data')->agentchange) && session('user_access_data')->agentchange == 1 or session("userid") == 1) {
                $row[] = '<a class="btn btn-warning" href="' . url("/agentadmin/agents/closingdatereport/") . '/' . $result->id . '">	Click Here</a>';
            } else {
                $row[] = 'No access';
            }

            if ($result->contract_verification == 2) {
                $verification = "Verified";
                $clickEvent = '#';
            } else if ($result->contract_verification == 1) {
                $verification = "Not-Verified";
                $clickEvent = 'checkDocument(' . $result->id . ')';
            } else {
                $verification = "In-Complete Profile";
                $clickEvent = '#';
            }

            if (isset(session('user_access_data')->agentchange) && session('user_access_data')->agentchange == 1 or session("userid") == 1) {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                    '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
            } else {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">Deactive</button>';
            }

            if (isset(session('user_access_data')->agentchange) && session('user_access_data')->agentchange == 1 or session("userid") == 1) {


                $post_count_result = $post->AppliedPostListGetForAgents(
                    0,
                    array(
                        'agents_users_conections.to_id' => $result->id,
                        'agents_users_conections.to_role' => 4,
                        'agents_posts.agents_users_role_id' =>  null
                    ),
                    array(
                        'agents_users_conections.from_id' => $result->id,
                        'agents_users_conections.from_role' => 4,
                        'agents_posts.agents_users_role_id' =>  null
                    ),
                    null
                );


                $post_count = count($post_count_result['result']);

                $active_post_btn = '<a class="btn btn-warning" href="' . url("/agentadmin/agents/activepost/") . '/' . $result->id . '/' . $result->agents_users_role_id . '">	Active Post</a>';
                if ($post_count == 0) {
                    $active_post_btn = '<a class="btn btn-warning disabled" href="#">Active Post</a>';
                }
                $row[] =
                    $active_post_btn . '
				<a class="btn btn-info" href="' . url("/agentadmin/agents/view/") . '/' . $result->id . '">	View</a>
				<button class="btn btn-danger" onClick ="confirm_function(\'' . $result->id . '\',\'Are you sure, you want to delete this record? \');">Delete</button>
				<button class="btn btn-info" ' . $clickEvent . ' >' .
                    $verification
                    . '</button>';
            } else {
                $row[] = 'No access';
            }


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


    public function getClosingDateReport(Request $request, $id)
    {
        $report = new ClosingDateQuery;
        //echo "<pre>";print_r($report);exit;
        $_REQUEST['roleId'] = "4";
        $formData = $request->input();
        //print_r($formData);
        $postConditions = array();
        $buyerorsellerdetails = array();
        $normalConditions = array();
        if ($formData['search']['value'] != '') {
            $postConditions[] = ['posttitle', 'LIKE', '%' . $formData['search']['value'] . '%'];
            $postConditions[] = ['agent_select_date', 'LIKE', '%' . $formData['search']['value'] . '%'];

            $postConditions[] = ['closing_date', 'LIKE', '%' . $formData['search']['value'] . '%'];

            $buyerorsellerdetails[] = ['name', 'LIKE', '%' . $formData['search']['value'] . '%'];

            // $normalConditions[] = ['created_at','LIKE','%'.$formData['search']['value'].'%'];
        }
        $totalRecords = $report
            ->where([['agent_id', '=', $id]])
            // ->orwhere($normalConditions)
            ->with(['post' => function ($query) use ($postConditions) {
                foreach ($postConditions as $key => $value) {
                    if ($key == 0) {
                        $query->where($value[0], $value[1], $value[2]);
                    } else {
                        $query->where($value[0], $value[1], $value[2]);
                    }
                }
            }, 'agentdetails', 'buyerorsellerdetails' => function ($query) use ($buyerorsellerdetails) {
                foreach ($buyerorsellerdetails as $key => $value) {
                    if ($key == 0) {
                        $query->where($value[0], $value[1], $value[2]);
                    } else {
                        $query->where($value[0], $value[1], $value[2]);
                    }
                }
            }])
            ->get()
            ->count();
        $reportData = $report

            ->where([['agent_id', '=', $id]])
            ->orwhere($normalConditions)
            ->with(['post' => function ($query) use ($postConditions) {
                foreach ($postConditions as $key => $value) {
                    if ($key == 0) {
                        $query->where($value[0], $value[1], $value[2]);
                    } else {
                        $query->where($value[0], $value[1], $value[2]);
                    }
                }
            }, 'agentdetails', 'buyerorsellerdetails' => function ($query) use ($buyerorsellerdetails) {
                foreach ($buyerorsellerdetails as $key => $value) {
                    if ($key == 0) {
                        $query->where($value[0], $value[1], $value[2]);
                    } else {
                        $query->where($value[0], $value[1], $value[2]);
                    }
                }
            }])
            ->skip($_REQUEST['start'])
            ->take($_REQUEST['length'])
            ->get()
            ->toarray();
        $data = array();
        $no = $_REQUEST['start'];
        //dd(DB::getQueryLog());
        foreach ($reportData as $result) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result['post']['posttitle']) ? ucwords(strtolower($result['post']['posttitle'])) : '';
            $row[] = isset($result['buyerorsellerdetails']['name']) ? ucfirst(strtolower($result['buyerorsellerdetails']['name'])) : '';
            $row[] = isset($result['post']['agent_select_date']) ? date("d-m-Y", strtotime($result['post']['agent_select_date'])) : '';
            $row[] = isset($result['post']['closing_date']) ? date("d-m-Y", strtotime($result['post']['closing_date'])) : '';
            $row[] = isset($result['created_at']) ? date("d-m-Y", strtotime($result['created_at'])) : '';
            $row[] = isset($result['comments']) ? ucfirst(strtolower($result['comments'])) : '';
            // $row[] =  $result->status==1 ? '<button class="btn btn-success" onClick ="status_change_function(\''.$result->id.'\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
            // '<button class="btn btn-danger" onClick ="status_change_function(\''.$result->id.'\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
            // $row[] =
            // '<a class="btn btn-warning" href="'.url("/agentadmin/agents/activepost/").'/'.$result->id.'/'.$result->agents_users_role_id.'">	Active Post</a>
            //  <a class="btn btn-info" href="'.url("/agentadmin/agents/view/").'/'.$result->id.'">	View</a>
            //  <button class="btn btn-danger" onClick ="confirm_function(\''.$result->id.'\',\'Are you sure, you want to delete this record? \');">Delete</button>
            //  <button class="btn btn-info" onclick="'.$clickEvent.'" >'.
            //           $verification
            //  .'</button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : '',
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function closingdatereport($id = null)
    {
        $user = auth()->guard('admin')->user();
        $data['id'] = $id;
        $post = new Post();
        $post_result_data = $post->AppliedPostListGetForAgents(
            0,
            array(
                'agents_users_conections.to_id' => $id,
                'agents_users_conections.to_role' => 4,
                'agents_posts.agents_users_role_id' =>  null
            ),
            array(
                'agents_users_conections.from_id' => $id,
                'agents_users_conections.from_role' => 4,
                'agents_posts.agents_users_role_id' =>  null
            ),
            null
        );
        // dd($post_result_data);
        $data['post_list'] = $post_result_data;
        return view('admin.pages.agent.closingdatereport', $data);
    }

    public function changeDocStatus()
    {
        $status = $_REQUEST['status'];
        $userId = $_REQUEST['userId'];
        $user = new User;
        $userDetails = $user->getDetailsByEmailOrId(array('id' => $userId));
        $updateArray = array();
        if ($status == 0) {
            $updateArray['contract_verification'] =  $status;
            $updateArray['statement_document'] =  '';
            $statusText = 'Rejected';
            $emaildata['name'] = ucwords($userDetails->name);
            $emaildata['email'] = $userDetails->email;
            $emaildata['html'] = '<div><h3>Hello ' . $emaildata['name'] . ',</h3><br><p>
				Your signed contrat has been rejected by the Admin. Please upload your signed contract again.';
            Mail::send([], [], function ($message) use ($emaildata) {
                $message->to($emaildata['email'], $emaildata['name'])
                    ->subject($emaildata['name'] . ' Rejction of Statement document')
                    ->setBody($emaildata['html'], 'text/html');
                $message->from('92agent@92agents.com', '92agent@92agents.com');
            });
        } else {
            $updateArray['contract_verification'] =  $status;
            $statusText = 'Accepted';
        }
        DB::table('agents_users_details')
            ->where(array('details_id' => $userId))
            ->update($updateArray);
        //echo "Updated";exit;
        return Redirect::back()->with('Info', "User's signed contract has been " . $statusText . " successfully.");
    }

    /* For delete agents */
    public function deleteAgent(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_users')->where(array('id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
                $value = $request->input('value');
                DB::table('agents_users')->where(array('id' => $id))->update(array('status' => $value));
            endif;
        }
    }

    /* For agent active post */
    public function agentactivepost($userid = null, $roleid = null)
    {
        $user = new User;
        $view['user'] = $user->getDetailsByEmailOrId(array('id' => $userid, 'role_id' => $roleid));
        return view('admin.pages.agent.activepost', $view);
    }

    /* Show the list of pending invoices */
    public function pendinginvoices()
    {
        # load invoices
        $invoice_list = DB::table('agents_selldetails as as')
            ->join('agents_posts as ap', 'as.post_id', '=', 'ap.post_id')
            ->where(['as.status' => 1])
            ->paginate(10);
        $view['invoices'] = $invoice_list;
        return view('admin.pages.post.pending-invoices', $view);
    }
}
