<?php

namespace App\Http\Controllers\Administrator;

use App\Events\eventTrigger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionAnswers;
use App\Models\Shared;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\Notification;
use Carbon\Carbon;

class SharedController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //echo '<pre>'; print_r($_POST); exit;
        $update = $notifiy = array();
        $update['shared_type']                               =   $request->input('shared_type');
        $update['shared_item_id']                            =   $request->input('shared_item_id');
        $update['shared_item_type']                          =   $request->input('shared_item_type');
        $update['shared_item_type_id']                       =   $request->input('shared_item_type_id');
        $notifiy['sender_id'] = $update['sender_id']         =   $request->input('sender_id');
        $notifiy['sender_role'] = $update['sender_role']     =   $request->input('sender_role');
        $notifiy['receiver_id'] = $update['receiver_id']     =   $request->input('receiver_id');
        $notifiy['receiver_role'] = $update['receiver_role'] =   $request->input('receiver_role');

        $Shared = new Shared();
        $acheck = $Shared->getsinglerowByAny($update);
        if (!empty($acheck)) {
            $sharedupdate                       =  Shared::find($acheck->shared_id);
            $sharedupdate->shared_type          =  $request->input('shared_type');
            $sharedupdate->shared_item_id       =  $request->input('shared_item_id');
            $sharedupdate->shared_item_type     =  $request->input('shared_item_type');
            $sharedupdate->shared_item_type_id  =  $request->input('shared_item_type_id');
            $sharedupdate->sender_id            =  $request->input('sender_id');
            $sharedupdate->sender_role          =  $request->input('sender_role');
            $sharedupdate->receiver_id          =  $request->input('receiver_id');
            $sharedupdate->receiver_role        =  $request->input('receiver_role');
            $sharedupdate->updated_at           =  Carbon::now()->toDateTimeString();
            $sharedupdate->save();
            $result                             =   $sharedupdate->shared_id;
        } else {
            $Shared->shared_type            =   $request->input('shared_type');
            $Shared->shared_item_id         =   $request->input('shared_item_id');
            $Shared->shared_item_type       =   $request->input('shared_item_type');
            $Shared->shared_item_type_id    =   $request->input('shared_item_type_id');
            $Shared->sender_id              =   $request->input('sender_id');
            $Shared->sender_role            =   $request->input('sender_role');
            $Shared->receiver_id            =   $request->input('receiver_id');
            $Shared->receiver_role          =   $request->input('receiver_role');
            $Shared->updated_at             =   Carbon::now()->toDateTimeString();
            $Shared->save();
            $result                         =   $Shared->shared_id;
        }
        if ($result) {
            $notifiy['notification_type']            = $request->input('notification_type');
            $notifiy['notification_message']         = $request->input('notification_message');
            $notifiy['notification_item_id']         = $result;
            $notifiy['notification_child_item_id']   = $request->input('shared_item_id');
            $notifiy['updated_at']                   =  Carbon::now()->toDateTimeString();

            $noti = new Notification;
            $noti->inserupdate($notifiy);
            event(new eventTrigger(array($request->all(), $result, 'NewNotification')));
            return response()->json(['data' => $result]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSharedQuestionAndAnswer(Request $request)
    {
        $answers = array();
        $bookmarkdata = array();
        $question = new QuestionAnswers;
        $shared = new Shared;
        $bookmark = new Bookmark;
        $rating = new Rating;
        $ratingdata = array();
        $were = array(
            'agents_shared.shared_type' => $request->input('shared_type'),
            'agents_shared.shared_item_type' => $request->input('shared_item_type'),
            'agents_shared.shared_item_type_id' => $request->input('shared_item_type_id'),
            'agents_question.question_type' => $request->input('question_type'),
            'agents_question.is_deleted' => '0'
        );
        $were['agents_shared.sender_id'] = $request->input('sender_id');
        $were['agents_shared.sender_role'] = $request->input('sender_role');
        $were['agents_shared.receiver_id'] = $request->input('receiver_id');
        $were['agents_shared.receiver_role'] = $request->input('receiver_role');

        $result = $shared->getsharedquestionandanswer($were);
        if (!empty($result)) {
            foreach ($result as $value) {

                $ratingdata[$value->question_id] = '';
                $ans = $question->getAnswersByAny(
                    array(
                        'is_deleted' => '0',
                        //'status' => '1',
                        'question_id' => $value->question_id,
                        'from_id' => $request->input('receiver_id'),
                        'from_role' => $request->input('receiver_role')
                    )
                );

                //$notification_time = Notification::where('notification_child_item_id', $ans->answers);
                if (empty($ans)) {
                    $answers[$value->question_id] = '';
                } else {
                    $answers[$value->question_id] = $ans->answers;


                    if ($request->input('rating') && !empty($request->input('rating'))) {
                        $rat = $rating->getRatingSingalByAny(array('rating_type' => 1, 'rating_item_id' => $ans->answers_id, 'rating_item_parent_id' => $value->question_id, 'sender_id' => $request->input('sender_id'), 'sender_role' => $request->input('sender_role'), 'receiver_id' => $request->input('receiver_id'), 'receiver_role' => $request->input('receiver_role')));
                        if (!empty($rat)) {
                            $ratingdata[$value->question_id] = $rat;
                        }
                    }
                }
                if ($request->input('bookmark_type') && !empty($request->input('bookmark_type'))) {

                    $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => $request->input('bookmark_type'), 'bookmark_item_id' => $value->question_id, 'bookmark_item_parent_id' => $request->input('shared_item_type_id'), 'sender_id' => $request->input('receiver_id'), 'sender_role' => $request->input('receiver_role'), 'receiver_id' => $request->input('sender_id'), 'receiver_role' => $request->input('sender_role')));
                    if (empty($bok)) {
                        $bookmarkdata[$value->question_id] = '';
                    } else {
                        $bookmarkdata[$value->question_id] = $bok;
                    }
                }
            }
        }

        return response()->json(array($result, $answers, $bookmarkdata, $ratingdata));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSharedUploadAndFiles(Request $request)
    {
        $shared = new Shared;
        $aa = array();
        $aa['shared_type']          = $request->input('shared_type');
        $aa['shared_item_type']     = $request->input('shared_item_type');
        $aa['shared_item_type_id']  = $request->input('shared_item_type_id');
        $aa['sender_id']            = $request->input('sender_id');
        $aa['sender_role']          = $request->input('sender_role');
        $aa['receiver_id']          = $request->input('receiver_id');
        $aa['receiver_role']        = $request->input('receiver_role');
        $ss = $shared->getshareduploadfiles($aa);
        return response()->json($ss);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSharedProposals(Request $request)
    {
        $bookmark = new Bookmark;
        $bookmarkdata = array();
        $shared = new Shared;
        $aa['shared_type']          = $request->input('shared_type');
        $aa['shared_item_type']     = $request->input('shared_item_type');
        $aa['shared_item_type_id']  = $request->input('shared_item_type_id');
        $aa['sender_id']            = $request->input('sender_id');
        $aa['sender_role']          = $request->input('sender_role');
        $aa['receiver_id']          = $request->input('receiver_id');
        $aa['receiver_role']        = $request->input('receiver_role');
        $result = $shared->getsharedProposals($aa);

        if (!empty($result) && @$request->input('bookmark_type') && @$request->input('bookmark_type') != null) {
            foreach ($result as $value) {

                $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => $request->input('bookmark_type'), 'bookmark_item_id' => $value->proposals_id, 'bookmark_item_parent_id' => $request->input('shared_item_type_id'), 'sender_id' => $request->input('receiver_id'), 'sender_role' => $request->input('receiver_role'), 'receiver_id' => $request->input('sender_id'), 'receiver_role' => $request->input('sender_role')));
                if (empty($bok)) {
                    $bookmarkdata[$value->proposals_id] = '';
                } else {
                    $bookmarkdata[$value->proposals_id] = $bok;
                }
            }
            return response()->json(array($result, $bookmarkdata));
        }
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetSharedPropsalUsersAndConnectedUers(Request $request, $proposal_id, $userid, $user_role)
    {
        $shared = new Shared;
        $ss = $shared->GetSharedPropsalUsersAndConnectedUers($proposal_id, $userid, $user_role, $request->all());
        return response()->json($ss);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function GetSharedDocumentUsersAndConnectedUers(Request $request, $docs_id, $userid, $user_role)
    {
        $shared = new Shared;
        $ss = $shared->GetSharedDocumentUsersAndConnectedUers($docs_id, $userid, $user_role, $request->all());
        return response()->json($ss);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetSharedQuestionUsersAndConnectedUers(Request $request, $question_id, $share_user_type, $userid, $user_role)
    {
        $shared = new Shared;
        $ss = $shared->GetSharedQuestionUsersAndConnectedUers($question_id, $share_user_type, $userid, $user_role, $request->all());
        return response()->json($ss);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $result = DB::table('agents_shared')->where('shared_id', $request->input('shared_id'))->delete();
        DB::table('agents_notification')->where(array('notification_item_id' => $request->input('shared_id'), 'notification_child_item_id' => $request->input('id')))->delete();
        return response()->json($result);
    }
}
