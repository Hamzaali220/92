<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function create(Request $request)
    {
        $success = Session::get('success');
        $error = Session::get('error');
        if ($success != null) {
            return view('admin.pages.employee.addemployee', ['success' => $success]);
        } else if ($error != null) {
            return view('admin.pages.employee.addemployee', ['error' => $error]);
        } else {
            return view('admin.pages.employee.addemployee');
        }
    }

    public function store(Request $request)
    {
        $email = $request->input('email');
        $mobile = $request->input('mobile');

        $checkEmail = DB::table('agents_employee')
            ->join('agents_users', 'agents_users.email', '=', 'agents_employee.email')
            ->select('*')
            ->where('agents_employee.email', '=', $email)
            ->get();

        if (count($checkEmail) > 0) {
            return Redirect::to("/agentadmin/employee/addemployee")->with(['error' => 'This email address is already exist.']);
        }


        $checkMobile = DB::table('agents_employee')
            ->join('agents_users', 'agents_users.email', '=', 'agents_employee.email')
            ->select('*')
            ->where('agents_employee.mobile', '=', $mobile)
            ->get();

        if (count($checkMobile) > 0) {
            return Redirect::to("/agentadmin/employee/addemployee")->with(['error' => 'This mobile number is already exist.']);
        }

        $activation_link = uniqid();
        $user                         = new User;
        $user->agents_users_role_id = '1';
        $user->status                 = '1';
        $user->email                 = $email;
        $user->password             = Hash::make($request->input('password'));
        $user->save();
        $data = $request->except('password');

        DB::table('agents_employee')->insert($data);
        return Redirect::to("/agentadmin/employee/addemployee")->with(['success' => 'Employee Added Successfuly']);

        // return view('admin.pages.employee.addemployee',['success'=>'Employee Added Successfuly']);
    }

    public function employeelist()
    {
        $employeelist = DB::table('agents_employee')
            ->join('agents_users', 'agents_users.email', '=', 'agents_employee.email')
            ->select('*')
            ->where('agents_users.agents_users_role_id', '=', '1')
            ->where('agents_users.id', '>', '1')
            ->get();
        return view('admin.pages.employee.employeelist', ['employeelist' => $employeelist]);
    }

    public function changestatus(Request $request)
    {
        $data = array();
        $email = $request->input('email');
        $updata = array();
        $updata['status'] = $request->input('status');
        $ok = DB::table('agents_users')->where('email', '=', $email)->update($updata);
        if ($ok > 0) {
            $data['success'] = 'ok';
        }
        return  json_encode($data);
    }

    public function showadd()
    {
        $category = DB::table('agents_category')->select('*')->get();
        return view('admin.pages.blog.addblog', ['category' => $category]);
    }

    public function blogstore(Request $request)
    {
        $data = $request->except('_token', 'files');
        DB::table('agents_blog')->insert($data);
        $category = DB::table('agents_category')->select('*')->get();
        return view('admin.pages.blog.addblog', ['success' => 'Blog Added Successfuly', 'category' => $category]);
    }

    public function bloglist()
    {
        $employeelist = DB::table('agents_blog')->select('*')->get();
        return view('admin.pages.blog.bloglist', ['bloglist' => $employeelist]);
    }

    public function blogchangestatus(Request $request)
    {
        $data = array();
        $id = $request->input('id');
        $updata = array();
        $updata['status'] = $request->input('status');
        $ok = DB::table('agents_blog')->where('id', '=', $id)->update($updata);
        if ($ok > 0) {
            $data['success'] = 'ok';
        }
        return  json_encode($data);
    }

    public function editblog(Request $request)
    {
        $id = $request->route('id');
        $employeelist = DB::table('agents_blog')->select('*')->where('id', $id)->first();
        $category = DB::table('agents_category')->select('*')->get();
        return view('admin.pages.blog.editblog', ['blog' => $employeelist, 'category' => $category]);
    }

    public function updateblog(Request $request)
    {
        $id = $request->input('id');
        $data['title'] = $request->input('title');
        $data['description'] = $request->input('description');
        $data['cat_id'] = $request->input('cat_id');

        $query = DB::table('agents_blog')->where('id', '=', $id)->update($data);
        if ($query == 1) {
            $employeelist = DB::table('agents_blog')->select('*')->get();
            return view('admin.pages.blog.bloglist', ['bloglist' => $employeelist, 'success' => 'ok']);
        } else {
            $employeelist = DB::table('agents_blog')->select('*')->get();
            return view('admin.pages.blog.bloglist', ['bloglist' => $employeelist, 'success' => 'no']);
        }
    }

    public function catlist()
    {
        $catlists = DB::table('agents_category')->select('*')->get();
        return view('admin.pages.blog.categorylist', ['catlist' => $catlists]);
    }

    public function catstore(Request $request)
    {
        $data['cat_name'] = $request->input('cat_name');
        $data['created_at'] = date('Y-m-d H:i:s');
        $catsearch = DB::table('agents_category')->select('*')->where('cat_name', '=', $data['cat_name'])->count();
        if ($catsearch == 0) {
            $catlist = DB::table('agents_category')->insert($data);
            $result['success'] = 'ok';
        } else {
            $result['success'] = 'available';
        }
        return json_encode($result);
    }
    public function catupdate(Request $request)
    {
        $data['cat_name'] = $request->input('cat_name');
        $id = $request->input('hid');
        $catsearch = DB::table('agents_category')->select('*')->where('cat_name', '=', $data['cat_name'])->count();
        if ($catsearch == 0) {
            $catlist = DB::table('agents_category')->where('id', '=', $id)->update($data);
            if ($catlist == 1) {
                $result['success'] = 'ok';
            }
        } else {
            $result['success'] = 'no';
        }
        return json_encode($result);
    }

    public function delete_employee(Request $request)
    {
        $id = $request->input('id');
        DB::delete('delete from agents_users where id = ?', [$id]);
    }
    public function deletecat(Request $request)
    {
        $id = $request->input('id');
        DB::delete('delete from agents_category where id = ?', [$id]);
    }
}
