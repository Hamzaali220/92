<?php

namespace App\Http\Controllers\Api;
use App\Events\eventTrigger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\QuestionAnswers;
use App\Models\Survey;
use App\Models\Shared;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\Notification;
use App\Models\Importance;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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
        $update = $notifiy = array();
        if($request->input('qtype') == 'asked'){
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
        if(!empty($acheck)){
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
        }else{
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
        if($result){
            $notifiy['notification_type']            = $request->input('notification_type');
            $notifiy['notification_message']         = $request->input('notification_message');
            $notifiy['notification_item_id']         = $result;
            $notifiy['notification_child_item_id']   = $request->input('shared_item_id');
            $notifiy['updated_at']                   =  Carbon::now()->toDateTimeString();

            $noti = new Notification;
            $noti->inserupdate($notifiy);
            event( new eventTrigger( array( $request->all(), $result , 'NewNotification' ) ) );

            return response()->json(['status'=>'100','message'=>'Question asked.']);
        }
        }else if($request->input('qtype') == 'unasked'){
           $result = DB::table('agents_shared')->where('shared_id', $request->input('shared_id'))->delete();
        DB::table('agents_notification')->where(array('notification_item_id' => $request->input('shared_id'), 'notification_child_item_id' => $request->input('id')))->delete();
          return response()->json(['status'=>'100','message'=>'Question removed.']);
        }else{
          return response()->json(['status'=>'101','message'=>'Type parameter is missing.']);
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


    $post_id= $request->input['post_id'];
    $reciever_id = $request->input['reciever_id'];
    $sender_id = $request->input['agents_user_id'];
    $sender_role  = $request->input['sender_role'];

        $answers = array();
        $bookmarkdata = array();
        $question = new QuestionAnswers;
        $shared = new Shared;
        $bookmark = new Bookmark;
        $rating = new Rating;
        $ratingdata = array();
        $were = array(  'agents_shared.shared_type' => 1,
                        'agents_shared.shared_item_type' => 1,
                        'agents_shared.shared_item_type_id' => $post_id,
                        'agents_question.question_type' =>3 ,
                        'agents_question.is_deleted' => '0'
                );
        $were['agents_shared.sender_id'] = $sender_id ;
        $were['agents_shared.sender_role'] = 4;
        $were['agents_shared.receiver_id'] =  $reciever_id ;
        $were['agents_shared.receiver_role'] = $sender_role;

        $result = $shared->getsharedquestionandanswer($were);
        if(!empty($result)){
            foreach ($result as $value) {
                $ratingdata[$value->question_id] = '';
                    $ans = $question->getAnswersByAny(
                        array('is_deleted' => '0',
                        'question_id' => $value->question_id,
                        'from_id' =>$reciever_id,
                        'from_role' => $sender_role));
                if(empty($ans)){
                    $answers[$value->question_id] = '';
                }else{
                    $answers[$value->question_id] = $ans->answers;
                    if($request->input('rating') && !empty($request->input('rating'))){
                        $rat = $rating->getRatingSingalByAny(
                            array('rating_type' => 1,
                            'rating_item_id' => $ans->answers_id,
                            'rating_item_parent_id' => $value->question_id,
                            'sender_id' => $sender_id,
                            'sender_role' => 4,'receiver_id' => $reciever_id,
                            'receiver_role' =>4 ));
                        if(!empty($rat)){
                            $ratingdata[$value->question_id] = $rat;
                        }
                    }

                }
               if($request->input('bookmark_type') && !empty($request->input('bookmark_type'))){

                        $bok = $bookmark->getBookmarkSingalByAny(
                            array('bookmark_type' => $request->input('bookmark_type'),
                            'bookmark_item_id' => $value->question_id,
                            'bookmark_item_parent_id' => $post_id,
                            'sender_id' =>  $sender_id,
                            'sender_role' =>$sender_role,
                            'receiver_id' =>$reciever_id,
                            'receiver_role' => 4 ));
                    if(empty($bok)){
                        $bookmarkdata[$value->question_id] = '';
                    }else{
                        $bookmarkdata[$value->question_id] = $bok;
                    }
                }
            }
        }
        return $result;
       // return response()->json(array($result,$answers,$bookmarkdata,$ratingdata));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSharedUploadAndFiles($files)
    {
        $shared = new Shared;
        $aa = array();
        $aa['shared_type']          = 2;
        $aa['shared_item_type']     = 1;
        $aa['shared_item_type_id']  = $files['post_id'];
        $aa['sender_id']            = $files['receiver_id'];
        $aa['sender_role']          = 4;
        $aa['receiver_id']          = $files['sender_id'];
        $aa['receiver_role']        = $files['sender_role'];
        $ss = $shared->getshareduploadfiles($aa);

        return $ss;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
       public function getSharedProposals($proposal)
    {   //print_r($proposal); exit;
        $bookmark = new Bookmark;
        $bookmarkdata = array();
        $shared = new Shared;

        $aa['shared_type']          = '3';
        $aa['shared_item_type']     = '1';
        $aa['shared_item_type_id']  = $proposal['post_id'];
        $aa['sender_id']            =  $proposal['receiver_id'];
        $aa['sender_role']          =  '4';
        $aa['receiver_id']          =  $proposal['sender_id'] ;
        $aa['receiver_role']        =   $proposal['sender_role'];
        $result = $shared->getsharedProposals($aa);

        if(!empty($result) ){
            foreach ($result as $value) {

                $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => '5','bookmark_item_id' => $value->proposals_id,'bookmark_item_parent_id' =>$proposal['post_id'],'sender_id' =>  $proposal['sender_id'],'sender_role' =>$proposal['sender_role'],'receiver_id' => $proposal['receiver_id'],'receiver_role' => '4' ));
                if(empty($bok)){
                    $bookmarkdata[$value->proposals_id] = '';
                }else{
                    $bookmarkdata[$value->proposals_id] = $bok;
                }
            }
            $bookmarkdata ['result'] = $result ;

            return  $bookmarkdata ;
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
    public function GetSharedPropsalUsersAndConnectedUers(Request $request,$proposal_id,$userid,$user_role)
    {
        $shared = new Shared;
        $ss = $shared->GetSharedPropsalUsersAndConnectedUers($proposal_id,$userid,$user_role,$request->all());
        return response()->json($ss);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetSharedDocumentUsersAndConnectedUers(Request $request,$docs_id,$userid,$user_role)
    {
        $shared = new Shared;
        $ss = $shared->GetSharedDocumentUsersAndConnectedUers($docs_id,$userid,$user_role,$request->all());
        return response()->json($ss);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetSharedQuestionUsersAndConnectedUers(Request $request,$question_id,$share_user_type,$userid,$user_role)
    {
        $shared = new Shared;
        $ss = $shared->GetSharedQuestionUsersAndConnectedUers($question_id,$share_user_type,$userid,$user_role,$request->all());
        return response()->json($ss);
    }
}
