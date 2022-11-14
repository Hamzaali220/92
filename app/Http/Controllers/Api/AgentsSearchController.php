<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\State;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AgentsSearchController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display the specified resource.
     *
     * @param
     * @return array
     */
    public function getskillsByAny($where = null, $wherein = null)
    {
        $query = DB::table('agents_users_agent_skills')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        if ($wherein != null && !empty($wherein)) {
            $skillsarray = explode(',', $wherein['skill_id']);

            $query->whereIn('skill_id', $skillsarray);
        }
        $query->where('agents_users_agent_skills.is_deleted', '0');

        return $result = $query->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSearchUsersByAny($limit, $where = null)

    {

        $skillss = new Agentskills;

        $bookmark = new Bookmark;

        $rating = new Rating;

        $loginusser = Auth::user();

        if ($where['searchinputtype'] != '' && $where['searchinputtype'] == 'name') {

            $query = DB::table('agents_users')->select('agents_state.state_name', 'agents_users_details.city_id as city_name', 'agents_users.*', 'agents_users_details.*')

                ->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_users.id')

                ->leftJoin('agents_state', 'agents_state.state_id', '=', 'agents_users_details.state_id');

            //->leftJoin('agents_city', 'agents_city.city_id', '=', 'agents_users_details.city_id');



            // if ($where['agents_users_role_id'] && $where['agents_users_role_id'] != '') {

            //     $query->where(array('agents_users.agents_users_role_id' => $where['agents_users_role_id']));
            // }

            // if ($where['date'] && $where['date'] != '') {

            //     $dd = explode('-', $where['date']);

            //     //$dd1 = $dd[0];

            //     //$dd2 = $dd[1];

            //     $dd1 = date('Y-m-d', strtotime($dd[0]));

            //     $dd2 = date('Y-m-d', strtotime($dd[1]));

            //     $query->where(function ($query1) use ($dd1, $dd2) {

            //         $query1->whereBetween('agents_users.created_at', [$dd1, $dd2]);
            //     });
            // }

            // if ($where['city'] && $where['city'] != '') {

            //     $query->where(function ($q) use ($where) {

            //         $q->where('agents_users_details.city_id', 'LIKE', "%" . $where['city'] . "%");
            //     });
            // }

            // if ($where['state'] && $where['state'] != '') {

            //     $query->where('agents_users_details.state_id', $where['state']);
            // }

            // if ($where['zipcodes'] && $where['zipcodes'] != '') {

            //     $query->where('agents_users_details.zip_code', $where['zipcodes']);
            // }

            // if ($where['pricerange'] && $where['pricerange'] != '') {

            //     $query->where(function ($q) use ($where) {

            //         $q->where('agents_users_details.total_sales', '>=', $where['pricerange'][0]);

            //         $q->where('agents_users_details.total_sales', '<=', $where['pricerange'][1]);
            //     });



            //     //$query->whereBetween('agents_users_details.total_sales1',[$where['pricerange'][0], $where['pricerange'][1]] );

            // }

            // if ($where['address'] && $where['address'] != '') {

            //     $query->where(function ($query1) use ($where) {

            //         $query1->where('agents_users_details.address', 'LIKE', "%" . $where['address'] . "%");

            //         $query1->orWhere('agents_users_details.address2', 'LIKE', "%" . $where['address'] . "%");
            //     });
            // }

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

            $result = $query->get();

            $obj = [];

            if ($count > 0) {

                foreach ($result as $key => $value) {

                    $post_view_count = '';

                    if ($value->skills != null) {

                        $post_view_count = $this->getskillsByAny(array(), array('skill_id' => $value->skills));
                    }
                    if (empty($post_view_count)) {
                        $post_view_count = array();
                    }
                    $value1 = strip_tags($value->description);
                    $value->description = trim(preg_replace('/\s+/', ' ', $value1));

                    $obj[] = (object) array_merge((array) $value, (array) array('skill_data' => $post_view_count));
                }
            }

            $result = $obj;
            foreach ($result as $data) {
                if (!empty($data->photo)) {
                    $photo = $data->photo;
                    $url = url('/assets/img/profile/' . $photo);
                    $data->photo = $url;
                }
            }


            return $result;
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

            $result = $query->get();

            return $result;
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

            $result = $query->get();


            return $result;
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

            $result = $query->get();

            $obj = [];

            foreach ($result as $value) {



                $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => 4, 'bookmark_item_id' => $value->answers_id, 'bookmark_item_parent_id' => $value->question_id, 'sender_id' => $loginusser->id, 'sender_role' => $loginusser->agents_users_role_id));

                $rat = $rating->getRatingSingalByAny(array('rating_type' => 1, 'rating_item_id' => $value->answers_id, 'rating_item_parent_id' => $value->question_id));

                $obj[] = (object) array_merge((array) $value, (array) array('bookmark' => $bok), (array) array('rating' => $rat));
            }

            $result = $obj;


            return $result;
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

            $result = $query->get();

            $obj = [];

            foreach ($result as $value) {



                $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => 4, 'bookmark_item_id' => $value->answers_id, 'bookmark_item_parent_id' => $value->question_id, 'sender_id' => $loginusser->id, 'sender_role' => $loginusser->agents_users_role_id));

                $rat = $rating->getRatingSingalByAny(array('rating_type' => 1, 'rating_item_id' => $value->answers_id, 'rating_item_parent_id' => $value->question_id));

                $obj[] = (object) array_merge((array) $value, (array) array('bookmark' => $bok), (array) array('rating' => $rat));
            }

            $result = $obj;

            return $result;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function agentslist(Request $request)
    {
        Session::put('search_post', $request->all());
        $limit = '100';
        $result = $this->getSearchUsersByAny($limit, $request->all());
        return response()->json(['status' => '100', 'response' => $result]);
    }

    /**
     * Display the specified resource.
     *
     * @param
     * @return array
     */
    public function getBookmarkSingalByAny($where = null)
    {
        $query = DB::table('agents_bookmark')->select('*');
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        $result = $query->first();
        if (empty($result)) {
            return array();
        } else {
            return array($result);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param
     * @return aray
     */

    public function getNotesSingalByAny($where = null)
    {
        $query = DB::table('agents_notes')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        $result = $query->first();
        if (!empty($result)) {
            return array($result);
        } else {
            return array();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $agent_id
     * @return \Illuminate\Http\Response
     */
    public function agentsdetails(Request $request)
    {
        $id = $request->input('agent_id');


        $state = new State;
        if (Auth::user() && Auth::user()->agents_users_role_id != 4) {

            $agents_user_id = Auth::user()->id;

            $agents_users_role_id = Auth::user()->agents_users_role_id;
            if (empty($id)) {
                return redirect()->back();
            }
            $view = array();

            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $user = new User;
            $view['agents'] = $user->getuserdetailsByAny(array('agents_users.id' => $id));

            $view['state']  = $state->getStateByAny(array('state_id' => $view['agents']->state_id, 'is_deleted' => '0'), 'first');

            $post = new Post;
            if ($request->input('post_id')) {

                $view['post'] = $post->getpostmultipalByAny(array('post_id' => $request->input('post_id'), 'agents_user_id' => $view['user']->id, 'agents_users_role_id' => $view['user']->agents_users_role_id));


                if (empty($view['post'])) {
                    return response()->json(['status' => '101', 'response' => 'no posts']);
                }
            } else {

                $view['post'] = $post->getpostmultipalByAny(array('agents_user_id' => $view['user']->id, 'agents_users_role_id' => $view['user']->agents_users_role_id));
            }


            $notes = $this->getnotesSingalByAny(array('sender_id' => $agents_user_id, 'sender_role' => $agents_users_role_id, 'receiver_id' => $id, 'receiver_role' => '4', 'notes_type' => '5', 'notes_item_id' => $agents_user_id, 'notes_item_parent_id' => $request->input('post_id')));

            $view['notes'] = $notes;
            $Bookmark = new Bookmark;
            $bookmark = $this->getBookmarkSingalByAny(array('sender_id' => $agents_user_id, 'sender_role' => $agents_users_role_id, 'bookmark_type' => '2', 'bookmark_item_id' => $id, 'bookmark_item_parent_id' => $request->input('post_id')));

            $view['bookmark'] = $bookmark;


            $view['agents']->description = strip_tags($view['agents']->description);

            /* Certifications */
            $where['is_deleted'] = '0';
            $wherein['certifications_id'] = $view['agents']->certifications;
            $certifications = $userdetails->getCertificationsByAny($where, $wherein);
            $view['agents']->certifications = $certifications;

            /* specialization */


            /* franchise */
            $where1['franchise_id'] = $view['agents']->franchise;
            $where1['is_deleted'] = '0';
            $view['agents']->franchise = $userdetails->getFranchiseByAny($where1);


            if (!is_null($view['agents']->education)) {
                $view['agents']->education = strip_tags($view['agents']->education);
                $view['agents']->education = json_decode($view['agents']->education);
            } else {
                $view['agents']->education = array();
            }


            if (!is_null($view['agents']->employment)) {
                $view['agents']->employment = json_decode($view['agents']->employment);
            } else {
                $view['agents']->employment = array();
            }

            /* real_estate_education*/
            if (!is_null($view['agents']->real_estate_education)) {
                $view['agents']->real_estate_education = json_decode($view['agents']->real_estate_education);
                foreach ($view['agents']->real_estate_education as $data) {
                    $data->description = strip_tags($data->description);
                }
            } else {
                $view['agents']->real_estate_education = array();
            }

            $files = array();
            $files['post_id'] = $request->input('post_id');
            $files['sender_id'] =  $agents_user_id;
            $files['sender_role'] = $agents_users_role_id;
            $files['receiver_id'] = $id;


            $file = app('App\Http\Controllers\Api\SharedController')->getSharedUploadAndFiles($files);

            $proposal = app('App\Http\Controllers\Api\SharedController')->getSharedProposals($files);


            // $questions= app('App\Http\Controllers\Api\SharedController')->getSharedQuestionAndAnswer($files);

            // $view['questions']=$questions;

            $view['files'] = $file;

            $view['proposal'] = $proposal;

            // print_r($proposal); exit;
            /*industry_experience*/
            if (!is_null($view['agents']->industry_experience)) {
                $view['agents']->industry_experience = json_decode($view['agents']->industry_experience);
            } else {
                $view['agents']->industry_experience = array();
            }

            /*language_proficiency*/
            if (!is_null($view['agents']->language_proficiency)) {
                $view['agents']->language_proficiency = json_decode($view['agents']->language_proficiency);
            } else {
                $view['agents']->language_proficiency = array();
            }

            $view['agents']->additional_details = strip_tags($view['agents']->additional_details);
            if (!is_null($view['agents']->sales_history)) {
                $view['agents']->sales_history = json_decode($view['agents']->sales_history);
            } else {
                $view['agents']->sales_history = array();
            }
            if (!empty($view['agents']->photo)) {
                $view['agents']->photo = $url = url('/assets/img/profile/' . $view['agents']->photo);
            }
            $result[] = $view;
            return response()->json(['status' => '100', 'response' => $result]);
        } else {

            return response()->json(['status' => '101', 'response' => 'unauthorized']);
        }
    }

    // API to get the list of pending invoices for Agents
    public function getPendingInvoices(Request $request)
    {
        $agent_id = $request->input('agent_id');

        # load purchased packages
        $invoice_list = DB::table('agents_selldetails')
            ->where(['agent_id' => $agent_id, 'deleted' => 0, 'status' => 1, 'payment_status' => 0])
            ->get();

        return response()->json(['status' => '200', 'response' => $invoice_list]);
    }

    /* API to get the closing date */
    public function addClosingDate(Request $request)
    {
        $rules = array(
            'closing_date'    => 'required',
        );

        $validator = Validator::make(array(
            'closing_date' => $request->input('closing_date'),
        ), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $post = Post::find($request->input('post_id'));
            $post->closing_date = $request->input('closing_date');
            $post->updated_at    = Carbon::now()->toDateTimeString();
            $postObj = new Post;
            $postDetails = $postObj->getAppliedPostsBySelectedAgent($request->input('agent_id'));
            //echo $postDetails;exit;
            if ($postDetails == '' || $postDetails <= 5) {
                $post->agent_payment = 'completed';
                /* Save Payment Data */
                $transactionId = strtotime(date("d-m-y h:i:s")) . $request->input('post_id') . Auth::user()->id . rand(00000, 99999);
                $paymentDetails = array(
                    'amount' => 0.00,
                    'discount' => 0.00,
                    'taxes' => 0.00,
                    'payment' => 'Stripe',
                    'post_id' => $request->input('post_id'),
                    'user_id' => Auth::user()->id,
                    'transaction_id' => $transactionId,
                    'stripe_order_no' => '',
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s")
                );
                DB::table('agents_payment')->insert($paymentDetails);
                /* Save Payment Data */
            }
            if ($post->save()) {
                return response()->json(["statys" => 2, "msg" => "Closing date added successfully."]);
            } else {
                return response()->json(["statys" => 1, "msg" => array('error' => 'Please try again in a few minutes.')]);
            }
        }
    }
}
