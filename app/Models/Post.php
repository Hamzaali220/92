<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionAnswers;
use App\Models\Bookmark;
use App\Models\Rating;
use Illuminate\Http\Request;

class Post extends Model
{

    protected $table = 'agents_posts';
    protected $primaryKey = "post_id";

    protected $fillable = ['closing_date'];

    public function getDetailsByUserroleandId($user = null, $role = null)
    {
        $query = DB::table('agents_posts')->select('*');
        if ($user != null) {
            $query->where(array('agents_posts.agents_user_id' => $user));
        }
        if ($role != null) {
            $query->where(array('agents_posts.agents_users_role_id' => $role));
        }
        $query->where('agents_posts.is_deleted', '0');
        $query->orderBy('agents_posts.created_at', 'DESC');
        $result = $query->first();
        return $result;
    }

    /* get all data any filed using*/
    public function getDetailsByAny($limit, $where = null)
    {

        $query = DB::table('agents_posts')->select('agents_posts.*', 'agents_users.login_status', 'agents_posts.closing_date as post_close_date', 'agents_users.api_token', 'agents_users_details.name', 'agents_users_details.description', 'agents_state.state_name', 'agents_city.city_name');

        $query->Join('agents_users', 'agents_users.id', '=', 'agents_posts.agents_user_id');
        $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');
        $query->leftjoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state');
        $query->leftjoin('agents_city', 'agents_city.city_id', '=', 'agents_posts.city');

        if ($where != null) {
            $query->where($where);
        }

        $query->where('agents_posts.is_deleted', '0');
        $query->orderBy('agents_posts.created_at', 'DESC');
        $count = $query->count();
        $result = $query->skip($limit * 10)->take(10)->get();
        $obj = [];
        foreach ($result as $value) {
            $post_view_count = $this->postviewcountandagentlist($value, $where);
            $obj[] = (object) array_merge((array) $value, (array) $post_view_count);
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

    /* get all data any filed using*/
    public function getSelectedDetailsByAny($limit, $where = null, $record = null)
    {

        $query = DB::table('agents_posts')->select(
            'agents_posts.*',
            'agents_users.id',
            'agents_users.agents_users_role_id',
            'agents_users.login_status',
            'agents_users.api_token',
            'agents_users_details.name',
            'agents_users_details.photo',
            'agents_users_details.description',
            'agents_users_details.address',
            'agents_users_details.address2',
            'agents_users_details.city_id',
            'agents_users_details.zip_code',
            'agents_users_details.years_of_expreience',
            'agents_users_details.brokers_name',
            'agents_users_details.total_sales',
            'agents_state.state_name'
        );

        $query->Join('agents_users', 'agents_users.id', '=', 'agents_posts.applied_user_id');
        $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_posts.applied_user_id');
        $query->leftjoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state');

        if ($where != null) {
            $query->where($where);
        }
        $query->where('agents_posts.is_deleted', '0');
        $query->where('agents_posts.applied_post', '1');
        $query->orderBy('agents_posts.updated_at', 'DESC');

        if ($record == null) {
            $count = $query->count();
            $result = $query->skip($limit * 10)->take(10)->get();
            $coun = floor($count / 10);
            $prview = $limit == 0 ? 0 : $limit - 1;
            $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);
            $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;
            $llimit = $next * 10 == 0 ? $count : $next * 10;

            $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);
        } else {
            $data = $query->first();
        }
        return $data;
    }

    /* Post view count and agent list */
    public function postviewcountandagentlist($value, $where = null)
    {

        $query1 = DB::table('agents_users_conections as c')

            ->join('agents_users_details as u', function ($join) {

                $join->on('u.details_id', '=', 'c.from_id')

                    ->orOn('u.details_id', '=', 'c.to_id');
            });

        if ($where != null) :

            $query1->where(function ($query) use ($where) {

                $query->whereRaw(DB::raw(



                    'CASE WHEN c.from_id = ' . $where['agents_posts.agents_user_id'] . ' AND c.from_role = ' . $where['agents_posts.agents_users_role_id'] . '

				            THEN c.to_id = u.details_id

				            WHEN c.to_id = ' . $where['agents_posts.agents_user_id'] . ' AND c.to_role = ' . $where['agents_posts.agents_users_role_id'] . '

				            THEN c.from_id = u.details_id END'



                ));
            });

        endif;

        $query1->where('c.post_id', $value->post_id)

            ->select('c.*', 'u.details_id', 'u.photo', 'u.name', 'u.description', 'u.years_of_expreience')

            ->orderBy('c.updated_at', 'DESC');

        $count = $query1->count();

        $result = $query1->get();

        return array('post_view_count' => $count, 'connected_agent_list' => $result);
    }

