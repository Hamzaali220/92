<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bookmark extends Model
{
    protected $table = 'agents_bookmark';

    protected $primaryKey = "bookmark_id";

    /* get all data any filed using*/
    public function getDetailsByAny($limit, $where = null)
    {
        $query = DB::table('agents_bookmark')->select('*');
        if ($where != null) {
            $query->where($where);
        }

        $query->orderBy('created_at', 'DESC');

        $count = $query->count();

        $result = $query->skip($limit * 10)->take(10)->get();

        $coun = floor($count / 10);

        $prview = $limit == 0 ? 0 : $limit - 1;

        $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

        $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

        $llimit = $next * 10 == 0 ? $count : $next * 10;
        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);
        return $data;
    }

    /* For insert update bookmark details */
    public function inserupdate($data = null, $id = null)
    {
        if (empty($id)) {

            $result = DB::table('agents_bookmark')->insertGetId($data);
        } else {

            $result = DB::table('agents_bookmark')->where($id)->update($data);
        }
        return $result;
    }

    /* get all data any filed using*/
    public function getBookmarkByAny($where = null)
    {

        $query = DB::table('agents_bookmark')->select('*');

        if ($where != null) {
            $query->where($where);
        }

        $query->orderBy('created_at', 'DESC');

        return $result = $query->get();
    }

    /* get all data any filed using*/
    public function getBookmarkSingalByAny($where = null)
    {

        $query = DB::table('agents_bookmark')->select('*');

        if ($where != null) {
            $query->where($where);
        }

        $query->orderBy('created_at', 'DESC');

        return $result = $query->first();
    }

    /* For get bookmark details */
    public function getbookmarklistingwithjoinalldata($limit, $userid, $roleid)
    {
        $query = DB::table('agents_bookmark')

            ->where(array(

                'agents_bookmark.sender_id' => $userid,

                'agents_bookmark.sender_role' => $roleid,

            ))

            ->select('*')

            ->orderBy('agents_bookmark.created_at', 'DESC');

        $count = $query->count();

        $result = $query->skip($limit * 10)->take(10)->get();

        $obj = [];

        foreach ($result as $value) {

            $mergedata = '';

            if ($value->bookmark_type == 1) {

                $mergedata = $this->bookmarkquestion($value, $userid, $roleid);
            }

            if ($value->bookmark_type == 2) {

                $mergedata = $this->bookmark_s_b_a($value, $userid, $roleid);
            }

            if ($value->bookmark_type == 3) {

                $mergedata = $this->bookmarkmessage($value, $userid, $roleid);
            }

            if ($value->bookmark_type == 4) {

                $mergedata = $this->bookmarkanswers($value, $userid, $roleid);
            }

            if ($value->bookmark_type == 5) {

                $mergedata = $this->bookmarkpraposal($value, $userid, $roleid);
            }



            $obj[] = (object) array_merge((array) $value, (array) $mergedata);
        }

        $result = $obj;

        $coun = floor($count / 10);

        $prview = $limit == 0 ? 0 : $limit - 1;

        $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

        $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

        $llimit = $next * 10 == 0 ? $count : $next * 10;



        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }

    /* For bookmark questions */
    public function bookmarkquestion($value, $userid, $roleid)

    {

        $b = DB::table('agents_posts')

            ->where('post_id', $value->bookmark_item_parent_id)

            ->select('post_id', 'posttitle as post_text')->first();

        $queryc = DB::table('agents_question')

            ->where(array(

                'agents_question.question_id' => $value->bookmark_item_id,

            ))

            ->select('agents_question.question as bookmark_text')

            ->first();

        $result = (object) array_merge((array) $b, (array) $queryc);
        return $result;
    }


    public function bookmark_s_b_a($value, $userid, $roleid)

    {

        $b = DB::table('agents_posts')

            ->where('post_id', $value->bookmark_item_parent_id)

            ->select('post_id', 'posttitle as post_text')->first();

        $query = DB::table('agents_users_details')

            ->select('name as bookmark_text')

            ->where(array('details_id' => $value->bookmark_item_id))

            ->first();
        $result = (object) array_merge((array) $b, (array) $query);
        return $result;
    }


    /* For bookmark message process */
    public function bookmarkmessage($value, $userid, $roleid)
    {
        $query = DB::table('agents_conversation_message')

            ->join('agents_users_details as u', function ($join) {

                $join->on('u.details_id', '=', 'agents_conversation_message.sender_id')

                    ->orOn('u.details_id', '=', 'agents_conversation_message.receiver_id');
            })

            ->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_conversation_message.post_id')

            ->leftJoin('agents_conversation', 'agents_conversation.conversation_id', '=', 'agents_conversation_message.conversation_id')

            ->where(array('agents_conversation_message.messages_id' => $value->bookmark_item_id, 'agents_conversation_message.conversation_id' => $value->bookmark_item_parent_id))

            ->where(function ($query1) use ($userid, $roleid) {

                $query1->whereRaw(DB::raw(

                    'CASE WHEN agents_conversation_message.sender_id = ' . $userid . ' AND agents_conversation_message.sender_role = ' . $roleid . '

			            THEN agents_conversation_message.receiver_id = u.details_id

			            WHEN agents_conversation_message.receiver_id = ' . $userid . '  AND agents_conversation_message.receiver_role = ' . $roleid . '

			            THEN agents_conversation_message.sender_id = u.details_id

			            END'

                ));
            })
            ->select('u.details_id as message_id', 'agents_conversation_message.post_id', 'agents_posts.posttitle as post_text', 'u.name', 'agents_posts.posttitle as post_text', 'agents_conversation_message.message_text as bookmark_text', DB::raw('(CASE WHEN agents_conversation_message.sender_id = ' . $userid . ' AND agents_conversation_message.sender_role = ' . $roleid . ' THEN agents_conversation_message.receiver_role  WHEN agents_conversation_message.receiver_id = ' . $userid . '  AND agents_conversation_message.receiver_role = ' . $roleid . ' THEN agents_conversation_message.sender_role END) AS message_role_id'));
        $result = $query->first();
        return $result;
    }

    /* For bookmark answer process */
    public function bookmarkanswers($value, $userid, $roleid)
    {
        /*$query= DB::table('agents_answers')->select('agents_answers.answers as bookmark_text');

		$query->leftJoin('agents_question', 'agents_question.question_id', '=', 'agents_answers.question_id');

		$query->where(array('agents_answers.answers_id' => $value->bookmark_item_id,'agents_answers.question_id' => $value->bookmark_item_parent_id));

		$result = $query->first();

		return $result;*/

        $queryc = DB::table('agents_answers')

            ->leftJoin('agents_question', 'agents_question.question_id', '=', 'agents_answers.question_id')

            ->leftJoin('agents_shared', 'agents_shared.shared_item_id', '=', 'agents_answers.question_id')

            ->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_shared.shared_item_type_id')

            ->where(array(
                'agents_answers.question_id' => $value->bookmark_item_parent_id,

                'agents_answers.answers_id' => $value->bookmark_item_id,

                'agents_shared.shared_item_id' => $value->bookmark_item_parent_id,

                'agents_shared.sender_id' => $userid,

                'agents_shared.sender_role' => $roleid,

                'agents_shared.receiver_id' => $value->receiver_id,

                'agents_shared.receiver_role' => $value->receiver_role,
            ))
            ->where('agents_shared.shared_type', 1)

            ->select('agents_posts.post_id', 'agents_posts.posttitle as post_text', 'agents_answers.answers as bookmark_text');

        return $result1 = $queryc->first();
    }

    /* Bookmark proposal process */
    public function bookmarkpraposal($value, $userid, $roleid)
    {
        $b = DB::table('agents_posts')

            ->where('post_id', $value->bookmark_item_parent_id)

            ->select('post_id', 'posttitle as post_text')->first();
        $query = DB::table('agents_proposals')

            ->select('proposals_title as bookmark_text')

            ->where(array('proposals_id' => $value->bookmark_item_id))

            ->first();

        $result = (object) array_merge((array) $b, (array) $query);
        return $result;
    }
}
