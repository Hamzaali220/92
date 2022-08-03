<?php

namespace App\Http\Controllers\Administrator\Agents;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Userdetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{

    function __construct()
    {
    }

    public function manage()
    {
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        $view['user_type'] = env('user_role_' . $user->agents_users_role_id);

        # load purchased packages
        $ad_list = DB::table('agents_advertise as pa')
            ->join('agents_package as ap', 'ap.package_id', '=', 'pa.package_id')
            ->select('pa.id', 'pa.package_id', 'ap.title', 'pa.ad_place', 'pa.created_ts', 'pa.status', 'pa.receipt_url', 'pa.clicks', 'pa.receipt_url')
            ->where(['agent_id' => $user->id, 'pa.deleted' => 0])
            ->paginate(10);

        $view['ad_list'] = $ad_list;

        return view('dashboard.user.agents.manage-ads', $view);
    }

    public function configureads(Request $request, $ad_id = null)
    {
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        $view['user_type'] = env('user_role_' . $user->agents_users_role_id);
        $view['ad_id'] = $ad_id;
        if ($request->isMethod('post')) {
            $rules = [
                'ad_id' => ['required', 'integer'],
                'ad_title' => ['required', 'max:40'],
                'ad_link' => ['required']
            ];

            if ($request->input('content_f')) {
                $rules['ad_content'] = ['required', 'max:500'];
            }

            if ($request->input('image_f')) {
                $rules['ad_banner'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1024'];
            }



            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

            $update_arr = [
                'ad_title' => $request->input('ad_title'),
                'ad_link' => $request->input('ad_link')
            ];

            if ($request->input('content_f')) {
                $update_arr['ad_content'] = $request->input('ad_content');
            }

            if ($request->input('image_f')) {
                # store the ad banner
                $path = $request->file('ad_banner')->store('ad_banner', ['disk' => 'public']);
                $update_arr['ad_banner'] = $path;
            }

            $dpop = DB::table('agents_advertise')->where('id', $request->input('ad_id'))
                ->update($update_arr);
            if ($dpop) {
                $view['status'] = 'success';
                $view['message'] = 'Ad configured successfully';
            } else {
                $view['status'] = 'failed';
                $view['message'] = 'Ad configuration failed';
            }
        }

        # get the ad details
        $ad_details = DB::table('agents_advertise as ap')
            ->join('agents_package as pa', 'ap.package_id', '=', 'pa.package_id')
            ->select('pa.image', 'pa.content')
            ->where(['ap.agent_id' => $user->id, 'pa.deleted' => 0, 'ap.id' => $ad_id])
            ->first();
        $view['ad_details'] = $ad_details;

        return view('dashboard.user.agents.configure-ads', $view);
    }

    public function adclicks(Request $request, $ad_id)
    {

        $ad_details = DB::table('agents_advertise')->where('id', $ad_id)->first();
        if ($ad_details) {
            DB::table('agents_advertise')->where('id', $ad_id)
                ->update(['clicks' => ($ad_details->clicks + 1)]);
            return redirect($ad_details->ad_link);
        }
    }

    public function advertiseinvoice(Request $request, $ad_id)
    {

        # load purchased packages
        $ad_details = DB::table('agents_advertise as pa')
            ->join('agents_package as ap', 'ap.package_id', '=', 'pa.package_id')
            ->select('pa.id', 'pa.package_id', 'ap.title', 'pa.ad_place', 'pa.created_ts', 'pa.status', 'pa.receipt_url', 'pa.clicks', 'pa.receipt_url', 'pa.payment_id', 'pa.ad_link', 'pa.ad_link', 'pa.ad_banner', 'pa.ad_content', 'ap.type')
            ->where(['pa.id' => $ad_id, 'pa.deleted' => 0])
            ->first();

        $payment_details = DB::table('agents_payment')
            ->where(['payment_id' => $ad_details->payment_id])
            ->first();



        $view['ad_details'] = $ad_details;
        $view['payment_details'] = $payment_details;

        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        $view['user_type'] = env('user_role_' . $user->agents_users_role_id);



        return view('dashboard.user.agents.ad_invoice', $view);
    }
}