    /* get all data any filed using*/
    public function getDetailsBypostid($where = null)
    {

        $query = DB::table('agents_posts')

            ->select(
                'agents_city.city_name',
                'agents_state.state_name',
                'agents_posts.*',
                'agents_users.id',
                'agents_users.agents_users_role_id',
                'agents_users.login_status',
                'agents_users.api_token',
                'agents_users_details.name',
                'agents_users_details.photo',
                'agents_users_details.description',
                'agents_users_details.address',
                'agents_users_details.address2',
                'agents_users_details.city_id',
                'agents_users_details.zip_code',
                'agents_users_details.years_of_expreience',
                'agents_users_details.brokers_name',
                'agents_users_details.total_sales',
                'agents_users_roles.role_name'
            );



        $query->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state');

        $query->leftJoin('agents_city', 'agents_city.city_id', '=', 'agents_posts.city');

        $query->leftJoin('agents_users', 'agents_users.id', '=', 'agents_posts.agents_user_id');

        $query->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');

        $query->leftJoin('agents_users_roles', 'agents_users_roles.role_id', '=', 'agents_posts.agents_users_role_id');

        if ($where != null) {

            $query->where($where);
        }

        $query->where('agents_posts.is_deleted', '0');

        $query->orderBy('agents_posts.created_at', 'DESC');

        $result = $query->first();

        return $result;
    }

    /* For post insert and update */
    public function inserupdate($data = null, $id = null)

    {

        if (empty($id)) {

            $result = DB::table('agents_posts')->insertGetId($data);
        } else {

            $result = DB::table('agents_posts')->where($id)->update($data);
        }

        return $result;
    }

    /* get all data any filed using Answers table*/

    public function getpostmultipalByAny($where = null)
    {

        $query = DB::table('agents_posts')->select('*');



        if ($where != null) {

            $query->where($where);
        }

        $query->where('agents_posts.is_deleted', '0');

        $query->orderBy('created_at', 'DESC');

        return $result = $query->get();
    }

    /* get all data any filed using Answers table*/
    public function getpostsingalByAny($where = null)
    {

        $query = DB::table('agents_posts')->select('*');



        if ($where != null) {

            $query->where($where);
        }

        $query->where('agents_posts.is_deleted', '0');

        $query->where('agents_posts.status', '1');

        return $result = $query->first();
    }


    /* Applied post listing get for agents */
    public function AppliedPostListGetForAgents($limit = null, $where = null, $orwhere = null, $selected = null)

