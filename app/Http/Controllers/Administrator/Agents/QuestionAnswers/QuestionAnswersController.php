<?php

namespace App\Http\Controllers\Administrator\Agents\QuestionAnswers;

use App\Events\eventTrigger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionAnswers;
use App\Models\Survey;
use App\Models\Shared;
use App\Models\Notification;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\Importance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QuestionAnswersController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create(Request $request)

    {

        // $where = $update = array();

        $rules = array(

            'question'              => 'required',

            'question_type'              => 'required',

        );

        $messages = array(
            'question.required' => 'The Question Field is Required'
        );

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) :

            return response()->json(['error' => $validator->errors()]);

        endif;


        $QuestionAnswers = new QuestionAnswers;

        $QuestionAnswers->question = $request->input('question');

        $QuestionAnswers->question_type =  $request->input('question_type');

        $QuestionAnswers->add_by =  $request->input('add_by');

        $QuestionAnswers->add_by_role =  $request->input('add_by_role');

        if ($request->input('survey')) {

            $QuestionAnswers->survey =  $request->input('survey');
        } else {

            $QuestionAnswers->survey =  '0';
        }

        if ($request->input('importance1')) {

            $QuestionAnswers->importance =  $request->input('importance1');
        } else {

            $QuestionAnswers->importance =  '0';
        }

        $QuestionAnswers->save();

        $qid = $QuestionAnswers;

        if ($request->input('survey') == 1) {

            $client = new Survey();

            $client->question_id = $qid->question_id;

            $client->agents_user_id = $request->input('add_by');

            $client->agents_users_role_id = $request->input('add_by_role');

            $client->save();
        }

        if ($request->input('importance1') == 1) {

            $client = new Importance();

            $client->importance_item_id = $qid->question_id;

            $client->importance_type = '1';

            $client->agents_user_id = $request->input('add_by');

            $client->agents_users_role_id = $request->input('add_by_role');

            $client->save();
        }

        return response()->json(["status" => "100", "msg" => "Survey Question has been added", 'data' => $qid]);
    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */


    public function questiontoanswer(Request $request)
    {
        $user   = Auth::user();
        $where = $update = array();
        $rules = array(
            'answers'              => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) :
            return response()->json(['error' => $validator->errors()]);
        endif;

        $update['answers'] =  $request->input('answers');
        if (!empty($request->input('post_id'))) {
            $update['post_id'] =  $request->input('post_id');
        }
        $update['question_id'] =  $request->input('question_id');
        $update['from_id'] =  $request->input('from_id');
        $update['from_role'] =  $request->input('from_role');
        $QuestionAnswers = new QuestionAnswers;
        $alrdans = $QuestionAnswers->getAnswersByAny(array('is_deleted' => '0', 'question_id' => $update['question_id'], 'from_id' =>  $update['from_id'], 'from_role' => $update['from_role']));
        if (!empty($alrdans)) {
            $update['updated_at'] = Carbon::now()->toDateTimeString();
            $resutl = $QuestionAnswers->inserupdateAnswers($update, array('answers_id' => $alrdans->answers_id));
        } else {
            $update['created_at'] = Carbon::now()->toDateTimeString();
            $resutl = $QuestionAnswers->inserupdateAnswers($update);
        }
        $noti = new Notification;
        $noti->sender_id                   = $user->id;
        $noti->sender_role                 = $user->agents_users_role_id;
        $noti->receiver_id                 = $request->input('receiver_id');
        $noti->receiver_role               = $request->input('receiver_role');
        $noti->notification_type           = 10;
        $noti->notification_item_id        = $resutl;
        $noti->notification_child_item_id  = $update['question_id'];
        $noti->status                      = 1;
        $noti->notification_message        = $request->input('notification_message');
        $noti->updated_at                  = Carbon::now()->toDateTimeString();
        $noti->save();
        // $noti->inserupdate($notifiy);
        event(new eventTrigger(array($request->all(), $resutl, 'NewNotification')));
        return response()->json(["msg" => "This question answers successfully send."]);
    }


    public function allsubmitquestiontoanswer(Request $request)
    {

        $QuestionAnswers = new QuestionAnswers;
        $noti = new Notification;
        $user   = Auth::user();
        $where = $update = array();

        if (!empty($request->input('post_id'))) {
            $update['post_id'] =  $request->input('post_id');
        }
        $update['from_id'] =  $request->input('from_id');
        $update['from_role'] =  $request->input('from_role');

        foreach ($request->input('question_id') as $key => $value) {
            $question_id = $value;
            $answers = $request->input('question_default')[$value];

            if (!empty($answers)) {
                $update['question_id'] =  $question_id;
                $update['answers'] =  $answers;
                $alrdans = $QuestionAnswers->getAnswersByAny(array('is_deleted' => '0', 'question_id' => $question_id, 'from_id' =>  $update['from_id'], 'from_role' => $update['from_role']));
                if (!empty($alrdans)) {

                    $update['updated_at'] = Carbon::now()->toDateTimeString();

                    $resutl = $QuestionAnswers->inserupdateAnswersall($update, array('answers_id' => $alrdans->answers_id));

                    if ($resutl != 'noupdate') {

                        $noti->sender_id                   = $user->id;
                        $noti->sender_role                 = $user->agents_users_role_id;
                        $noti->receiver_id                 = $request->input('receiver_id');
                        $noti->receiver_role               = $request->input('receiver_role');
                        $noti->notification_type           = 10;
                        $noti->notification_item_id        = $resutl;
                        $noti->notification_child_item_id  = $update['question_id'];
                        $noti->status                      = 1;
                        $noti->notification_message        = $request->input('notification_message');
                        $noti->updated_at                  = Carbon::now()->toDateTimeString();
                        $noti->save();
                    }
                } else {
                    $update['created_at'] = Carbon::now()->toDateTimeString();
                    $resutl = $QuestionAnswers->inserupdateAnswersall($update);
                    $noti->sender_id                   = $user->id;
                    $noti->sender_role                 = $user->agents_users_role_id;
                    $noti->receiver_id                 = $request->input('receiver_id');
                    $noti->receiver_role               = $request->input('receiver_role');
                    $noti->notification_type           = 10;
                    $noti->notification_item_id        = $resutl;
                    $noti->notification_child_item_id  = $update['question_id'];
                    $noti->status                      = 1;
                    $noti->notification_message        = $request->input('notification_message');
                    $noti->updated_at                  = Carbon::now()->toDateTimeString();
                    $noti->save();
                }
            }
        }
        event(new eventTrigger(array($request->all(), $resutl, 'NewNotification')));
        return response()->json(["msg" => "This question answers successfully send."]);
    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show(Request $request)

    {

        $answers = array();

        $question = new QuestionAnswers;

        $result = $question->getQuestionByAny(array('is_deleted' => '0', 'status' => '1', 'add_by' => @$request->input('add_by'), 'add_by_role' => $request->input('add_by_role'), 'question_type' => $request->input('question_type')));

        foreach ($result as $value) {

            $ans = $question->getAnswersByAny(array('is_deleted' => '0', 'question_id' => $value->question_id, 'from_id' => $request->input('from_id'), 'from_role' => $request->input('from_role')));

            if (empty($ans)) {

                $answers[$value->question_id] = '';
            } else {

                $answers[$value->question_id] = $ans->answers;
            }
        }
        //echo '<pre>'; print_r($answers); echo '</pre>';exit;
        return response()->json(array($result, $answers));
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function getonlyusersquestion(Request $request)

    {

        $question   = new QuestionAnswers;

        $bookmark = new Bookmark;

        $bookmarkdata = array();

        $rating = new Rating;

        $ratingdata = array();

        $where = $answers = $share = array();
        //echo '<pre>'; print_r($_POST); echo '</pre>';exit;
        if ($request->input('add_by')) {

            $where['add_by'] = $request->input('add_by');
        }

        if ($request->input('add_by_role')) {

            $where['add_by_role'] = $request->input('add_by_role');
        }

        if ($request->input('question_type')) {

            $where['question_type'] = $request->input('question_type');
        }

        if ($request->input('importance')) {

            $where['importance'] = $request->input('importance');
        }

        if ($request->input('survey')) {

            $where['survey'] = $request->input('survey');
        }

        $where['is_deleted'] = '0';
        //$where['status'] = '1';

        $result     = $question->getQuestionByAny($where);
        //echo '<pre>'; print_r($where);  print_r($result); die;
        if ($request->input('share') && $request->input('share') == 'ask_question') {



            $shared = new Shared;

            foreach ($result as $value) {



                $aa = array(
                    'shared_type' => 1,

                    'shared_item_id' => $value->question_id,

                    'shared_item_type' => $request->input('shared_item_type'),

                    'shared_item_type_id' => $request->input('post_id'),

                );



                $aa['sender_id'] = $request->input('add_by');

                $aa['sender_role'] = $request->input('add_by_role');

                $aa['receiver_id'] = $request->input('receiver_id');

                $aa['receiver_role'] = $request->input('question_type');

                /*shared question get*/

                $ss = $shared->getsinglerowByAny($aa);

                if (empty($ss)) {

                    $share[$value->question_id] = '';
                } else {

                    $share[$value->question_id] = $ss->shared_id;
                }



                /*shared question answer dediya vo question get*/

                $ans = $question->getAnswersByAny(array('post_id' => $request->input('post_id'), 'is_deleted' => '0', 'question_id' => $value->question_id, 'from_id' => $request->input('receiver_id'), 'from_role' => $request->input('question_type')));

                if (empty($ans)) {

                    $answers[$value->question_id] = '';
                } else {

                    $answers[$value->question_id] = $ans;

                    if ($request->input('bookmark') && !empty($request->input('bookmark'))) {



                        $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => 4, 'bookmark_item_id' => $ans->answers_id, 'bookmark_item_parent_id' => $ans->question_id, 'sender_id' => $request->input('add_by'), 'sender_role' => $request->input('add_by_role'), 'receiver_id' => $request->input('receiver_id'), 'receiver_role' => $request->input('question_type')));

                        if (empty($bok)) {

                            $bookmarkdata[$ans->answers_id] = '';
                        } else {

                            $bookmarkdata[$ans->answers_id] = $bok;
                        }
                    }

                    if ($request->input('rating') && !empty($request->input('rating'))) {



                        $rat = $rating->getRatingSingalByAny(array('rating_type' => 1, 'rating_item_id' => $ans->answers_id, 'rating_item_parent_id' => $ans->question_id, 'sender_id' => $request->input('add_by'), 'sender_role' => $request->input('add_by_role'), 'receiver_id' => $request->input('receiver_id'), 'receiver_role' => $request->input('question_type')));

                        if (empty($rat)) {

                            $ratingdata[$ans->answers_id] = '';
                        } else {

                            $ratingdata[$ans->answers_id] = $rat;
                        }
                    }
                }
            }

            return response()->json(array($result, $share, $answers, $bookmarkdata, $ratingdata));
        }

        return response()->json($result);
    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request)

    {

        $where = $update = array();

        $rules = array(

            'question'              => 'required',

        );

        $messages = array(
            'question.required' => 'The Question Field is Required'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) :

            return response()->json(['error' => $validator->errors()]);

        endif;



        $update['question'] =  $request->input('question');

        $update['add_by'] =  $request->input('add_by');

        $update['add_by_role'] =  $request->input('add_by_role');

        // if(!empty($request->input('post_id'))){

        //      $update['post_id'] =  $request->input('post_id');

        // }

        $update['updated_at'] = Carbon::now()->toDateTimeString();

        $QuestionAnswers = new QuestionAnswers;

        $QuestionAnswers->inserupdate($update, array('question_id' => $request->input('question_id')));

        return response()->json(["msg" => "Question has been updated successfully."]);
    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }
}
