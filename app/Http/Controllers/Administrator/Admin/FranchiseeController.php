<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Userdetails;

class FranchiseeController extends Controller
{

    /* Show franchisee view. */
    public function Franchisees()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.franchisee.franchiseeList');
    }

    /* Get franchisee info */
    public function Franchisee($id = null)
    {
        $user = auth()->guard('admin')->user();
        $result = array();
        $Userdetails = new Userdetails;
        if (!empty($id)) :
            $result = $Userdetails->getFranchiseByAny(array('franchise_id' => $id), '1');
        endif;

        $view = array(
            'result' => $result
        );
        return view('admin.pages.franchisee.franchisee', $view);
    }

    /* For store franchisee */
    public function save(Request $request)
    {
        $franchise_id = $request->input('franchise_id') ? $request->input('franchise_id') : '';

        $rules = array(
            'franchise_name'  => 'required|string|unique:agents_franchise',
        );

        if ($franchise_id !== "") {
            $rules = array(
                'franchise_name'  => "required|string|unique:agents_franchise,franchise_name,$franchise_id,franchise_id",
            );
        }

        $input_arr = array(
            'franchise_name' => $request->input('franchise_name'),
        );

        $validator = Validator::make($input_arr, $rules);
        if ($validator->fails()) :
            return Redirect::back()->withErrors($validator)->withInput();
        else :


            $data_arr = array(
                'franchise_name' => $request->input('franchise_name'),
                'is_deleted' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            );

            if (!empty($franchise_id)) :
                DB::table('agents_franchise')->where(array('franchise_id' => $franchise_id))->update($data_arr);
                return Redirect::back()->with('success', 'The Franchisee has been updated successfully.');
            else :
                $data_arr['created_at'] = date('Y-m-d H:i:s');
                DB::table('agents_franchise')->insertGetId($data_arr);
                return Redirect::back()->with('success', 'The Franchisee has been created successfully.');
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

    /* For show franchisee list in admin */
    public function getFranchiseeList()
    {

        $Userdetails = new Userdetails;
        $list = $Userdetails->getFranchiseeList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list['result'] as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->franchise_name) ? ucwords(strtolower($result->franchise_name)) : '';
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';

            if ((isset(session('user_access_data')->franchchange) && session('user_access_data')->franchchange == 1) or session("userid") == 1) {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->franchise_id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                    '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->franchise_id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
            } else {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">Deactive</button>';
            }

            if ((isset(session('user_access_data')->franchchange) && session('user_access_data')->franchchange == 1) or session("userid") == 1) {
                $row[] =  '<a class="btn btn-success" href="franchisee/' . $result->franchise_id . '">
						<i class="fa fa-pencil fa-xs"></i></a>
						<button class="btn btn-danger" onClick ="confirm_function(\'' . $result->franchise_id . '\',\'Are you sure, you want to delete this record? \');">
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

    /* Delete franchisee */
    public function deleteFranchisee(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_franchise')->where(array('franchise_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
                $value = $request->input('value');
                DB::table('agents_franchise')->where(array('franchise_id' => $id))->update(array('status' => $value));
            endif;
        }
    }
}
