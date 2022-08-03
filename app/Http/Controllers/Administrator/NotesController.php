<?php

namespace App\Http\Controllers\Administrator;

use App\Events\eventTrigger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Shared;
use App\Models\Notification;
use App\Models\Notes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class NotesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            if ($user->agents_users_role_id == 4) {
                $view['pagetype'] = 'post';
            } else {
                $view['pagetype'] = 'agents';
            }
            $view['user_type'] = env('user_role_' . $user->agents_users_role_id);
            return view('dashboard.user.notes.notes', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        //return $request->input('notes');  exit;

        $validator = Validator::make($request->all(), [
            'notes' => 'required',

        ]);

        $string = trim($request->input('notes'));

        if ($validator->fails()) {

            return response()->json(array('status' => 'error', 'message' => $validator->errors()->all()));
        } else if (trim($request->input('notes')) == " " || trim($request->input('notes')) == null) {

            return response()->json(array('status' => 'error', 'message' => 'This field is required'));
        } else {

            $update = $notifiy = array();
            $update['notes_type']                               =   $request->input('notes_type');
            $update['notes_item_id']                            =   $request->input('notes_item_id');
            $update['notes_item_parent_id']                     =   $request->input('notes_item_parent_id');
            $notifiy['sender_id'] = $update['sender_id']         =   $request->input('sender_id');
            $notifiy['sender_role'] = $update['sender_role']     =   $request->input('sender_role');
            $notifiy['receiver_id'] = $update['receiver_id']     =   $request->input('receiver_id');
            $notifiy['receiver_role'] = $update['receiver_role'] =   $request->input('receiver_role');

            $notes = new Notes;

            $notes->notes_type                    =   $request->input('notes_type');
            $notes->notes                         =   $request->input('notes');
            $notes->notes_item_id                 =   $request->input('notes_item_id');
            $notes->notes_item_parent_id          =   $request->input('notes_item_parent_id');
            $notes->sender_id                      =   $request->input('sender_id');
            $notes->sender_role                    =   $request->input('sender_role');
            $notes->receiver_id                    =   $request->input('receiver_id');
            $notes->receiver_role                  =   $request->input('receiver_role');
            $notes->updated_at                     =   Carbon::now()->toDateTimeString();
            $notes->save();
            $result                                 =   $notes;
            /*$acheck = $notes->getnotesSingalByAny($update);
        if(!empty($acheck)){
            $bookbarkupdate                         =  Notes::find($acheck->notes_id);
            $bookbarkupdate->notes_type            =  $request->input('notes_type');
            $bookbarkupdate->notes                 =  $request->input('notes');
            $bookbarkupdate->notes_item_id         =  $request->input('notes_item_id');
            $bookbarkupdate->notes_item_parent_id  =  $request->input('notes_item_parent_id');
            $bookbarkupdate->sender_id              =  $request->input('sender_id');
            $bookbarkupdate->sender_role            =  $request->input('sender_role');
            $bookbarkupdate->receiver_id            =  $request->input('receiver_id');
            $bookbarkupdate->receiver_role          =  $request->input('receiver_role');
            $bookbarkupdate->updated_at             =  Carbon::now()->toDateTimeString();
            $bookbarkupdate->save();
            $result                                 =   $bookbarkupdate;
        }else{
            $notes->notes_type                    =   $request->input('notes_type');
            $notes->notes                         =   $request->input('notes');
            $notes->notes_item_id                 =   $request->input('notes_item_id');
            $notes->notes_item_parent_id          =   $request->input('notes_item_parent_id');
            $notes->sender_id                      =   $request->input('sender_id');
            $notes->sender_role                    =   $request->input('sender_role');
            $notes->receiver_id                    =   $request->input('receiver_id');
            $notes->receiver_role                  =   $request->input('receiver_role');
            $notes->updated_at                     =   Carbon::now()->toDateTimeString();
            $notes->save();
            $result                                 =   $notes;
        }*/
            // if($result){
            //     $notifiy['notification_type']            = $request->input('notification_type');
            //     $notifiy['notification_message']         = $request->input('notification_message');
            //     $notifiy['notification_item_id']         = $result;
            //     $notifiy['notification_child_item_id']   = $request->input('notes_item_id');
            //     $notifiy['updated_at']                   =  Carbon::now()->toDateTimeString();

            //     $noti = new Notification;
            //     $noti->inserupdate($notifiy);

            // }
            return response()->json(['data' => $result]);
        }
    }


    public function update(Request $request, $id)
    {
        $notesu                         =  Notes::find($id);
        $notesu->notes                  =  $request->input('notes');
        $notesu->updated_at             =  Carbon::now()->toDateTimeString();
        return response()->json($notesu->save());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($limit, $userid, $role)
    {
        $notes = new Notes;
        $result = $notes->getDetailsByAny($limit, array('agents_user_id' => $userid, 'sender_role' => $role));
        return response()->json($result);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetNotesedList($id, $role, $notes_type, $notes_item_id, $notes_item_parent_id, $receiver_id, $receiver_role)
    {
        $notes = new Notes;
        $result = $notes->getnotesSingalByAny(array('sender_id' => $id, 'sender_role' => $role, 'receiver_id' => $receiver_id, 'receiver_role' => $receiver_role, 'notes_type' => $notes_type, 'notes_item_id' => $notes_item_id, 'notes_item_parent_id' => $notes_item_parent_id));
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetnotesListByDashbord($limit)
    {
        $user = Auth::user();
        $notes = new Notes;
        $result = $notes->getDetailsByAny($limit, array('sender_id' => $user->id, 'sender_role' => $user->agents_users_role_id));
        return response()->json($result);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $result = DB::table('agents_notes')->where('notes_id', $id)->delete();
        return response()->json($result);
    }
}
