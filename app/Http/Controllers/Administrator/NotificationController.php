<?php

namespace App\Http\Controllers\Administrator;

use App\Events\eventTrigger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit)
    {
        $user = Auth::user();
        $notification = new Notification;
        $result = $notification->getnotification($limit, $user->id, $user->agents_users_role_id);
        return response()->json($result);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MessageNotification($limit)
    {
        $user = Auth::user();
        // $userdetails = Userdetails::find($user->id);
        $notification = new Notification;
        $result = $notification->MessageNotification($limit, $user->id, $user->agents_users_role_id);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id = null)
    {
        // $ndata = Notification::find($id);
        //echo 'dd';;
        $notification = new Notification;
        $result = $notification->inserupdate(
            array('status' => 2, 'updated_at' => Carbon::now()->toDateTimeString()),
            array(
                'notification_id' => $id
            )
        );
        return response()->json($result);
    }
    public function UpdateByReceiver_id(Request $request)
    {
        $notification = new Notification;

        $where = array();
        $where['sender_id']         = $request->input('sender_id');
        $where['sender_role']       = $request->input('sender_role');
        $where['receiver_id']       = $request->input('receiver_id');
        $where['receiver_role']     = $request->input('receiver_role');
        $where['notification_type'] = $request->input('notification_type');
        $where['status'] = '1';
        $result = $notification->inserupdate(array('status' => '2', 'updated_at' => Carbon::now()->toDateTimeString()), $where);
        event(new eventTrigger(array($request->all(), $result, 'NewNotification')));
        return response()->json($result);
    }
}
