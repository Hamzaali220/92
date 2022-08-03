<?php

namespace App\Http\Controllers\Administrator;

use App\Events\eventTrigger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Shared;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Rating;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class RatingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $update = $notifiy = array();
        $update['rating_type']                               =   $request->input('rating_type');
        $update['rating_item_id']                            =   $request->input('rating_item_id');
        $update['rating_item_parent_id']                     =   $request->input('rating_item_parent_id');
        $notifiy['sender_id'] = $update['sender_id']         =   $request->input('sender_id');
        $notifiy['sender_role'] = $update['sender_role']     =   $request->input('sender_role');
        $notifiy['receiver_id'] = $update['receiver_id']     =   $request->input('receiver_id');
        $notifiy['receiver_role'] = $update['receiver_role'] =   $request->input('receiver_role');

        $Rating = new Rating();
        $acheck = $Rating->getRatingSingalByAny($update);
        if (!empty($acheck)) {
            $bookbarkupdate                         =  Rating::find($acheck->rating_id);
            $bookbarkupdate->rating_type            =  $request->input('rating_type');
            $bookbarkupdate->rating                 =  $request->input('rating');
            $bookbarkupdate->rating_item_id         =  $request->input('rating_item_id');
            $bookbarkupdate->rating_item_parent_id  =  $request->input('rating_item_parent_id');
            $bookbarkupdate->sender_id              =  $request->input('sender_id');
            $bookbarkupdate->sender_role            =  $request->input('sender_role');
            $bookbarkupdate->receiver_id            =  $request->input('receiver_id');
            $bookbarkupdate->receiver_role          =  $request->input('receiver_role');
            $bookbarkupdate->updated_at             =  Carbon::now()->toDateTimeString();
            $bookbarkupdate->save();
            $result                                 =   $bookbarkupdate;
        } else {
            $Rating->rating_type                    =   $request->input('rating_type');
            $Rating->rating                         =   $request->input('rating');
            $Rating->rating_item_id                 =   $request->input('rating_item_id');
            $Rating->rating_item_parent_id          =   $request->input('rating_item_parent_id');
            $Rating->sender_id                      =   $request->input('sender_id');
            $Rating->sender_role                    =   $request->input('sender_role');
            $Rating->receiver_id                    =   $request->input('receiver_id');
            $Rating->receiver_role                  =   $request->input('receiver_role');
            $Rating->updated_at                     =   Carbon::now()->toDateTimeString();
            $Rating->save();
            $result                                 =   $Rating;
        }
        if ($result) {

            $notifiy['notification_type']            = $request->input('notification_type');
            $notifiy['notification_message']         = $request->input('notification_message');
            $notifiy['notification_item_id']         = $result->rating_id;
            $notifiy['notification_child_item_id']   = $request->input('rating_item_id');
            $notifiy['notification_post_id']         = $request->input('post_id');
            $notifiy['updated_at']                   =  Carbon::now()->toDateTimeString();

            $noti = new Notification;
            $noti->inserupdate($notifiy);
            event(new eventTrigger(array($request->all(), $result, 'NewNotification')));
        }
        return response()->json(['data' => $result]);
    }
    /* For review send */
    public function reviewsend(Request $request)
    {
        $userdata = new User;
        $postdata = Post::find($request->input('post_id'));
        $noti = new Notification;
        $rules = array(
            'rating'           => 'required',
            'review'           => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) :
            return response()->json(['error' => $validator->errors()]);
        endif;

        $update = array();
        $notifiy = array();
        $update['rating_type']           =   $request->input('rating_type');
        $update['rating_item_id']        =   $request->input('rating_item_id');
        $update['rating_item_parent_id'] =   $request->input('rating_item_parent_id');
        $update['sender_id']             =   $request->input('sender_id');
        $update['sender_role']           =   $request->input('sender_role');
        $update['receiver_id']           =   $request->input('receiver_id');
        $update['receiver_role']         =   $request->input('receiver_role');

        $Rating = new Rating();
        $acheck = $Rating->getRatingSingalByAny($update);
        if (!empty($acheck)) {

            $bookbarkupdate                         =  Rating::find($acheck->rating_id);
            $bookbarkupdate->rating_type            =  $request->input('rating_type');
            $bookbarkupdate->rating                 =  $request->input('rating');
            $bookbarkupdate->review                 =  $request->input('review');
            $bookbarkupdate->rating_item_id         =  $request->input('rating_item_id');
            $bookbarkupdate->rating_item_parent_id  =  $request->input('rating_item_parent_id');
            $bookbarkupdate->sender_id              =  $request->input('sender_id');
            $bookbarkupdate->sender_role            =  $request->input('sender_role');
            $bookbarkupdate->receiver_id            =  $request->input('receiver_id');
            $bookbarkupdate->receiver_role          =  $request->input('receiver_role');
            $bookbarkupdate->updated_at             =  Carbon::now()->toDateTimeString();
            $bookbarkupdate->save();
            $result                                 =   $bookbarkupdate;
        } else {
            $Rating->rating_type                    =   $request->input('rating_type');
            $Rating->rating                         =   $request->input('rating');
            $Rating->review                         =   $request->input('review');
            $Rating->rating_item_id                 =   $request->input('rating_item_id');
            $Rating->rating_item_parent_id          =   $request->input('rating_item_parent_id');
            $Rating->sender_id                      =   $request->input('sender_id');
            $Rating->sender_role                    =   $request->input('sender_role');
            $Rating->receiver_id                    =   $request->input('receiver_id');
            $Rating->receiver_role                  =   $request->input('receiver_role');
            $Rating->updated_at                     =   Carbon::now()->toDateTimeString();
            $Rating->save();
            $result                                 =   $Rating;
        }
        if ($result) {
            $notifiy['sender_id']                    = $request->input('sender_id');
            $notifiy['sender_role']                  = $request->input('sender_role');
            $notifiy['receiver_id']                  = $request->input('receiver_id');
            $notifiy['receiver_role']                = $request->input('receiver_role');
            $notifiy['notification_type']            = $request->input('notification_type');
            $notifiy['notification_message']         = $request->input('notification_message');
            $notifiy['notification_item_id']         = $result->rating_id;
            $notifiy['notification_child_item_id']   = $request->input('rating_item_id');
            $notifiy['notification_post_id']         = $request->input('post_id');
            if ($request->input('notification_type') == 14 && $postdata->mark_complete == 2) {
                $notifiy['show'] = 2;
            } else {
                $notifiy['show'] = 1;
            }
            $notifiy['updated_at']                   =  Carbon::now()->toDateTimeString();

            $noti->inserupdate($notifiy);
            event(new eventTrigger(array($request->all(), $result, 'NewNotification')));
        }
        if ($request->input('rating_type') != 4) {

            $post = Post::find($request->input('post_id'));
            $post->buyer_seller_send_review     = '1';
            $post->updated_at                   = Carbon::now()->toDateTimeString();
        }
        if ($request->input('rating_type') == 4) {

            $noti->inserupdate(array('status' => '2'), array(
                'notification_type' => '16', 'notification_item_id' => $request->input('sender_id'), 'notification_child_item_id' => $request->input('post_id'), 'notification_post_id' => $request->input('post_id'), 'sender_id' => $request->input('sender_id'), 'sender_role' => $request->input('sender_role'), 'receiver_id' => $request->input('receiver_id'), 'receiver_role' => $request->input('receiver_role')
            ));
            $post = Post::find($request->input('post_id'));
            $post->agent_send_review     = '1';

            $post->updated_at            = Carbon::now()->toDateTimeString();
        }
        $post->final_status     = '2';
        if ($post->save()) {
            $userdata->updateusersrating($request->all());
            return response()->json(['data' => $result]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($limit, $userid, $role)
    {
        $Rating = new Rating;
        $result = $Rating->getDetailsByAny($limit, array('agents_user_id' => $userid, 'sender_role' => $role));
        return response()->json($result);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetRatingedList($id, $role, $rating_type, $rating_item_id, $rating_item_parent_id, $receiver_id, $receiver_role)
    {
        $Rating = new Rating;
        $result = $Rating->getRatingSingalByAny(array('sender_id' => $id, 'sender_role' => $role, 'receiver_id' => $receiver_id, 'receiver_role' => $receiver_role, 'rating_type' => $rating_type, 'rating_item_id' => $rating_item_id, 'rating_item_parent_id' => $rating_item_parent_id));
        return response()->json($result);
    }
    /* Get rating list by post */
    public function GetRatingListbypost($rating_type, $post_id, $receiver_id, $receiver_role)
    {
        $Rating = new Rating;
        $result = $Rating->GetRatingListbypost(array('agents_rating.rating_type' => $rating_type, 'agents_rating.rating_item_parent_id' => $post_id, 'agents_rating.receiver_id' => $receiver_id, 'agents_rating.receiver_role' => $receiver_role));
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function getfileswithshared(Request $request,$limit)
    // {
    //     $sproposal = array();
    //     $proposals = new Rating;
    //     $shared = new Shared;
    //     $result = $proposals->getDetailsByAny( $limit , array('is_deleted' => '0','agents_user_id' => $request->input('sender_id'),'agents_users_role_id' => $request->input('sender_role') ) );
    //     foreach ($result['result'] as $value) {

    //         $aa['shared_type']          = 2;
    //         $aa['shared_item_id']       = $value->upload_share_id;
    //         $aa['shared_item_type']     = $request->input('shared_item_type');
    //         $aa['shared_item_type_id']  = $request->input('post_id');
    //         $aa['sender_id']            = $request->input('sender_id');
    //         $aa['sender_role']          = $request->input('sender_role');
    //         $aa['receiver_id']          = $request->input('receiver_id');
    //         $aa['receiver_role']        = $request->input('receiver_role');
    //         $ss = $shared->getsinglerowByAny($aa);
    //         if(empty($ss)){
    //             $sproposal[$value->upload_share_id] = '';
    //         }else{
    //             $sproposal[$value->upload_share_id] = $ss;
    //         }
    //     }
    //     return response()->json(array($result,$sproposal));
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $result = DB::table('agents_rating')->where('rating_id', $id)->delete();
    }

    public function reviewofpost(Request $request, $post_id)
    {
        $review = DB::table('agents_rating')->where(['rating_item_parent_id' => $post_id, 'rating_item_id' => Auth::user()->id])->first();
        return response()->json($review);
    }
}
