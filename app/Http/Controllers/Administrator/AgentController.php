<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\State;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /* For shwo agents list in admin. */
    public function agents()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.agent.agentList');
    }

    /* For agents info get */
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
            $specialization = DB::table('agents_users_agent_skills')->select('skill')
                ->where('skill_id', $view['userdetails']->specialization)
                ->first();
            $view['userdetails']->specialization = $specialization->skill;
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

    /* for save agents details */
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

    /* For date and time get */
    public function mmddyyy($date = Null)
    {
        $formate = "";
        if (!empty($date) && $date != "0000-00-00 00:00:00") :
            $formate = date('M d Y', strtotime($date));
        endif;
        return $formate;
    }

    /* For get agent info for agent lsit */
    public function getAgentList()
    {
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
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';
            $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';

            $row[] =
                '<a class="btn btn-warning" href="' . url("/agentadmin/agents/activepost/") . '/' . $result->id . '/' . $result->agents_users_role_id . '">	Active Post</a>
			 <a class="btn btn-info" href="' . url("/agentadmin/agents/view/") . '/' . $result->id . '">	View</a>
			 <button class="btn btn-danger" onClick ="confirm_function(\'' . $result->id . '\',\'Are you sure, you want to delete this record? \');">Delete</button>';

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

    /* Delete agent */
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
}
