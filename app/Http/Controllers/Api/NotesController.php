<?php

namespace App\Http\Controllers\Api;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $update = $notifiy =                                   array();
        $update['notes_type']                               =   $request->input('notes_type');
        $update['notes_item_id']                            =   $request->input('notes_item_id');
        $update['notes_item_parent_id']                     =   $request->input('notes_item_parent_id');
        $notifiy['sender_id'] = $update['sender_id']         =   $request->input('sender_id');
        $notifiy['sender_role'] = $update['sender_role']     =   $request->input('sender_role');
        $notifiy['receiver_id'] = $update['receiver_id']     =   $request->input('receiver_id');
        $notifiy['receiver_role'] = $update['receiver_role'] =   $request->input('receiver_role');

        $notes = new Notes;
        $acheck = $notes->getnotesSingalByAny($update);
        if (!empty($acheck)) {
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
        } else {

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
            $result                            =   $notes;
        }

        return response()->json(['status' => '100', 'response' => $result]);
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
    public function notesproposal($value, $userid, $roleid)
    {
        $b = DB::table('agents_posts')
            ->where('post_id', $value->notes_item_parent_id)
            ->select('post_id', 'posttitle as post_text')->first();
        $queryc = DB::table('agents_proposals')
            ->where('proposals_id', $value->notes_item_id)
            ->select('proposals_title as notes_type_text')->first();
        $result = (object) array_merge((array) $b, (array) $queryc);
        return $result;
    }

    /* For get details by any */
    public function getDetailsByAny($limit, $where = null)
    {
        $query = DB::table('agents_notes')->select('*');
        $notes = new Notes;
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        $count = $query->count();
        $result = $query->get();

        $obj = [];
        foreach ($result as $value) {
            $mergedata = '';
            if ($value->notes_type == 1) {
                $mergedata = $notes->notesmessage($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 2) {
                $mergedata = $notes->notesquestion($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 3) {
                $mergedata = $notes->notesanswers($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 4) {
                $mergedata = $notes->notesproposal($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 5) {
                $mergedata = $notes->notesagents($value, $where['sender_id'], $where['sender_role']);
            }
            // if(!empty($mergedata)){
            $obj[] = (object) array_merge((array) $value, (array) $mergedata);
            // }
        }
        $result = $obj;

        $coun = floor($count / 10);
        $prview = $limit == 0 ? 0 : $limit - 1;
        $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 :  $limit + 1);
        $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;
        $llimit = $next * 10 == 0 ? $count : $next * 10;

        return $result;
    }

    /* Get notes list by dashboard */
    public function GetnotesListByDashbord(Request $request)
    {
        $limit = $request->input('limit');
        $user = Auth::user();
        $notes = new Notes;
        $result = $this->getDetailsByAny($limit, array('sender_id' => $user->id, 'sender_role' => $user->agents_users_role_id));
        //$result= html_entity_decode($result['notes']['notes']);
        foreach ($result as $data) {
            //print_r(strip_tags($data->notes));
            $data->notes = strip_tags($data->notes);
        }
        return response()->json(['status' => '100', 'notes' => $result]);
    }

    /*update note */
    public function update(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('id');
        $notesu                         =  Notes::find($id);
        $notesu->notes                  =  $request->input('notes');
        $notesu->updated_at             =  Carbon::now()->toDateTimeString();
        $result = $notesu->save();
        if ($result == true) {
            $limit = $request->input('limit');
            $result = $this->getDetailsByAny($limit, array('sender_id' => $user->id, 'sender_role' => $user->agents_users_role_id));
            return response()->json(['status' => '100', 'notes' => $result]);
        } else {
            return response()->json(['status' => '101', 'response' => 'failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $user = Auth::user();
        $result = DB::table('agents_notes')->where('notes_id', $request->input('id'))->delete();
        if ($result == true) {
            $limit = $request->input('limit');
            $result = $this->getDetailsByAny($limit, array('sender_id' => $user->id, 'sender_role' => $user->agents_users_role_id));
            return response()->json(['status' => '100', 'notes' => $result]);
        } else {
            return response()->json(['status' => '101', 'response' => 'failed']);
        }
    }
}