    {
        
        $query1 = DB::table('agents_users_conections')

            ->join('agents_posts', function ($join) {

                $join->on('agents_posts.post_id', '=', 'agents_users_conections.post_id');
            })

            ->leftJoin('agents_users', 'agents_users.id', '=', 'agents_posts.agents_user_id')

            ->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state')

            ->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_posts.agents_user_id');

            

        $query1->where(function ($query) use ($where, $orwhere) {

            $query->whereRaw(DB::raw(



                'CASE WHEN agents_users_conections.to_id = ' . $where['agents_users_conections.to_id'] . ' AND agents_users_conections.to_role = ' . $where['agents_users_conections.to_role'] . '



			                    THEN agents_users_conections.from_id 	= 	agents_posts.agents_user_id



			                    WHEN agents_users_conections.from_id 	= ' . $orwhere['agents_users_conections.from_id'] . '  AND agents_users_conections.from_role = ' . $orwhere['agents_users_conections.from_role'] . '



			                    THEN agents_users_conections.to_id 		= 	agents_posts.agents_user_id END'



            ));
        });

        if ($selected != null && $selected == 1) :

            $query1->where(array('agents_posts.applied_post' => $selected));

            $query1->where(array('agents_posts.applied_user_id' => $where['agents_users_conections.to_id']));

        endif;

        if ($selected != null && $selected == 2) :

            $query1->where(array('agents_posts.applied_post' => $selected));

        endif;

        if ($where['agents_posts.agents_users_role_id'] != null) {
            $query1->where(['agents_posts.agents_users_role_id' => $where['agents_posts.agents_users_role_id']]);
        }

        $query1->select('agents_state.state_name', 'agents_posts.*', 'agents_posts.closing_date as post_close_date', 'agents_posts.updated_at as pupdated_at', 'agents_users.login_status', 'agents_users_details.name', 'agents_users_details.details_id', 'agents_users_conections.*', DB::raw('(CASE WHEN agents_users_conections.to_id = ' . $where['agents_users_conections.to_id'] . ' AND agents_users_conections.to_role = ' . $where['agents_users_conections.to_role'] . ' THEN "to"  WHEN agents_users_conections.from_id = ' . $where['agents_users_conections.to_id'] . '  AND agents_users_conections.from_role = ' . $where['agents_users_conections.to_role'] . ' THEN "from" END) AS is_user'))

            ->orderBy('agents_users_conections.updated_at', 'DESC');

        $queryunion = $query1;



        $count = $queryunion->count();

        $result = $queryunion->skip($limit * 10)->take(10)->get();


        $obj = [];

        foreach ($result as $value) {

            $post_view_count = $this->postviewcount($value->post_id);

            if ($value->is_user == 'to') {



                $bd = (object) array('details_id' => $value->from_id, 'details_id_role_id' => $value->from_role);
            } else {



                $bd = (object) array('details_id' => $value->to_id, 'details_id_role_id' => $value->to_role);
            }

            $post_share_count = $this->getspecificnotificationbypost_id($bd, $value->post_id, $where['agents_users_conections.to_id'], $where['agents_users_conections.to_role']);

            $post_messages_count = $this->getspecificmessagenotificationbypost_id($bd, $value->post_id, $where['agents_users_conections.to_id'], $where['agents_users_conections.to_role']);



            $obj[] = (object) array_merge((array) $value, (array) $post_view_count, (array) $post_messages_count, (array) $post_share_count);
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

    /* Post view count process */
    public function postviewcount($post_id)

    {

        return DB::table('agents_users_conections')

            ->select(DB::raw('count(*) as post_view_count'))

            ->where('post_id', $post_id)

            ->groupBy('post_id')

            ->first();
    }

    /* Appled agents detail get for buyer */
    public function AppliedAgentsListGetForBuyer($limit, $post_id, $userid, $roleid)

    {

        $query1 = DB::table('agents_users_conections as m')

            ->join('agents_users_details as u', function ($join) {

                $join->on('u.details_id', '=', 'm.to_id')

                    ->orOn('u.details_id', '=', 'm.from_id');
            })
            ->join('agents_conversation as mc', function ($join) {
                $join->on('u.details_id', '=', 'mc.sender_id')
                    ->orOn('u.details_id', '=', 'mc.receiver_id');
            })

            ->leftJoin('agents_state', 'agents_state.state_id', '=', 'u.state_id')

            ->leftJoin('agents_city', 'agents_city.city_id', '=', 'u.city_id')

            ->join('agents_users', 'agents_users.id', '=', 'u.details_id')

            ->where(function ($query) use ($post_id, $userid, $roleid) {

                $query->whereRaw(DB::raw(



                    'CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . '

					            THEN m.from_id = u.details_id

					            WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . '

					            THEN m.to_id = u.details_id END'



                ));
            })

            ->Join('agents_users_roles', 'agents_users_roles.role_id', '=', 'agents_users.agents_users_role_id')

            ->where(array('m.post_id' => $post_id))

            ->select('mc.conversation_id', 'agents_users.id', 'agents_users.agents_users_role_id', 'u.brokers_name', 'agents_state.state_name', 'agents_city.city_name', 'm.*', 'u.name', 'u.description', 'u.photo', 'u.years_of_expreience', 'u.details_id', DB::raw('(CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . ' THEN m.from_role  WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . ' THEN m.to_role END) AS details_id_role_id'), DB::raw('(CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . ' THEN "to"  WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . ' THEN "from" END) AS is_user'), 'agents_users.login_status', 'agents_users_roles.role_name')

            ->orderBy('m.created_at', 'DESC')
            ->groupBy('m.post_id');

        $queryunion = $query1;



        $count = $queryunion->count();

        $result = $queryunion->skip($limit * 10)->take(10)->get();

        $obj = [];

        foreach ($result as $value) {



            $agentscompare = $this->checkcompare($value, $post_id, $userid, $roleid);

            $post_share_count = $this->getspecificnotificationbypost_id($value, $post_id, $userid, $roleid);

            $post_messages_count = $this->getspecificmessagenotificationbypost_id($value, $post_id, $userid, $roleid);

            $obj[] = (object) array_merge((array) $value, (array) $post_messages_count, (array) $post_share_count, (array) $agentscompare);
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

    /* Get applied agents info for buyer */
    public function AppliedAgentsListGetForBuyerlimitfive($post_id, $userid, $roleid)

    {

        $query1 = DB::table('agents_users_conections as m')

            ->join('agents_users_details as u', function ($join) {

                $join->on('u.details_id', '=', 'm.to_id')

                    ->orOn('u.details_id', '=', 'm.from_id');
            })

            ->leftJoin('agents_state', 'agents_state.state_id', '=', 'u.state_id')

            ->leftJoin('agents_city', 'agents_city.city_id', '=', 'u.city_id')

            ->join('agents_users', 'agents_users.id', '=', 'u.details_id')

            ->where(function ($query) use ($post_id, $userid, $roleid) {

                $query->whereRaw(DB::raw(

                    'CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . '

					            THEN m.from_id = u.details_id

					            WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . '

                                THEN m.to_id = u.details_id END'

                ));
            })

            ->where(array('m.post_id' => $post_id))

            ->select('agents_users.id', 'agents_users.agents_users_role_id', 'u.brokers_name', 'agents_state.state_name', 'agents_city.city_name', 'm.*', 'u.name', 'u.description', 'u.photo', 'u.years_of_expreience', 'u.details_id', DB::raw('(CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . ' THEN m.from_role  WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . ' THEN m.to_role END) AS details_id_role_id'), DB::raw('(CASE WHEN m.to_id = ' . $userid . ' AND m.to_role = ' . $roleid . ' THEN "to"  WHEN m.from_id = ' . $userid . '  AND m.from_role = ' . $roleid . ' THEN "from" END) AS is_user'))

            ->orderBy('m.created_at', 'DESC');

        $queryunion = $query1;

        $count = $queryunion->count();

        $result = $queryunion->skip(0)->take(5)->get();

        // $obj=[];

        // foreach ($result as $value) {



        // $agentscompare = $this->checkcompare($value,$post_id,$userid,$roleid);

        // $post_share_count = $this->getspecificnotificationbypost_id($value,$post_id,$userid,$roleid);

        // $post_messages_count = $this->getspecificmessagenotificationbypost_id($value,$post_id,$userid,$roleid);

        // $obj[] = (object) array_merge((array) $value, (array) $post_messages_count, (array) $post_share_count, (array) $agentscompare);

        // }

        // $result = $obj;

        $data = array('result' => $result, 'count' => $count);

        return $data;
    }

    /* Get specific notification by post id */
    public function getspecificnotificationbypost_id($value1, $post_id, $userid, $roleid)
    {
        $query = DB::table('agents_notification')

            ->whereIn('notification_type', [1, 2, 3, 4, 5, 8, 9, 10])

            ->where(array(

                'sender_id' => $value1->details_id,

                'sender_role' => $value1->details_id_role_id,

                'receiver_id' => $userid,

                'receiver_role' => $roleid,

                'status' => 1,

            ))

            ->select('agents_notification.*');

        $count = $query->count();

        $query->orderBy('notification_id', 'DESC');

        $result = $query->get();

        $obj = [];

        foreach ($result as $value) {

            if ($value->notification_type == 10) {

                $mergedata = $this->AskedQuestionReturnAnswer($value, $post_id, $userid, $roleid);

                if (!empty($mergedata)) {

                    $obj[] = (object) array_merge((array) $value, (array) $mergedata);
                }
            }

            if (in_array($value->notification_type, [1, 2, 3, 4, 5])) {

                $mergedata = $this->sharedatajoin($value, $post_id, $userid, $roleid);

                if (!empty($mergedata)) {

                    $obj[] = (object) array_merge((array) $value, (array) $mergedata);
                }
            }

            if (in_array($value->notification_type, [8, 9])) {

                $mergedata = $this->retingdatajoin($value, $post_id, $userid, $roleid);

                if (!empty($mergedata)) {

                    $obj[] = (object) array_merge((array) $value, (array) $mergedata);
                }
            }
        }

        $result = $obj;

        $data = array();

        $data['notificatio'] = array('result' => $result, 'count' => $count);

        return $data;
    }

    /* For share data process */
    public function sharedatajoin($value, $post_id, $userid, $roleid)
    {

        $queryc = DB::table('agents_shared')

            ->where(array(
                'agents_shared.shared_item_id'     => $value->notification_child_item_id,

                'agents_shared.shared_id'         => $value->notification_item_id,

                'agents_shared.shared_item_type_id' => $post_id,

                'agents_shared.sender_id'         => $value->sender_id,

                'agents_shared.sender_role'     => $value->sender_role,

                'agents_shared.receiver_id'     => $userid,

                'agents_shared.receiver_role'     => $roleid,

            ))

            ->select('agents_shared.shared_item_type_id as post_id');

        $result = $queryc->first();

        return $result;
    }

    /* For rating data */
    public function retingdatajoin($value, $post_id, $userid, $roleid)
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

                    'agents_shared.shared_item_type_id' => $post_id,

                ))

                ->where('agents_shared.shared_type', 1)

                ->select('agents_shared.shared_item_type_id as post_id');

            $result1 = $queryc->first();
        }

        if ($result->rating_type == 2) {

            $queryc = DB::table('agents_conversation_message')

                ->where(array(

                    'agents_conversation_message.messages_id' => $result->rating_item_id,

                    'agents_conversation_message.conversation_id' => $result->rating_item_parent_id,

                    'agents_conversation_message.post_id' => $post_id,

                ))

                ->select('post_id');

            $result1 = $queryc->first();
        }

        return $result1;
    }

