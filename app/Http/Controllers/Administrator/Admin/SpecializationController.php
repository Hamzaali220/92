<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Userdetails;

class SpecializationController extends Controller
{

    /* For specialization view in admin */
    public function specializations()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.specialization.specializationList');
    }

    /* For specialization view */
    public function specialization($id = null)
    {
        $user = auth()->guard('admin')->user();
        $result = array();
        $Userdetails = new Userdetails;
        if (!empty($id)) :
            $result = $Userdetails->getSpecializationByAny(array('skill_id' => $id));
        endif;
        //echo '<pre>'; print_r($result); die;
        $view = array(
            'result' => $result
        );
        return view('admin.pages.specialization.specialization', $view);
    }

    /* For store specialization */
    public function save(Request $request)
    {
        // $users = DB::table('agents_users_agent_skills')->select('skill')->where('skill','=', $request->skill)->get();
        // if(!$users){
            $rules = array(
                'skill'  => 'required',
            );
            $input_arr = array(
                'skill' => $request->input('skill'),
            );
            $validator = Validator::make($input_arr, $rules);
            if ($validator->fails()) :
                return Redirect::back()->withErrors($validator)->withInput();
            else :
                $skill_id = $request->input('skill_id') ? $request->input('skill_id') : '';

                $data_arr = array(
                    'skill' => $request->input('skill'),
                    'is_deleted' => '0',
                    'updated_at' => date('Y-m-d H:i:s')
                );
                if (!empty($skill_id)) :
                    DB::table('agents_users_agent_skills')->where(array('skill_id' => $skill_id))->update($data_arr);
                    return Redirect::back()->with('success', 'Skills / Specialization has been updated successfully.');
                else :
                    $data_arr['created_at'] = date('Y-m-d H:i:s');
                    DB::table('agents_users_agent_skills')->insertGetId($data_arr);
                    return Redirect::back()->with('success', 'Skills / Specialization has been created successfully.');
                endif;
                return Redirect::back()->with('dbError', 'Oops Something went wrong !!');
            endif;
        // }
        // else{
        //     return Redirect::back()->with('msg', 'Already exist')->withInput();
        // }
    }

    /* For get date and time */
    public function mmddyyy($date = Null)
    {
        $formate = "";
        if (!empty($date) && $date != "0000-00-00 00:00:00") :
            $formate = date('M d Y', strtotime($date));
        endif;
        return $formate;
    }

    /* For get specialization details in admin side. */
    public function getSpecializationList()
    {

        $Userdetails = new Userdetails;
        $list = $Userdetails->getSpecializationList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list['result'] as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->skill) ? ucwords(strtolower($result->skill)) : '';
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';

            if ((isset(session('user_access_data')->skillchange) && session('user_access_data')->skillchange == 1) or session("userid") == 1) {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->skill_id . '\',0,\'Are you sure, you want to deactive this record? \');">Active</button>' :
                    '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->skill_id . '\',1,\'Are you sure, you want to active this record? \');">Deactive</button>';
            } else {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">Deactive</button>';
            }

            if ((isset(session('user_access_data')->skillchange) && session('user_access_data')->skillchange == 1) or session("userid") == 1) {
                $row[] =  '<a class="btn btn-success" href="' . url("/agentadmin/specialization/") . '/' . $result->skill_id . '">
						<i class="fa fa-pencil fa-xs"></i></a>
						<button class="btn btn-danger" onClick ="confirm_function(\'' . $result->skill_id . '\',\'Are you sure, you want to delete this record?\');">
						<i class="fa fa-trash-o fa-xs"></i></button>';
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

    /* For delete specialization */
    public function deleteSpecialization(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_users_agent_skills')->where(array('skill_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
                $value = $request->input('value');
                DB::table('agents_users_agent_skills')->where(array('skill_id' => $id))->update(array('status' => $value));
            endif;
        }
    }
}
