<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $table = 'agents_notification';
    protected $primaryKey = "notification_id";

    /* get all data any filed using*/
    public function getDetailsByAnylimit($limit, $where = null)
    {
        $query = DB::table('agents_notification')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        $count = $query->count();
        $result = $query->skip($limit * 3)->take(3)->get();
        $coun = floor($count / 3);
        $prview = $limit == 0 ? 0 : $limit - 1;
        $next   = $coun == $limit ? 0 : ($count <= 3 ? 0 : $limit + 1);
        $rlimit = $limit * 3 == 0 ? 1 : $limit * 3;
        $llimit = $next * 3 == 0 ? $count : $next * 3;
        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }


    /* Insert and update notification */
    public function inserupdate($data = null, $id = null)

    {

        if (empty($id)) {
            $result = DB::table('agents_notification')->insertGetId($data);
        } else {
            $result = DB::table('agents_notification')->where($id)->update($data);
        }
        return $result;
    }

    /* get all data any filed using Answers table*/
    public function getDetailsByAny($where = null)
    {
        $query = DB::table('agents_notification')->select('*');
        if ($where != null) {
            $query->where($where);
        }
        return $result = $query->get();
    }

    /* get all data any filed using Answers table*/
    public function getsinglerowByAny($where = null)
    {
        $query = DB::table('agents_notification')->select('*');
        if ($where != null) {
            $query->where($where);
        }

        return $result = $query->first();
    }


    /* For get notifications messages */
    public function getnotification($limit, $userid, $roleid)
    {
        $query = DB::table('agents_notification')
            ->Join('agents_notification_type', 'agents_notification_type.type_id', '=', 'agents_notification.notification_type')
            ->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_notification.notification_post_id')
            ->where(array(
                'agents_notification.receiver_id' => $userid,

                'agents_notification.receiver_role' => $roleid,

                'agents_notification.show' => '1',

                'agents_notification_type.status' => '0',

            ))

            ->whereIn('notification_type', [1, 2, 3, 4, 5, 8, 9, 10, 11, 12, 13, 14, 15, 16])

            ->select('agents_notification.*', 'agents_posts.post_id as notification_post', 'agents_posts.applied_post', 'agents_posts.applied_user_id', 'agents_posts.post_id as notification_post');

        $count = $query->count();

        $query->orderBy('notification_id', 'DESC');

        $result = $query->skip($limit * 10)->take(10)->get();



        $unquery = DB::table('agents_notification')

            ->Join('agents_notification_type', 'agents_notification_type.type_id', '=', 'agents_notification.notification_type')
            ->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_notification.notification_post_id')
            ->where(array(

                'agents_notification.receiver_id' => $userid,

                'agents_notification.receiver_role' => $roleid,

                'agents_notification.show' => '1',

                'agents_notification_type.status' => '0',

            ))

            ->whereIn('notification_type', [1, 2, 3, 4, 5, 8, 9, 10, 11, 12, 13, 14, 15, 16])

            ->select('agents_notification.*');

        $unreadcount = $unquery->where(array('agents_notification.status' => '1'))->count();

        $obj = [];
        //echo '<pre>'; print_r($result); die;
        foreach ($result as $value) {
            if ($value->notification_type == 10) {

                $mergedata = $this->AskedQuestionReturnAnswer($value, $userid, $roleid);

                if (!empty($mergedata)) {

                    $obj[] = (object) array_merge((array) $value, (array) $mergedata);
                }
            }
            if (in_array($value->notification_type, [1, 2, 3, 4, 5])) {

                $mergedata = $this->sharedatajoin($value, $userid, $roleid);

                if (!empty($mergedata)) {

                    $obj[] = (object) array_merge((array) $value, (array) $mergedata);
                }
            }



            if (in_array($value->notification_type, [8, 9])) {

                $mergedata = $this->retingdatajoin($value, $userid, $roleid);

                if (!empty($mergedata)) {

                    $obj[] = (object) array_merge((array) $value, (array) $mergedata);
                }
            }
            if (in_array($value->notification_type, [13]) && $value->notification_post != null) {
                if ($value->applied_user_id == $userid && $value->applied_post == 1) {
                    $obj[] = $value;
                }
            }
            if (in_array($value->notification_type, [11, 12, 14, 15, 16])) {

                $obj[] = $value;
            }
        }

        $result = $obj;

        $coun = floor($count / 10);

        $prview = $limit == 0 ? 0 : $limit - 1;

        $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

        $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

        $llimit = $next * 10 == 0 ? $count : $next * 10;
        $data = array('unreadcount' => $unreadcount, 'result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }

    /* For share data join */
    public function sharedatajoin($value, $userid, $roleid)
    {
        $queryc = DB::table('agents_shared')

            ->where(array(
                'agents_shared.shared_item_id' => $value->notification_child_item_id,

                'agents_shared.shared_id' => $value->notification_item_id,

            ))

            ->select('agents_shared.shared_item_type_id as post_id');

        $result = $queryc->first();

        return $result;
    }

    /* For rating data process */
    public function retingdatajoin($value, $userid, $roleid)

    {

        $query1 = DB::table('agents_rating')

            ->where(array('agents_rating.rating_id' => $value->notification_item_id))

            ->select('*');

        $result = $query1->first();



        if ($result->rating_type == 1) {

            $queryc = DB::table('agents_answers')

                ->Join('agents_shared', 'agents_shared.shared_item_id', '=', 'agents_answers.question_id')

                ->where(array(
                    'agents_answers.question_id' => $result->rating_item_parent_id,

                    'agents_answers.answers_id' => $result->rating_item_id,

                    'agents_answers.from_id' => $userid,

                    'agents_answers.from_role' => $roleid,

                    'agents_shared.shared_item_id' => $result->rating_item_parent_id,

                    'agents_shared.receiver_id' => $userid,

                    'agents_shared.receiver_role' => $roleid,

                ))

                ->where('agents_shared.shared_type', 1)

                ->select('agents_shared.shared_item_type_id as post_id');

            $result1 = $queryc->first();
        }

        if ($result->rating_type == 2) {

            $queryc = DB::table('agents_rating')

                ->Join('agents_conversation_message', 'agents_conversation_message.messages_id', '=', 'agents_rating.rating_item_id')

                ->where(array(

                    'agents_rating.rating_id' => $value->notification_item_id,

                    'agents_conversation_message.messages_id' => $result->rating_item_id,

                    'agents_conversation_message.conversation_id' => $result->rating_item_parent_id,

                    'agents_rating.receiver_id' => $userid,

                    'agents_rating.receiver_role' => $roleid,

                ))

                ->where('agents_rating.rating_type', 2)

                ->select('post_id');

            $result1 = $queryc->first();
        }



        return $result1;
    }

    /* For asked question return answer */
    public function AskedQuestionReturnAnswer($value, $userid, $roleid)

    {

        $queryc = DB::table('agents_answers')

            ->Join('agents_shared', 'agents_shared.shared_item_id', '=', 'agents_answers.question_id')

            ->where(array(
                'agents_answers.question_id' => $value->notification_child_item_id,

                'agents_answers.answers_id' => $value->notification_item_id,

                'agents_shared.shared_item_id' => $value->notification_child_item_id,

                'agents_shared.sender_id' => $value->receiver_id,

                'agents_shared.sender_role' => $value->receiver_role,

                'agents_shared.receiver_id' => $value->sender_id,

                'agents_shared.receiver_role' => $value->sender_role,

            ))

            ->where('agents_shared.shared_type', 1)

            ->select('agents_shared.shared_item_type_id as post_id');

        return $result1 = $queryc->first();
    }


    /* For message notification */
    public function MessageNotification($limit, $userid, $roleid)
    {
        $query1 = DB::table('agents_notification as n')

            ->join('agents_conversation as c', function ($join) {

                $join->on('c.conversation_id', '=', 'n.notification_item_id')

                    ->orOn('c.conversation_id', '=', 'n.notification_child_item_id');
            })

            ->leftJoin('agents_users_details as u', 'u.details_id', '=', 'n.sender_id')

            ->where(function ($query) {

                $query->whereRaw(DB::raw(

                    'CASE WHEN n.notification_type = 6

		            THEN n.notification_item_id = c.conversation_id

		            WHEN n.notification_type = 7

		            THEN n.notification_child_item_id = c.conversation_id END'

                ));
            })
            ->where(array(

                'n.receiver_id'     => $userid,

                'n.receiver_role' => $roleid,

                'n.status'         => 1,

            ))

            ->whereIn('n.notification_type', [6, 7])

            ->select('n.*', 'c.conversation_id', 'c.post_id', 'c.snippet', 'u.name', 'u.details_id', 'u.photo')

            ->orderBy('n.created_at', 'DESC');
//            ->groupBy('c.conversation_id');
        $result = $query1->skip($limit * 10)->take(10)->get();
        $count = count($result);
        $coun = floor($count / 10);

        $prview = $limit == 0 ? 0 : $limit - 1;

        $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

        $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

        $llimit = $next * 10 == 0 ? $count : $next * 10;

        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }
}
