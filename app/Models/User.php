<?php

namespace App\Models;

use App\Events\eventTrigger;
use App\Models\Userdetails;
use App\Models\Agentskills;
use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = "agents_users";
    protected $primaryKey = "id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'agent_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function details()
    {
        return $this->hasOne('App\Userdetails', 'details_id', 'id');
    }

    /* Insert usr */
    public function inserupdate($data = null, $id = null)
    {
        if (empty($id)) {
            $result = DB::table('agents_users')->insertGetId($data);
        } else {
            $result = DB::table('agents_users')->where($id)->update($data);
        }
        return $result;
    }

    /* get all data any filed using*/
    public function getuserSingalByAny($where = null)
    {
        $query = DB::table('agents_users')->select('*');
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        return $result = $query->first();
    }

    /* get user by email or id */
    public function getByEmailOrId($where = array())
    {

        $query = DB::table('agents_users')->select('*')
            ->where(array('agents_users.email' => $where['email'], 'agents_users.agents_users_role_id' => $where['role']))
            ->first();
        return $query;
    }

    /* get user data */
    public function getByanydata($where = array())
    {

        $query = DB::table('agents_users')->select('*');
        if ($where != null) {
            $query->where($where);
        }
        return $query->first();
    }

    /* Get usr details by email or id */
    public function getDetailsByEmailOrId($where = array())
    {

        $query = DB::table('agents_users')->select('*');
        $query->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');
        if (!empty($where['email'])) :
            $query->where(array('agents_users.email' => $where['email']));
        endif;

        if (!empty($where['id'])) :
            $query->where(array('agents_users.id' => $where['id']));
        endif;

        if (!empty($where['role_id'])) :
            $query->where(array('agents_users.agents_users_role_id' => $where['role_id']));
        endif;

        if (!empty($where['forgot_token'])) :
            $query->where(array('agents_users.forgot_token' => $where['forgot_token']));
        endif;

        $query->where('agents_users.is_deleted', '0');
        $query->orderBy('agents_users_details.created_at', 'DESC');
        $result = $query->first();

        return $result;
    }

    /* for random password */
    public function randPassword($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{@#()!%&^*-*/-!}';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /* get all data any filed using*/
    public function getLmitedUsersByAny($limit, $where = null, $compare = null)
    {

        $query = DB::table('agents_users')->select('*');
        $query->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');

        if ($where != null) {
            $query->where($where);
        }

        $query->orderBy('agents_users_details.created_at', 'DESC');
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

    /* get all data any filed using*/
    public function getforeUsersByAnyonly($limit, $where = null)
    {
        $query = DB::table('agents_users')->select('*');
        $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');
        $query->Join('agents_state', 'agents_state.state_id', '=', 'agents_users_details.state_id');
        $query->Join('agents_city', 'agents_city.city_id', '=', 'agents_users_details.city_id');

        if ($where != null) {
            $query->where($where);
        }

        $query->whereNotNull('agents_users_details.photo');
        $query->orderBy('agents_users.id', 'DESC');
        $count = $query->count();
        $result = $query->skip($limit * 4)->take(4)->get();
        $coun = floor($count / 4);
        $prview = $limit == 0 ? 0 : $limit - 1;
        $next   = $coun == $limit ? 0 : ($count <= 4 ? 0 : $limit + 1);
        $rlimit = $limit * 4 == 0 ? 1 : $limit * 4;
        $llimit = $next * 4 == 0 ? $count : $next * 4;

        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }

    /* get all data any filed using*/
    public function getuserdetailsByAny($where = null)
    {

        $query = DB::table('agents_users')->select('agents_users.*', 'agents_users_details.*', 'agents_state.state_name', 'agents_state.state_id', 'agents_city.city_name');

        $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');

        $query->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_users_details.state_id');

        $query->leftJoin('agents_city', 'agents_city.city_id', '=', 'agents_users_details.city_id');



        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('agents_users.id', 'DESC');

        return $query->first();
    }


    /* For users connection process */
    public function usersconection($where = null)
    {
        

        $query1 = DB::table('agents_users_conections')->select('*');



        if ($where != null) :

            $query1->where(function ($query) use ($where) {

                $query->where(array('to_id'     => $where['to_id'], 'to_role'     => $where['to_role'], 'from_id' => $where['from_id'], 'from_role'     => $where['from_role'], 'post_id' => $where['post_id']));
            })

                ->orWhere(function ($query) use ($where) {

                    $query->where(array('from_id' => $where['to_id'], 'from_role'     => $where['to_role'], 'to_id'     => $where['from_id'], 'to_role'     => $where['from_role'], 'post_id' => $where['post_id']));
                });

        endif;

        $query1->orderBy('created_at', 'DESC');

        $result = $query1->first();

        if (empty($result)) {

            $where['created_at'] = Carbon::now()->toDateTimeString();

            $where['updated_at'] = Carbon::now()->toDateTimeString();

            $result = DB::table('agents_users_conections')->insertGetId($where);



            $userdd = DB::table('agents_users_details')->select('*')

                ->where(array('details_id' => $where['to_id']))

                ->first();



            $postdd = DB::table('agents_posts')->select('*')

                ->where(array('post_id' => $where['post_id']))

                ->first();



            $notifiy = array(

                'sender_id'         => $where['to_id'], 'sender_role'       => $where['to_role'],

                'receiver_id'       => $where['from_id'], 'receiver_role'     => $where['from_role']

            );

            $notifiy['notification_type']            = 11;

            $notifiy['notification_message']         = $userdd->name . ' contact related to post(' . $postdd->posttitle . ')';

            $notifiy['notification_item_id']         = $result;

            $notifiy['notification_child_item_id']   = $where['post_id'];

            $notifiy['status']                       = 1;

            $notifiy['updated_at']                   = Carbon::now()->toDateTimeString();

            DB::table('agents_notification')->insertGetId($notifiy);

            event(new eventTrigger(array($notifiy, $result, 'NewNotification')));
        } else {

            $result = DB::table('agents_users_conections')->where(array('connection_id' => $result->connection_id))->update(array('updated_at' => Carbon::now()->toDateTimeString()));
        }

        return $result;
    }


    /* Get search user by any */
    public function getSearchUsersByAny($limit, $where = null)

    {

        $skillss = new Agentskills;

        $bookmark = new Bookmark;

        $rating = new Rating;

        $loginusser = Auth::user();

        if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'name') {

            $query = DB::table('agents_users')->select('agents_state.state_name', 'agents_city.city_name', 'agents_users.*', 'agents_users_details.*')

                ->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id')

                ->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_users_details.state_id')

                ->leftJoin('agents_city', 'agents_city.city_id', '=', 'agents_users_details.city_id');



            if ($where['agents_users_role_id'] && $where['agents_users_role_id'] != '') {

                $query->where(array('agents_users.agents_users_role_id' => $where['agents_users_role_id']));
            }

            if ($where['date'] && $where['date'] != '') {

                $dd = explode('-', $where['date']);

                //$dd1 = $dd[0];

                //$dd2 = $dd[1];

                $dd1 = date('Y-m-d', strtotime($dd[0]));

                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query->where(function ($query1) use ($dd1, $dd2) {

                    $query1->whereBetween('agents_users.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['city'] && $where['city'] != '') {

                $query->where(function ($q) use ($where) {

                    $q->where('agents_users_details.city_id', 'LIKE', "%" . $where['city'] . "%");
                });
            }

            if ($where['state'] && $where['state'] != '') {

                $query->where('agents_users_details.state_id', $where['state']);
            }

            if ($where['zipcodes'] && $where['zipcodes'] != '') {

                $query->where('agents_users_details.zip_code', $where['zipcodes']);
            }

            if ($where['pricerange'] && $where['pricerange'] != '') {

                $query->where(function ($q) use ($where) {

                    $q->where('agents_users_details.total_sales', '>=', $where['pricerange'][0]);

                    $q->where('agents_users_details.total_sales', '<=', $where['pricerange'][1]);
                });



                //$query->whereBetween('agents_users_details.total_sales1',[$where['pricerange'][0], $where['pricerange'][1]] );

            }

            if ($where['address'] && $where['address'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_users_details.address', 'LIKE', "%" . $where['address'] . "%");

                    $query1->orWhere('agents_users_details.address2', 'LIKE', "%" . $where['address'] . "%");
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {

                $query->where(function ($query1) use ($where) {

                    $query1->where('agents_users_details.name', 'LIKE', "%" . $where['keyword'] . "%");
                    $query1->orwhere('agents_users_details.fname', 'LIKE', "%" . $where['keyword'] . "%");
                    $query1->orwhere('agents_users_details.lname', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }



            $query->where('agents_users.is_deleted', '0');

            $query->where('agents_users.status', '1');

            $query->orderBy('agents_users_details.created_at', 'DESC');

            $query->groupBy('agents_users_details.details_id');



            $count = $query->get()->count();

            $result = $query->skip($limit * 10)->take(10)->get();

            //echo '<pre>'; print_r$result; die;

            $obj = [];

            if ($count > 0) {

                foreach ($result as $key => $value) {

                    $post_view_count = '';

                    if ($value->skills != null) {

                        $post_view_count = $skillss->getskillsByAny(array(), array('skill_id' => $value->skills));
                    }

                    $obj[] = (object) array_merge((array) $value, (array) array('skill_data' => $post_view_count));
                }
            }

            $result = $obj;

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

            // $query->where(array('agents_shared.shared_type' => '1','agents_shared.sender_id' => $loginusser->id,'agents_shared.sender_role' => $loginusser->agents_users_role_id,'agents_question.add_by' => $loginusser->id,'agents_question.add_by_role' => $loginusser->agents_users_role_id,'agents_question.is_deleted' => '0'));

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

            $query->select('agents_shared.shared_id', 'agents_shared.created_at as shared_date', 'agents_question.question', 'agents_question.question_id', 'agents_question.question_type', 'agents_answers.*', 'agents_posts.post_id', 'agents_posts.posttitle', 'agents_posts.details', 'agents_users_details.name', 'agents_users_details.photo', 'agents_users_details.description')

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

    //Role Manage
    public function hasRole($role)

    {

        if (is_array($role)) {

            return in_array($this->attributes['agents_users_role_id'], $role);
        }



        return $this->attributes['agents_users_role_id'] == $role;
    }



    public function isAdmin()

    {

        return $this->attributes['agents_users_role_id'] == 'admin';
    }



    /* get all data any filed using*/
    public function GetAllTableJoinUserDataByAnyFirst($where = null)
    {



        $query = DB::table('agents_users')->select('agents_users.*', 'agents_users_details.city_id as city_name', 'agents_users_details.*', 'c.role_name', 'agents_state.state_name', 'agents_state.state_code');

        $query->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id');

        $query->leftJoin('agents_users_roles as c', 'c.role_id', '=', 'agents_users.agents_users_role_id');

        $query->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_users_details.state_id');

        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('agents_users_details.created_at', 'DESC');



        return $result = $query->first();
    }


    /* update last few minute activity */
    public function uodatelastfewminuteactivity()

    {

        // $date = new DateTime;

        // echo Carbon::now()->toDateTimeString();

        // echo Carbon::now()->modify('-5 minutes');

        $formatted_date = Carbon::now()->modify('-10 minutes');

        // mail("dilip.owlok@gmail.com","uodatelastfewminuteactivity",'check for cron');

        $result = DB::table('agents_users')->where('login_status', 'Online')->where('login_status', 'online')->where('api_token', '<', $formatted_date)->get();



        foreach ($result as $value) {
            // mail("dilip.owlok@gmail.com","uodatelastfewminuteactivity",'within loop');
            $userupdate = User::find($value->id);

            $userupdate->login_status = 'Offline';

            $userupdate->save();
        }
    }

    /* For update users rating */
    public function updateusersrating($userpostdata)

    {

        $Rating = new Rating();

        $update['rating_type']           =   $userpostdata['rating_type'];

        $update['receiver_id']           =   $userpostdata['receiver_id'];

        $update['receiver_role']         =   $userpostdata['receiver_role'];

        $acheck = $Rating->getRatingagentbuyerByAny($update);

        if (!empty($acheck)) {

            $postcount = count($acheck);

            $ratingpluse = 0;

            foreach ($acheck as $key => $value) {

                $rr = str_replace('_', '.', $value->rating);

                $ratingpluse = $ratingpluse + $rr;
            }

            $totalrating = $ratingpluse / $postcount;



            $userdetails = Userdetails::find($userpostdata['receiver_id']);



            if ($userpostdata['receiver_role'] == 4) { // agent

                $userdetails->agent_rating = $totalrating;
            }



            if ($userpostdata['receiver_role'] == 2) { // buyer

                $userdetails->buyer_rating = $totalrating;
            }



            if ($userpostdata['receiver_role'] == 3) { // seller

                $userdetails->seller_rating = $totalrating;
            }

            return $userdetails->save();
        }

        return false;
    }


    /* For payment details add */
    public function paymentdetailsadd($data = null, $id = null)

    {

        if (empty($id)) {

            $result = DB::table('agents_payment')->insertGetId($data);
        } else {

            $result = DB::table('agents_payment')->where($id)->update($data);
        }

        return $result;
    }

    /* get all data any filed using*/
    public function getPaymentByAny($limit, $userid = null)
    {

        $query = DB::table('agents_payment')->select('*');

        $query->Join('agents_posts', 'agents_posts.post_id', '=', 'agents_payment.post_id');

        $query->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_payment.user_id');

        $query->where(array('agents_payment.user_id' => $userid));

        $query->orderBy('agents_payment.updated_at', 'DESC');

        $count = $query->get()->count();

        $result = $query->skip($limit * 10)->take(10)->get();

        $coun = floor($count / 10);

        $prview = $limit == 0 ? 0 : $limit - 1;

        $next   = $coun == $limit ? 0 : ($count <= 10 ? 0 : $limit + 1);

        $rlimit = $limit * 10 == 0 ? 1 : $limit * 10;

        $llimit = $next * 10 == 0 ? $count : $next * 10;

        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }

    /* Users end review update */
    public function usersendreviewupdate()
    {
        $formatted_date = Carbon::now()->modify('-24 hours');
        $buyer = DB::table('agents_posts')
            ->select('agents_posts.*', 'agents_users.*', 'agents_users_details.*')
            ->Join('agents_users', 'agents_users.id', '=', 'agents_posts.agents_user_id')
            ->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_posts.agents_user_id')
            ->where(array('agents_posts.is_deleted' => '0', 'agents_posts.applied_post' => '1', 'agents_posts.buyer_seller_send_review' => '2'))
            ->where('agents_posts.agent_select_date', '<', $formatted_date)
            ->where('agents_posts.cron_time', '<', $formatted_date)
            ->get();
        foreach ($buyer as $value) {
            $emaildata['url']       = url('/search/agents/details/') . '/' . $value->applied_user_id . '/' . $value->post_id;
            $emaildata['email']     = $value->email;
            $emaildata['name']      = ucwords($value->name);
            $emaildata['posttitle'] = ucwords($value->posttitle);
            $emaildata['html']      = '<div>
		                                        <h3>Hello ' . $value->name . ',</h3>
		                                        <br>
		                                        <p>
		                                           Please give a review and rating for post ' . $value->posttitle . '.
		                                        </p>
		                                        <br>
		                                     <p>Visit post <a href="' . $emaildata['url'] . '">' . $emaildata['posttitle'] . '</a> </p>
		                                    <br>
		                                    <br>
		                                    <center><a href="' . URL('/') . '"> www.92Agents.com </a></center>
		                                  <div>';
            echo Mail::send([], [], function ($message) use ($emaildata) {
                $message->to($emaildata['email'], $emaildata['name'])
                    ->subject('Give a review on post')
                    ->setBody($emaildata['html'], 'text/html');
                $message->from('kamlesh74420@gmail.com', 'kamlesh74420@gmail.com');
            });
        }

        $agents = DB::table('agents_posts')
            ->select('agents_posts.*', 'agents_users.*', 'agents_users_details.*')
            ->Join('agents_users', 'agents_users.id', '=', 'agents_posts.applied_user_id')
            ->Join('agents_users_details', 'agents_users_details.details_id', '=', 'agents_posts.applied_user_id')
            ->where(array('agents_posts.is_deleted' => '0', 'agents_posts.applied_post' => '1', 'agents_posts.agent_send_review' => '2'))
            ->where('agents_posts.agent_select_date', '<', $formatted_date)
            ->get();
        foreach ($agents as $value) {

            $emaildata['url']       = url('/search/post/details/') . '/' . $value->post_id;
            $emaildata['email']     = $value->email;
            $emaildata['name']      = ucwords($value->name);
            $emaildata['posttitle'] = ucwords($value->posttitle);
            if ($value->mark_complete == 2) {
                $emaildata['html']      = '<div>
			                                        <h3>Hello ' . $value->name . ',</h3>
			                                        <br>
			                                        <p>
			                                           Your payment is not complited for post' . $value->posttitle . '.<br> pay now.
			                                        </p>
			                                        <br>
			                                     <p>Visit post and pay <a href="' . $emaildata['url'] . '">' . $emaildata['posttitle'] . '</a> </p>
			                                    <br>
			                                    <br>
			                                    <center><a href="' . URL('/') . '"> www.92Agents.com </a></center>
			                                  <div>';
                $emaildata['subject'] = 'Payment not complited';
            }
            if ($value->mark_complete == 1 && $value->agent_send_review == 2) {
                $emaildata['html']      = '<div>
			                                        <h3>Hello ' . $value->name . ',</h3>
			                                        <br>
			                                        <p>
			                                           Please give a review and rating for post ' . $value->posttitle . '.
			                                        </p>
			                                        <br>
			                                     <p>Visit post <a href="' . $emaildata['url'] . '">' . $emaildata['posttitle'] . '</a> </p>
			                                    <br>
			                                    <br>
			                                    <center><a href="' . URL('/') . '"> www.92Agents.com </a></center>
			                                  <div>';
                $emaildata['subject'] = 'Give a review on post';
            }

            echo Mail::send([], [], function ($message) use ($emaildata) {
                $message->to($emaildata['email'], $emaildata['name'])
                    ->subject($emaildata['subject'])
                    ->setBody($emaildata['html'], 'text/html');
                $message->from('kamlesh74420@gmail.com', 'kamlesh74420@gmail.com');
            });
        }
    }
}
