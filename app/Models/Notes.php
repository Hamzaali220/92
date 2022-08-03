<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notes extends Model
{
    protected $table = 'agents_notes';
    protected $primaryKey = "notes_id";

    /* Insert update notes */
    public function inserupdate($data = null, $id = null)
    {
        if (empty($id)) {
            $result = DB::table('agents_notes')->insertGetId($data);
        } else {
            $result = DB::table('agents_notes')->where($id)->update($data);
        }
        return $result;
    }

    /* get all data any filed using*/
    public function getNotesByAny($where = null)
    {

        $query = DB::table('agents_notes')->select('*');



        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('created_at', 'DESC');

        return $result = $query->get();
    }

    /* get all data any filed using*/
    public function getNotesSingalByAny($where = null)
    {
        $query = DB::table('agents_notes')->select('*');
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        return $result = $query->first();
    }

    /* get all data any filed using*/
    public function getDetailsByAny($limit, $where = null)
    {
        $query = DB::table('agents_notes')->select('*');
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        $count = $query->count();
        $result = $query->skip($limit * 10)->take(10)->get();
        $obj = [];
        foreach ($result as $value) {
            $mergedata = '';
            if ($value->notes_type == 1) {
                $mergedata = $this->notesmessage($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 2) {
                $mergedata = $this->notesquestion($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 3) {
                $mergedata = $this->notesanswers($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 4) {
                $mergedata = $this->notesproposal($value, $where['sender_id'], $where['sender_role']);
            }
            if ($value->notes_type == 5) {
                $mergedata = $this->notesagents($value, $where['sender_id'], $where['sender_role']);
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
        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);
        return $data;
    }


    /* For notes messages */
    public function notesmessage($value, $userid, $roleid)
    {
        $query = DB::table('agents_conversation_message')
            ->join('agents_users_details as u', function ($join) {
                $join->on('u.details_id', '=', 'agents_conversation_message.sender_id')
                    ->orOn('u.details_id', '=', 'agents_conversation_message.receiver_id');
            })
            ->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_conversation_message.post_id')
            ->where(array('agents_conversation_message.messages_id' => $value->notes_item_id, 'agents_conversation_message.conversation_id' => $value->notes_item_parent_id))
            ->where(function ($query1) use ($userid, $roleid) {
                $query1->whereRaw(DB::raw(

                    'CASE WHEN agents_conversation_message.sender_id = ' . $userid . ' AND agents_conversation_message.sender_role = ' . $roleid . '

			            THEN agents_conversation_message.receiver_id = u.details_id

			            WHEN agents_conversation_message.receiver_id = ' . $userid . '  AND agents_conversation_message.receiver_role = ' . $roleid . '

			            THEN agents_conversation_message.sender_id = u.details_id

			            END'

                ));
            })

            ->select('u.details_id as message_id', 'u.name', 'agents_conversation_message.post_id', 'agents_posts.posttitle as post_text', 'agents_conversation_message.message_text as notes_type_text', DB::raw('(CASE WHEN agents_conversation_message.sender_id = ' . $userid . ' AND agents_conversation_message.sender_role = ' . $roleid . ' THEN agents_conversation_message.receiver_role  WHEN agents_conversation_message.receiver_id = ' . $userid . '  AND agents_conversation_message.receiver_role = ' . $roleid . ' THEN agents_conversation_message.sender_role END) AS message_role_id'));

        $result = $query->first();

        return $result;
    }

    /* For notes questions */
    public function notesquestion($value, $userid, $roleid)
    {
        $b = DB::table('agents_posts')
            ->where('post_id', $value->notes_item_parent_id)

            ->select('post_id', 'posttitle as post_text')->first();

        $queryc = DB::table('agents_question')

            ->where('question_id', $value->notes_item_id)

            ->select('question as notes_type_text')->first();

        $result = (object) array_merge((array) $b, (array) $queryc);

        return $result;
    }

    /* For nots answers */
    public function notesanswers($value, $userid, $roleid)

    {

        $queryc = DB::table('agents_answers')

            ->leftJoin('agents_shared', 'agents_shared.shared_item_id', '=', 'agents_answers.question_id')

            ->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_shared.shared_item_type_id')

            ->where(array(
                'agents_answers.question_id' => $value->notes_item_parent_id,

                'agents_answers.answers_id' => $value->notes_item_id,

                'agents_shared.shared_item_id' => $value->notes_item_parent_id,

                'agents_shared.sender_id' => $userid,

                'agents_shared.sender_role' => $roleid,

                'agents_shared.receiver_id' => $value->receiver_id,

                'agents_shared.receiver_role' => $value->receiver_role,

            ))

            ->where('agents_shared.shared_type', 1)

            ->select('agents_posts.post_id', 'agents_posts.posttitle as post_text', 'agents_answers.answers as notes_type_text');

        return $result1 = $queryc->first();
    }

    /* For notes proposal */
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

    /* For notes agent */
    public function notesagents($value, $userid, $roleid)
    {
        $b = DB::table('agents_posts')

            ->where('post_id', $value->notes_item_parent_id)

            ->select('post_id', 'posttitle as post_text')->first();

        $queryc = DB::table('agents_users_details')

            ->where('details_id', $value->notes_item_id)

            ->select('name as notes_type_text')->first();

        $result = (object) array_merge((array) $b, (array) $queryc);

        return $result;
    }
}