    /* Asked question return answer details */
    public function AskedQuestionReturnAnswer($value, $post_id, $userid, $roleid)
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

                'agents_shared.shared_item_type_id' => $post_id,

            ))

            ->where('agents_shared.shared_type', 1)

            ->select('agents_shared.shared_item_type_id as post_id');

        return $result1 = $queryc->first();
    }

    /* For get specific message notification by post id */
    public function getspecificmessagenotificationbypost_id($value, $post_id, $userid, $roleid)
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

                'n.sender_id'         => $value->details_id,

                'n.sender_role'     => $value->details_id_role_id,

                'n.receiver_id'     => $userid,

                'n.receiver_role'     => $roleid,

                'n.status'             => 1,

                'c.post_id'         => $post_id,

            ))

            ->whereIn('n.notification_type', [6, 7])

            ->select('n.*', 'c.conversation_id', 'c.post_id', 'c.snippet', 'u.name', 'u.details_id', 'u.photo')

            ->orderBy('n.created_at', 'DESC')

            ->groupBy('c.conversation_id');

        $result = $query1->get();

        $count = count($result);

        $data = array();

        $data['message_notificatio'] = array('result' => $result, 'count' => $count);

        return $data;
    }

    /*search post public by agents*/
    public function getSearchAnyByAny($limit, $where = null)
    {
        $bookmark = new Bookmark;

        $rating = new Rating;

        $loginusser = Auth::user();

        if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'post_contains') {

            $query = DB::table('agents_posts')

                ->select('agents_posts.*', 'agents_state.state_name', 'agents_city.city_name', 'agents_users.id', 'agents_posts.home_type', 'agents_posts.when_do_you_want_to_sell', 'agents_posts.posttitle', 'agents_posts.address1', 'agents_posts.created_at', 'agents_posts.updated_at', 'agents_posts.details', 'agents_posts.post_id', 'agents_users.login_status', 'agents_users.agents_users_role_id', 'agents_users.api_token', 'agents_users_details.name', 'agents_users_details.details_id', 'agents_users_details.description', 'agents_users_details.years_of_expreience', 'agents_users_details.price_range', 'agents_users_roles.role_name')

                ->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state')

                ->leftJoin('agents_city', 'agents_city.city_id', '=', 'agents_posts.city')

                ->leftJoin('agents_users_roles', 'agents_users_roles.role_id', '=', 'agents_posts.agents_users_role_id')

                ->Join('agents_users', 'agents_users.id', '=', 'agents_posts.agents_user_id')

                ->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');

            if ($where['date'] && $where['date'] != '') {

                $dd = explode('-', $where['date']);

                //print_r($dd);

                //echo $where['date'];

                $dd1 = date('Y-m-d', strtotime($dd[0]));

                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query->where(function ($query1) use ($dd1, $dd2) {

                    $query1->whereBetween('agents_posts.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['city'] && $where['city'] != '') {

                $query->where('agents_posts.city', $where['city']);
            }

            if ($where['state'] && $where['state'] != '') {

                $query->where('agents_posts.state', $where['state']);
            }

            if ($where['zipcodes'] && $where['zipcodes'] != '') {

                $query->where('agents_posts.zip', $where['zipcodes']);
            }

            if ($where['pricerange'] && $where['pricerange'] != '') {

                // $query->where('agents_users_details.price_range', $where['pricerange']);

            }

            if ($where['address'] && $where['address'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_posts.address1', 'LIKE', "%" . $where['address'] . "%");

                    $query1->orWhere('agents_posts.address2', 'LIKE', "%" . $where['address'] . "%");

                    $query1->orWhere('agents_posts.city', 'LIKE', "%" . $where['address'] . "%");

                    //$query1->orWhere('agents_posts.area', 'LIKE', "%".$where['address']."%");

                });
            }

            if (!empty($where['cityName'])) {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_posts.city', 'LIKE', "%" . $where['cityName'] . "%");
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_posts.posttitle', 'LIKE', "%" . $where['keyword'] . "%");

                    $query1->orWhere('agents_posts.details', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }

            $query->where('agents_posts.is_deleted', '0');

            $query->where('agents_posts.status', '1');

            $query->where('agents_posts.applied_post', '2');

            $query->groupBy('agents_posts.post_id');

            $query->orderBy('agents_posts.created_at', 'DESC');

            $count = $query->get()->count();

            $result = $query->skip($limit * 10)->take(10)->get();

            //echo '<pre>';  print_r($result); die;

            $obj = [];

            foreach ($result as $value) {

                $post_view_count = $this->postviewcountandagentlist($value, array('agents_posts.agents_user_id' => $value->id, 'agents_posts.agents_users_role_id' => $value->agents_users_role_id));

                $obj[] = (object) array_merge((array) $value, (array) $post_view_count);
            }

            $result = $obj;

            $coun = floor($count / 10);

            $prview = $limit == 0 ? 0 : $limit - 1;

            $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

            $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

            $llimit = $next * 10 == 0 ? $count : $next * 10;

            $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

            return $data;
        } else if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'name') {

            $query = DB::table('agents_users')

                ->select('agents_users.*', 'agents_users_details.*', 'agents_state.state_name', 'agents_users_details.city_id as city_name')

                ->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id')

                ->leftJoin('agents_posts', 'agents_posts.agents_user_id', '=', 'agents_users.id')

                ->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_users_details.state_id');

            //->leftJoin('agents_city', 'agents_city.city_id', '=', 'agents_users_details.city_id');



            if ($where['date'] && $where['date'] != '') {

                $dd = explode('-', $where['date']);

                $dd1 = date('Y-m-d', strtotime($dd[0]));

                $dd2 = date('Y-m-d', strtotime($dd[1]));

                // $query->where(function($query1) use($dd1,$dd2){

                $query->whereBetween('agents_users.created_at', [$dd1, $dd2]);

                // });

            }

            if ($where['usertype'] && $where['usertype'] != '') {

                $query->where('agents_posts.agents_users_role_id', $where['usertype']);
            }

            /* if($where['city'] && $where['city'] != ''){

        		$query->where('agents_users_details.city_id', $where['city']);

	        }*/

            if (!empty($where['cityName'])) {

                $query->where(function ($q) use ($where) {

                    $q->where('agents_users_details.city_id', 'LIKE', "%" . $where['cityName'] . "%");

                    //$q->where('agents_users_details.city_id', '<>', '');

                });
            }

            if ($where['state'] && $where['state'] != '') {

                $query->where('agents_users_details.state_id', $where['state']);
            }

            if ($where['zipcodes'] && $where['zipcodes'] != '') {

                $query->where('agents_users_details.zip_code', $where['zipcodes']);
            }

            // if($where['pricerange'] && $where['pricerange'] != ''){

            // $query->where('agents_users_details.price_range', $where['pricerange']);

            // }

            if ($where['address'] && $where['address'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_users_details.address1', 'LIKE', "%" . $where['address'] . "%");

                    $query1->orWhere('agents_users_details.address2', 'LIKE', "%" . $where['address'] . "%");
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_users_details.name', 'LIKE', "%" . $where['keyword'] . "%");

                    $query1->orWhere('agents_users_details.description', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }

            $query->where('agents_users.is_deleted', '0');

            $query->groupBy('agents_users.id');

            $query->orderBy('agents_users.created_at', 'DESC');

            $count = $query->get()->count();

            $result = $query->skip($limit * 10)->take(10)->get();

            $coun = floor($count / 10);

            $prview = $limit == 0 ? 0 : $limit - 1;

            $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

            $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

            $llimit = $next * 10 == 0 ? $count : $next * 10;

            $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

            return $data;
        } else if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'messages') {

            $query = DB::table('agents_conversation_message as m')

                ->join('agents_users_details as u', function ($join) {

                    $join->on('u.details_id', '=', 'm.sender_id')

                        ->orOn('u.details_id', '=', 'm.receiver_id');
                })

                ->leftJoin('agents_users as uu', 'uu.id', '=', 'u.details_id')

                ->leftJoin('agents_posts as p', 'p.post_id', '=', 'm.post_id')

                ->leftJoin('agents_conversation as cc', 'cc.conversation_id', '=', 'm.conversation_id')

                ->where(function ($query1) use ($loginusser) {

                    $query1->where(array(
                        'm.sender_id'           => $loginusser->id,

                        'm.sender_role'         => $loginusser->agents_users_role_id,

                    ));

                    $query1->orWhere(array(

                        'm.receiver_id'         => $loginusser->id,

                        'm.receiver_role'       => $loginusser->agents_users_role_id,

                    ));
                })

                ->where(function ($query1) use ($loginusser) {

                    $query1->whereRaw(DB::raw(



                        'CASE WHEN m.sender_id = ' . $loginusser->id . ' AND m.sender_role = ' . $loginusser->agents_users_role_id . '

					            THEN m.receiver_id = u.details_id

					            WHEN m.receiver_id = ' . $loginusser->id . '  AND m.receiver_role = ' . $loginusser->agents_users_role_id . '

					            THEN m.sender_id = u.details_id END'



                    ));
                });

            if ($where['date'] && $where['date'] != '') {

                $dd = explode('-', $where['date']);

                $dd1 = date('Y-m-d', strtotime($dd[0]));

                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query->where(function ($query1) use ($dd1, $dd2) {

                    $query1->whereBetween('m.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('m.message_text', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }

            $query->select('u.details_id as receiver_user_id', 'm.*', 'uu.login_status', 'uu.api_token', 'u.name', 'u.photo', 'p.posttitle', 'p.details as post_details', 'cc.snippet', DB::raw('(CASE WHEN m.sender_id = ' . $loginusser->id . ' AND m.sender_role = ' . $loginusser->agents_users_role_id . ' THEN m.receiver_role  WHEN m.receiver_id = ' . $loginusser->id . '  AND m.receiver_role = ' . $loginusser->agents_users_role_id . ' THEN m.sender_role END) AS receiver_user_role_id'), DB::raw('(CASE WHEN m.sender_id = ' . $loginusser->id . ' AND m.sender_role = ' . $loginusser->agents_users_role_id . ' THEN "sender"  WHEN m.receiver_id = ' . $loginusser->id . '  AND m.receiver_role = ' . $loginusser->agents_users_role_id . ' THEN "receiver" END) AS is_user'))

                ->orderBy('m.messages_id', 'DESC');

            $count = $query->count();

            $result = $query->skip($limit * 10)->take(10)->get();

            $coun = floor($count / 10);

            $prview = $limit == 0 ? 0 : $limit - 1;

            $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

            $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

            $llimit = $next * 10 == 0 ? $count : $next * 10;

            $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

            return $data;
        } else if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'questions_asked') {

            $query = DB::table('agents_shared');

            $query->leftJoin('agents_question', 'agents_question.question_id', '=', 'agents_shared.shared_item_id');

            $query->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_shared.shared_item_type_id');

            $query->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_shared.receiver_id');

            $query->where(array('agents_shared.shared_type' => '1', 'agents_shared.receiver_id' => $loginusser->id, 'agents_shared.receiver_role' => $loginusser->agents_users_role_id, 'agents_question.is_deleted' => '0'));

            if ($where['date'] && $where['date'] != '') {

                $dd = explode('-', $where['date']);

                $dd1 = date('Y-m-d', strtotime($dd[0]));

                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query->where(function ($query1) use ($dd1, $dd2) {

                    $query1->whereBetween('agents_shared.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_question.question', 'LIKE', "%" . $where['keyword'] . "%");

                    // $query1->orwhere('agents_posts.posttitle', 'LIKE', "%".$where['keyword']."%");

                });
            }

            $query->select('agents_shared.*', 'agents_question.question', 'agents_question.question_type', 'agents_question.question_id', 'agents_users_details.name', 'agents_users_details.photo', 'agents_users_details.description', 'agents_posts.posttitle', 'agents_posts.post_id', 'agents_posts.details')

                ->orderBy('agents_shared.created_at', 'DESC');

            $count = $query->count();

            $result = $query->skip($limit * 10)->take(10)->get();

            $coun = floor($count / 10);

            $prview = $limit == 0 ? 0 : $limit - 1;

            $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

            $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

            $llimit = $next * 10 == 0 ? $count : $next * 10;

            $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

            return $data;
        } else if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'questions_answered') {

            $query = DB::table('agents_shared');

            $query->leftJoin('agents_answers', 'agents_answers.question_id', '=', 'agents_shared.shared_item_id');

            $query->Join('agents_question', 'agents_question.question_id', '=', 'agents_shared.shared_item_id');

            $query->Join('agents_posts', 'agents_posts.post_id', '=', 'agents_shared.shared_item_type_id');

            $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_shared.receiver_id');

            $query->where(array('agents_shared.shared_type' => '1', 'agents_question.is_deleted' => '0'));

            $query->where(array('agents_question.add_by' => $loginusser->id, 'agents_question.add_by_role' => $loginusser->agents_users_role_id));

            if ($where['date'] && $where['date'] != '') {

                $dd = explode('-', $where['date']);

                $dd1 = date('Y-m-d', strtotime($dd[0]));

                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query->where(function ($query1) use ($dd1, $dd2) {

                    $query1->whereBetween('agents_shared.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_answers.answers', 'LIKE', "%" . $where['keyword'] . "%");

                    $query1->orWhere('agents_question.question', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }

            $query->select('agents_shared.shared_id', 'agents_shared.created_at as shared_date', 'agents_question.question', 'agents_question.question_id', 'agents_question.question_type', 'agents_answers.answers', 'agents_answers.answers_id', 'agents_answers.from_id', 'agents_answers.from_role', 'agents_posts.post_id', 'agents_posts.posttitle', 'agents_posts.details', 'agents_users_details.name', 'agents_users_details.photo', 'agents_users_details.description')

                ->orderBy('agents_shared.created_at', 'DESC');

            $count = $query->count();

            $result = $query->skip($limit * 10)->take(10)->get();

            $obj = [];

            foreach ($result as $value) {

                $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => 4, 'bookmark_item_id' => $value->answers_id, 'bookmark_item_parent_id' => $value->question_id, 'sender_id' => $loginusser->id, 'sender_role' => $loginusser->agents_users_role_id));

                $rat = $rating->getRatingSingalByAny(array('rating_type' => 1, 'rating_item_id' => $value->answers_id, 'rating_item_parent_id' => $value->question_id));

                $obj[] = (object) array_merge((array) $value, (array) array('bookmark' => $bok), (array) array('rating' => $rat));
            }

            $result = $obj;

            $coun = floor($count / 10);

            $prview = $limit == 0 ? 0 : $limit - 1;

            $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

            $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

            $llimit = $next * 10 == 0 ? $count : $next * 10;

            $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

            return $data;
        } else if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'answers') {

            $query = DB::table('agents_answers');

            $query->Join('agents_question', 'agents_question.question_id', '=', 'agents_answers.question_id');

            $query->leftJoin('agents_posts', 'agents_posts.post_id', '=', 'agents_answers.post_id');

            $query->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_question.add_by');

            $query->where(array('agents_answers.from_id' => $loginusser->id, 'agents_answers.from_role' => $loginusser->agents_users_role_id, 'agents_question.is_deleted' => '0'));

            $query->whereNotIn('agents_question.add_by_role', [1]);

            if ($where['date'] && $where['date'] != '') {

                $dd = explode('-', $where['date']);

                $dd1 = date('Y-m-d', strtotime($dd[0]));

                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query->where(function ($query1) use ($dd1, $dd2) {

                    $query1->whereBetween('agents_answers.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_answers.answers', 'LIKE', "%" . $where['keyword'] . "%");

                    $query1->orWhere('agents_question.question', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }

            $query->select('agents_question.question', 'agents_question.question_id', 'agents_question.question_type', 'agents_answers.*', 'agents_posts.post_id', 'agents_posts.posttitle', 'agents_posts.details', 'agents_users_details.name', 'agents_users_details.photo', 'agents_users_details.description')

                ->orderBy('agents_answers.created_at', 'DESC');

            $count = $query->count();

            $result = $query->skip($limit * 10)->take(10)->get();

            $obj = [];

            foreach ($result as $value) {

                $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => 4, 'bookmark_item_id' => $value->answers_id, 'bookmark_item_parent_id' => $value->question_id, 'sender_id' => $loginusser->id, 'sender_role' => $loginusser->agents_users_role_id));

                $rat = $rating->getRatingSingalByAny(array('rating_type' => 1, 'rating_item_id' => $value->answers_id, 'rating_item_parent_id' => $value->question_id));

                $obj[] = (object) array_merge((array) $value, (array) array('bookmark' => $bok), (array) array('rating' => $rat));
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
    }

    /* reply answers process */
    public function replyanswersgetbypostidanduseridwithbookmarkandrating($value, $loginusser, Request $request)
    {
        $question   = new QuestionAnswers;
        $ans = $question->getAnswersByAny(array('post_id' => $value->post_id, 'is_deleted' => '0', 'question_id' => $value->question_id, 'from_id' => $value->receiver_id, 'from_role' => $value->receiver_role));
        if (empty($ans)) {
            $answers[$value->question_id] = '';
        } else {
            $answers[$value->question_id] = $ans;
            if ($request->input('bookmark') && !empty($request->input('bookmark'))) {
                $bookmark = new Bookmark;
                $bok = $bookmark->getBookmarkSingalByAny();
                if (empty($bok)) {
                    $bookmarkdata[$ans->answers_id] = '';
                } else {
                    $bookmarkdata[$ans->answers_id] = $bok;
                }
            }
            if ($request->input('rating') && !empty($request->input('rating'))) {
                $rating = new Rating;
                $rat = $rating->getRatingSingalByAny(array('rating_type' => 1, 'rating_item_id' => $ans->answers_id, 'rating_item_parent_id' => $ans->question_id, 'sender_id' => $request->input('add_by'), 'sender_role' => $request->input('add_by_role'), 'receiver_id' => $request->input('receiver_id'), 'receiver_role' => $request->input('question_type')));
                if (empty($rat)) {

                    $ratingdata[$ans->answers_id] = '';
                } else {
                    $ratingdata[$ans->answers_id] = $rat;
                }
            }
        }
    }

    /*  check compare details */
    public function checkcompare($value, $post_id, $userid, $roleid)
    {
        $queryc = DB::table('agents_compare')

            ->where(array(

                'post_id'                 => $value->post_id,

                'sender_id'             => $userid,

                'sender_role'             => $roleid,

            ))

            ->whereRaw('FIND_IN_SET(' . $value->id . ',compare_item_id)')

            ->select('agents_compare.*');

        $result = $queryc->first();

        $data = array();
        $data['compare'] = array('result' => $result);
        return $data;
    }

    /* For get all posts show in admin. */
    public function getPostList($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        $query = DB::table('agents_posts as a')->select('a.*', 'b.name', 'c.role_name');
        $query->Join('agents_users_details as b', 'b.details_id', '=', 'a.agents_user_id');

        $query->Join('agents_users_roles as c', 'c.role_id', '=', 'a.agents_users_role_id');
        $query->where('a.is_deleted', '0');
        if ($request['search']['value'] == 'active' || (isset($request['columns']) && isset($request['columns'][6]) && $request['columns'][6]['search']['value'] == 'active')) {
            // $statusQuery = 1;
            $query->where('a.status', 1);
        } else if ($request['search']['value'] == 'deactive' || (isset($request['columns']) && isset($request['columns'][6]) && $request['columns'][6]['search']['value'] == 'deactive')) {
            // $statusQuery = 0;
            $query->where('a.status', 0);
        } else {
            $statusQuery = '';
        }
        if (
            $request['search']['value'] == 'buyer' || 
            $request['search']['value'] == 'seller'
        ) {
            //$query->where('a.posttitle', 'like', "%".$request['search']['value']."%");
            //$query->orwhere('b.name', 'like', "%".$request['search']['value']."%");
            $query->where('c.role_name', 'like', "%" . $request['search']['value'] . "%");
        }
        if(
            (
                isset($request['columns']) && 
                isset($request['columns'][4]) && 
                $request['columns'][4]['search']['value'] == 'buyer'
            ) || 
            (
                isset($request['columns']) && 
                isset($request['columns'][4]) && 
                $request['columns'][4]['search']['value'] == 'seller'
            )) {
                $query->where('c.role_name', 'like', "%" . $request['columns'][4]['search']['value'] . "%");
            }
        // if ($statusQuery != '') {
        //     $query->where('a.status', $statusQuery);
        // }
        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)->skip($offset);
        }

        if(isset($request['order'][0]['column'])) {
            $arr = ['a.post_id', 'a.posttitle', 'a.address1', 'b.name', 'c.role_name', 'a.created_at'];
            $columns = isset($arr[$request['order'][0]['column']]) ? $arr[$request['order'][0]['column']] : 'a.post_id';
            $dir = $request['order'][0]['dir'];
            $query->orderBy($columns, $dir);
        } else {
            $query->orderBy('a.post_id', 'DESC');
        }
        $result['result'] =  $query->get();
        // dd($query->toSql());
        return $result;
    }

    public function getAppliedPostsBySelectedAgent($agentId)
    {
        $result = DB::table('agents_posts')
            ->where([['applied_user_id', '=', $agentId]])
            ->whereNotNull('closing_date')
            ->count();
        return $result;
    }

    /* Agent selectd for posts */
    public function SelectedPostListGetForAgents($limit = null, $where = null, $selected = null)
    {
        $query1 = DB::table('agents_posts')
            ->leftJoin('agents_users', 'agents_users.id', '=', 'agents_posts.agents_user_id')
            ->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_posts.state')
            ->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_posts.agents_user_id')
            ->where($where);

        $query1->select('agents_state.state_name', 'agents_posts.*', 'agents_posts.updated_at as pupdated_at', 'agents_users.login_status', 'agents_users_details.name', 'agents_users_details.details_id')
            ->orderBy('agents_posts.agent_select_date', 'DESC');
        $queryunion = $query1;
        $count = $queryunion->count();
        $result = $queryunion->skip($limit * 10)->take(10)->get();

        $coun = floor($count / 10);
        $prview = $limit == 0 ? 0 : $limit - 1;
        $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);
        $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;
        $llimit = $next * 10 == 0 ? $count : $next * 10;
        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);
        return $data;
    }

    /* Get the unclosed post counts */
    public function get_pending_closed_count($agent_id)
    {
        $pending_closing_date_count = DB::table('agents_posts')
            ->where(['applied_user_id' => $agent_id, 'status' => 1])
            ->whereNotNull('agent_select_date')
            ->whereNull('closing_date')
            ->get();

        $final_count = 0;

        /*  echo "<pre>";
        print_r($pending_closing_date_count);
        exit;
*/
        foreach ($pending_closing_date_count as $post) {
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $post->agent_select_date);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i'));
            $diff_in_days = $to->diffInDays($from);

            if ($diff_in_days > env('MIN_CLOSE_DATE')) {
                $final_count++;
            }
        }
        return $final_count;
    }
}
