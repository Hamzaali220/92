<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $package = DB::table('agents_package')->select('*')->get();
        return view('admin.pages.package.packagelist', ['package' => $package]);
    }

    public function editpackage($id)
    {
        $package = DB::table('agents_package')->where('package_id', '=', $id)->first();
        return view('admin.pages.package.update', ['package' => $package]);
    }

    public function updatepackage(Request $request)
    {
        $id = $request->package_id;
        $data['title'] = $request->title;
        $data['details'] = $request->details;
        $data['price'] = $request->price;
        $update = DB::table('agents_package')->where('package_id', '=', $id)->update($data);
        $package = DB::table('agents_package')->select('*')->get();
        return view('admin.pages.package.packagelist', ['package' => $package, 'success' => 'Package Updated successfully']);
    }

    public function adrequests(Request $request)
    {
        $adrequests = $ad_list = DB::table('agents_advertise as pa')
            ->join('agents_package as ap', 'ap.package_id', '=', 'pa.package_id')
            ->select('pa.id', 'pa.package_id', 'ap.title', 'pa.ad_title', 'pa.ad_link', 'pa.ad_banner', 'pa.ad_place', 'pa.created_ts', 'pa.status', 'pa.receipt_url', 'pa.clicks')
            ->where(['pa.deleted' => 0])
            ->get();
        return view('admin.pages.package.adrequests', ['adrequests' => $adrequests]);
    }

    public function adaction(Request $request, $ad_id, $action)
    {

        $update_arr = ['status' => $action, 'updated_ts' => date('Y-m-d h:i:s')];

        $dpop = DB::table('agents_advertise')->where('id', $ad_id)
            ->update($update_arr);

        if ($dpop) {
            $view['c_status'] = 'success';
            $action_text = ($action == '1') ? 'enabled' : 'disbaled';
            $view['c_message'] = 'Ad has been ' . $action_text . ' successfully';
        } else {
            $view['c_status'] = 'failed';
            $view['c_message'] = 'Something went wrong';
        }

        return redirect('agentadmin/adrequests')->with($view);
        #return view('admin.pages.package.adrequests', $view);
    }
}
