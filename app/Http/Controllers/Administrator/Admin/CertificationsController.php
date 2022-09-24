<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Userdetails;

class CertificationsController extends Controller
{

    /* For certifications view */
    public function Certifications()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.certifications.certificationslist');
    }

    /* For get certification info */
    public function getCertificationsList()
    {

        $Userdetails = new Userdetails;
        $list = $Userdetails->getCertificationsList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list['result'] as $result) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->certifications_name) ? ucwords(strtolower($result->certifications_name)) : '';
            $row[] = isset($result->certifications_description) ? $result->certifications_description : '';
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';

            if ((isset(session('user_access_data')->certificationchange) && session('user_access_data')->certificationchange == 1) or session("userid") == 1) {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->certifications_id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                    '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->certifications_id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
            } else {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">Deactive</button>';
            }

            if ((isset(session('user_access_data')->certificationchange) && session('user_access_data')->certificationchange == 1) or session("userid") == 1) {
                $row[] = '<a class="btn btn-success" href="' . url("/agentadmin/certificationsaddedit/") . '/' . $result->certifications_id . '"><i class="fa fa-pencil fa-xs"></i></a>
					 <button class="btn btn-danger" onClick ="confirm_function(\'' . $result->certifications_id . '\',\'Are you sure, you want to delete this record? \');"><i class="fa fa-trash-o fa-xs"></i></button>';
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

    /* For certification add and edit */
    public function Certificationsaddedit($id = null)
    {
        $user = auth()->guard('admin')->user();
        $result = array();
        $Userdetails = new Userdetails;
        if (!empty($id)) :
            $result = $Userdetails->getCertificationsByAny(array('certifications_id' => $id));
        endif;

        $view = array(
            'result' => count($result) > 0 ? $result[0] : ''
        );
        $view['tag'] = count($result) != 0 ? 'Edit' : 'Add';
        return view('admin.pages.certifications.certifications', $view);
    }

    /* For certification store */
    public function save(Request $request)
    {
        $rules = array(
            'certifications_name'  => 'required',
            'certifications_description'  => 'required',
        );
        $input_arr = array(
            'certifications_name' => $request->input('certifications_name'),
            'certifications_description' => $request->input('certifications_description'),
        );
        $validator = Validator::make($input_arr, $rules);
        if ($validator->fails()) :
            return Redirect::back()->withErrors($validator)->withInput();
        else :

            $certifications_id = $request->input('certifications_id') ? $request->input('certifications_id') : '';

            $data_arr = array(
                'certifications_name' => $request->input('certifications_name'),
                'certifications_description' => $request->input('certifications_description'),
                'is_deleted' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            );
            if (!empty($certifications_id)) :
                DB::table('agents_certifications')->where(array('certifications_id' => $certifications_id))->update($data_arr);
                return Redirect::back()->with('success', 'Certifications has been updated successfully.');
            else :
                $data_arr['created_at'] = date('Y-m-d H:i:s');
                DB::table('agents_certifications')->insertGetId($data_arr);
                return Redirect::back()->with('success', 'Certification has been created successfully.');
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

    /* For delete certification */
    public function deleteCertifications(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_certifications')->where(array('certifications_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
                $value = $request->input('value');
                DB::table('agents_certifications')->where(array('certifications_id' => $id))->update(array('status' => $value));
            endif;
        }
    }
}
