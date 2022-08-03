<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\State;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\User;

class SellerbuyerControllor  extends Controller
{

    /* For seller buyer view inside the admin */
    public function sellerbuyers()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.sellerbuyer.sellerbuyerList');
    }
    public function newsellerbuyers()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.report.newuserregister');
    }

    /* For seller buyer view*/
    public function sellerbuyer($id = null)
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
        return view('admin.pages.sellerbuyer.sellerbuyer', $view);
    }

    /* for get info for seller buyer view */
    public function sellerbuyerview($id = null)
    {
        // $user = auth()->guard('admin')->user();
        $user = new User;
        $view['user'] = $user->getDetailsByEmailOrId(array('id' => $id));
        $view['userdetails'] = $user->GetAllTableJoinUserDataByAnyFirst(array('agents_users.id' => $id));
        if ($view['userdetails']->area != null) :
            $areaarray = explode(',', $view['userdetails']->area);
            $view['userdetails']->area = DB::table('agents_area')
                ->whereIn('area_id', $areaarray)
                ->get();
        endif;

        if ($view['user']->agents_users_role_id == 2) {
            $view['types'] = 'Buy';
        } else {
            $view['types'] = 'Sell';
        }

        if ($view['userdetails']->city_id != null) {
            $city_data = DB::table('agents_city')->where('city_id', $view['userdetails']->city_id)->get();
            $view['userdetails']->city_name = $city_data[0]->city_name;
        } else {
            $view['userdetails']->city_name = "-";
        }

        return view('admin.pages.sellerbuyer.view', $view);
    }

    /* For save seller and buyers */
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
                //'agents_users_role_id'=>'4',
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

    /* For Datatable sellerBuyer listing */
    public function getSellerbuyerList()
    {

        $Userdetails = new Userdetails;
        $_REQUEST['roleId'] = [2, 3];
        $list = $Userdetails->getSellerBuyerList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);

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
            $row[] = '<button class="btn bg-purple margin">' . (isset($result->role_name) ? ucfirst(strtolower($result->role_name)) : '') . '</button>';


            if (isset(session('user_access_data')->bschange) && session('user_access_data')->bschange == 1  or session("userid") == 1) {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                    '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
            } else {
                $row[] =  $result->status == 1 ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">Deactive</button>';
            }
            // <a class="btn btn-success" href="'.url("/agentadmin/sellerbuyer").'/'.$result->id.'">	Edit</a>
            if (isset(session('user_access_data')->bschange) && session('user_access_data')->bschange == 1  or session("userid") == 1) {
                $row[] = '<a class="btn btn-warning" href="' . url("/agentadmin/sellerbuyer/postlist/") . '/' . $result->id . '/' . $result->agents_users_role_id . '">	Posts </a>
						<a class="btn btn-info" href="' . url("/agentadmin/sellerbuyer/view/") . '/' . $result->id . '">	View</a>
						<button class="btn btn-danger" onClick ="confirm_function(\'' . $result->id . '\',\'Are you sure, you want to delete this record? \');">Delete</button>';
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

    public function newSellerbuyerList()
    {

        $Userdetails = new Userdetails;
        $_REQUEST['roleId'] = [2, 3];
        $list = $Userdetails->newSellerBuyerList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);

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
            $row[] = '<button class="btn bg-purple margin">' . (isset($result->role_name) ? ucfirst(strtolower($result->role_name)) : '') . '</button>';
            $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
            // <a class="btn btn-success" href="'.url("/agentadmin/sellerbuyer").'/'.$result->id.'">	Edit</a>
            $row[] =
                '<a class="btn btn-warning" href="' . url("/agentadmin/sellerbuyer/postlist/") . '/' . $result->id . '/' . $result->agents_users_role_id . '">	Posts </a>
			 <a class="btn btn-info" href="' . url("/agentadmin/sellerbuyer/view/") . '/' . $result->id . '">	View</a>
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

    /* For delete seller and buyer */
    public function deleteSellerbuyer(Request $request)
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

    /* For active inactive post's */
    public function activeInactivePost(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_users')->where(array('post_id' => $id))->update(array('state' => '1'));
            elseif ($tag == 'status') :
                $value = $request->input('value');
                DB::table('agents_posts')->where(array('post_id' => $id))->update(array('status' => $value));
            endif;
        }
    }

    /* For seller buyer post list get info */
    public function sellerbuyerpostlist($userid = null, $roleid = null)
    {
        $user = new User;
        $view['user'] = $user->getDetailsByEmailOrId(array('id' => $userid, 'role_id' => $roleid));
        return view('admin.pages.sellerbuyer.postlist', $view);
    }
}
