<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{
    public function conversation()
    {
        $view['conversation'] = DB::table('agents_conversation as m')
            ->join('agents_users_details as u', function ($join) {
                $join->on('u.details_id', '=', 'm.sender_id')
                    ->orOn('u.details_id', '=', 'm.receiver_id');
            })
            ->leftJoin('agents_users as uu', 'uu.id', '=', 'u.details_id')
            ->Join('agents_posts as p', 'p.post_id', '=', 'm.post_id')
            ->where('p.is_deleted', '0')
            ->select('m.*', 'u.name', 'u.photo', 'p.posttitle', 'p.details', DB::raw('(SELECT s.name FROM agents_users_details s WHERE details_id=m.sender_id) as sender'), DB::raw('(SELECT sr.role_name FROM agents_users_roles sr WHERE role_id=m.sender_role_id) as sender_role'), DB::raw('(SELECT r.name FROM agents_users_details r WHERE details_id=m.receiver_id) as receiver'), DB::raw('(SELECT rr.role_name FROM agents_users_roles rr WHERE role_id=m.receiver_role_id) as receiver_role'))
            ->orderBy('m.updated_at', 'DESC')
            ->get();
        //dd($view);


        return view('admin.pages.conversation.conversationlist', $view);
    }

    public function conversationdetails($id = null)
    {

        $view['conversation'] = DB::table('agents_conversation_message as m')
            /*->join('agents_users_details as u',function($join){
			     $join->on('u.details_id','=','m.sender_id')
			     ->orOn('u.details_id','=','m.receiver_id');
			})
			->leftJoin('agents_users as uu','uu.id','=','u.details_id')
			->Join('agents_posts as p','p.post_id','=','m.post_id')	*/
            ->where('m.conversation_id', $id)
            ->select('m.*', DB::raw('(SELECT s.name FROM agents_users_details s WHERE details_id=m.sender_id) as sender'), DB::raw('(SELECT sr.role_name FROM agents_users_roles sr WHERE role_id=m.sender_role) as sender_role'), DB::raw('(SELECT r.name FROM agents_users_details r WHERE details_id=m.receiver_id) as receiver'), DB::raw('(SELECT rr.role_name FROM agents_users_roles rr WHERE role_id=m.receiver_role) as receiver_role'))
            ->orderBy('m.updated_at', 'DESC')
            ->get();
        //dd($view);


        return view('admin.pages.conversation.conversationdetails', $view);
    }
}
