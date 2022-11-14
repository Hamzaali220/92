<?php

namespace App\Http\Controllers\Api;

use App\Events\eventTrigger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Agentskills;
use App\Models\QuestionAnswers;
use App\Models\State;
use App\Models\MessagingChat;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Bookmark;
use App\Models\Notification;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class MessagingChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post_id = null, $receiver_id = null, $receiver_role_id = null)
    {
        if (Auth::user()) {
            $view                   = array();
            $view['user'] = $user   = Auth::user();
            $view['userdetails']    = $userdetails = Userdetails::find($user->id);
            if ($receiver_id != null && $receiver_role_id != null && $post_id != null) {

                $messagingchat = new MessagingChat;
                $dt = array(
                    'sender_id'         => $user->id, 'sender_role_id'    => $user->agents_users_role_id, 'receiver_id'       => $receiver_id, 'receiver_role_id'  => $receiver_role_id,
                );
                $orwhere = array(
                    'receiver_id'       => $user->id, 'receiver_role_id'  => $user->agents_users_role_id, 'sender_id'         => $receiver_id, 'sender_role_id'    => $receiver_role_id,
                );
                $norwhere = array('post_id'     => $post_id);
                $checkmc = $messagingchat->getConversationByAny($dt, $orwhere, $norwhere);
                if (count($checkmc) == 0) {
                    $dt['snippet']              = 'You are now connected on Messenger.';
                    $dt['tags_read']            = 1;
                    $dt['tags_user_id']         = $receiver_id;
                    $dt['tags_user_role']       = $receiver_role_id;
                    $dt['unread_count']         = 1;
                    $dt['post_id']              = $post_id;
                    $dt['updated_at']           = Carbon::now()->toDateTimeString();
                    $dt['created_at']           = Carbon::now()->toDateTimeString();
                    $view['conversation_id']    = $messagingchat->ConversationInserUpdate($dt);

                    $notifiy = array(
                        'sender_id'         => $user->id, 'sender_role'       => $user->agents_users_role_id,
                        'receiver_id'       => $receiver_id, 'receiver_role'     => $receiver_role_id
                    );
                    $notifiy['notification_type']            = 6;
                    $notifiy['notification_message']         = $userdetails->name . ' just joined you on Messag!';
                    $notifiy['notification_item_id']         = $view['conversation_id'];
                    $notifiy['notification_child_item_id']   = $post_id;
                    $notifiy['status']                       = 1;
                    $notifiy['updated_at']                   = Carbon::now()->toDateTimeString();
                    $notifiy['created_at']                   = Carbon::now()->toDateTimeString();

                    $noti = new Notification;
                    $noti->inserupdate($notifiy);
                } else {
                    $view['conversation_id']    = $checkmc[0]->conversation_id;
                }
                $user = new User;
                $view['receiver'] = $user->getDetailsByEmailOrId(array('id' => $receiver_id));
                $view['post_id']      = $post_id != null ? $post_id : '';
            }
            // return view('dashboard.user.messages.messages', $view);
            return response()->json(['status' => '200', 'response' => $view]);
        } else {

            // return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
            return response()->json(['status' => '201', 'response' => 'User is not authenticated']);
        }
    }

    /* For create conversation */
    public function createconversation($post_id = null, $receiver_id = null, $receiver_role_id = null)
    {
        if (Auth::user()) {
            $dt = array();
            $user           = Auth::user();
            $userdetails    = Userdetails::find($user->id);


            if ($receiver_id != null && $receiver_role_id != null && $post_id != null) {

                $messagingchat = new MessagingChat;
                $where = array(
                    'sender_id'           => $user->id,
                    'sender_role_id'      => $user->agents_users_role_id,
                    'receiver_id'         => $receiver_id,
                    'receiver_role_id'    => $receiver_role_id,
                );
                $orwhere = array(
                    'receiver_id'         => $user->id,
                    'receiver_role_id'    => $user->agents_users_role_id,
                    'sender_id'           => $receiver_id,
                    'sender_role_id'      => $receiver_role_id,
                );
                $norwhere = array('post_id'   => $post_id);
                $checkmc = $messagingchat->getConversationByAny($where, $orwhere, $norwhere);



                if (count($checkmc) == 0) {
                    $dt['sender_id']            = $user->id;
                    $dt['sender_role_id']       = $user->agents_users_role_id;
                    $dt['receiver_id']          = $receiver_id;
                    $dt['receiver_role_id']     = $receiver_role_id;
                    $dt['snippet']              = 'You are now connected on Messenger.';
                    $dt['tags_read']            = 1;
                    $dt['tags_user_id']         = $receiver_id;
                    $dt['tags_user_role']       = $receiver_role_id;
                    $dt['unread_count']         = 1;
                    $dt['post_id']              = $post_id;
                    $dt['updated_at']           = Carbon::now()->toDateTimeString();
                    $dt['created_at']           = Carbon::now()->toDateTimeString();
                    $conversation_id    = $messagingchat->ConversationInserUpdate($dt);

                    $notifiy = array(
                        'sender_id'         => $user->id, 'sender_role'       => $user->agents_users_role_id,
                        'receiver_id'       => $receiver_id, 'receiver_role'     => $receiver_role_id
                    );
                    $notifiy['notification_type']            = 6;
                    $notifiy['notification_message']         = $userdetails->name . ' just joined you on Messag!';
                    $notifiy['notification_item_id']         = $conversation_id;
                    $notifiy['notification_child_item_id']   = $post_id;
                    $notifiy['status']                       = 1;
                    $notifiy['updated_at']                   = Carbon::now()->toDateTimeString();
                    $notifiy['created_at']                   = Carbon::now()->toDateTimeString();

                    $noti = new Notification;
                    $noti->inserupdate($notifiy);
                } else {
                    $conversation_id    = $checkmc[0]->conversation_id;
                }

                $where = array(
                    'm.sender_id'           => $user->id,
                    'm.sender_role_id'      => $user->agents_users_role_id,
                );
                $orwhere = array(
                    'm.receiver_id'         => $user->id,
                    'm.receiver_role_id'    => $user->agents_users_role_id,
                );
                $result = $messagingchat->getUserConversationsListByAny(0, $where, $orwhere, array('m.conversation_id' => $conversation_id));

                return response()->json($result);
            }
        } else {

            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MessagingChat  $messagingChat
     * @return \Illuminate\Http\Response
     */
    public function ConversationList(Request $request)
    {
        $messagingchat = new MessagingChat;
        $limit=$request->input('limit');
        $where = array(
            'm.sender_id'           => $request->input('sender_id'),
            'm.sender_role_id'      => $request->input('sender_role'),
        );
        $orwhere = array(
            'm.receiver_id'         => $request->input('sender_id'),
            'm.receiver_role_id'    => $request->input('sender_role'),
        );
        $result = $messagingchat->getUserConversationsListByAny($limit, $where, $orwhere);
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MessagingChat  $messagingChat
     * @return \Illuminate\Http\Response
     */
    public function ConversationMessagesList(Request $request)
    {
        $ratingdata = array();
        $limit=$request->input('limit');
        $bookmarkdata = array();
        $bookmark = new Bookmark;
        $rating = new Rating;
        $messagingchat = new MessagingChat;
        $where = array(
            'm.sender_id'           => $request->input('sender_id'),
            'm.sender_role'         => $request->input('sender_role'),
        );
        $orwhere = array(
            'm.receiver_id'         => $request->input('sender_id'),
            'm.receiver_role'       => $request->input('sender_role'),
        );
        $mainwhere = array('m.conversation_id'  => $request->input('conversation_id'));
        $result = $messagingchat->getUserConversationsMessageListByAny($limit, $where, $orwhere, $mainwhere);

        if ($result['count'] != 0 && $request->input('bookmark') && !empty($request->input('bookmark'))) {

            foreach ($result['result'] as $value) {

                $bok = $bookmark->getBookmarkSingalByAny(array('bookmark_type' => 3, 'bookmark_item_id' => $value->messages_id, 'bookmark_item_parent_id' => $request->input('conversation_id'), 'sender_id' => $request->input('sender_id'), 'sender_role' => $request->input('sender_role')));
                if (empty($bok)) {
                    $bookmarkdata[$value->messages_id] = '';
                } else {
                    $bookmarkdata[$value->messages_id] = $bok;
                }
                if ($request->input('sender_role') == 4) {

                    $rat = $rating->getRatingSingalByAny(array('rating_type' => 2, 'rating_item_id' => $value->messages_id, 'rating_item_parent_id' => $request->input('conversation_id'), 'sender_id' => $value->user_id, 'sender_role' => $value->agents_users_role_id, 'receiver_id' => $request->input('sender_id'), 'receiver_role' => $request->input('sender_role')));
                    if (empty($rat)) {
                        $ratingdata[$value->messages_id] = '';
                    } else {
                        $ratingdata[$value->messages_id] = $rat;
                    }
                }
            }
        }

        return response()->json(array($result, $bookmarkdata, $ratingdata));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MessagingChat  $messagingChat
     * @return \Illuminate\Http\Response
     */
    public function SendedMessage(Request $request)
    {
        $limit=$request->input('limit');
        $messagingchat = new MessagingChat;
        $where = array(
            'm.sender_id'           => Auth::user()->id,
            'm.sender_role_id'      => Auth::user()->agents_users_role_id,
        );
        $orwhere = array(
            'm.receiver_id'         => Auth::user()->id,
            'm.receiver_role_id'    => Auth::user()->agents_users_role_id,
        );
        $result = $messagingchat->getSendedMessageListByAny($limit, $where, $orwhere);        //echo '<pre>'; print_r($result); die;
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MessagingChat  $messagingChat
     * @return \Illuminate\Http\Response
     */
    public function UnreadMessage(Request $request)
    {
        $messagingchat = new MessagingChat;
        $normwhere  = array(
            'tags_user_id'    => Auth::user()->id,
            'tags_user_role'  => Auth::user()->agents_users_role_id,
            'tags_read'       => 1,
        );
        $result = $messagingchat->getUnreadMessageListByAny($normwhere);
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MessagingChat  $messagingChat
     * @return \Illuminate\Http\Response
     */
    public function InsertNewMessage(Request $request)
    {
        if (!empty($request->all())) {

            $cmm    = MessagingChat::find($request->input('conversation_id'));
            $mcount                     =  $cmm->unread_count + 1;
            $cmm->tags_read             =  1;
            if ($request->input('is_user') == 'receiver') {
                $cmm->last_receiver_msg = $request->input('message_text');
                $cmm->last_receiver_da  = Carbon::now()->toDateTimeString();
            } else {
                $cmm->last_sender_msg   = $request->input('message_text');
                $cmm->last_sender_da    = Carbon::now()->toDateTimeString();
            }
            $cmm->tags_user_id          =  $request->input('receiver_id');
            $cmm->tags_user_role        =  $request->input('receiver_role');
            $cmm->unread_count          =  $mcount;
            $cmm->snippet               =  $request->input('message_text');
            $cmm->updated_at            =  Carbon::now()->toDateTimeString();
            $cmm->created_at            =  Carbon::now()->toDateTimeString();
            $cmm->post_id= $request->input('post_id');
            $cmm->sender_id= $request->input('sender_id');
            // $cmm->sender_role= $request->input('sender_rol');
            $cmm->save();

            $messagingchat = new MessagingChat;
            $dt = array(
                'conversation_id'   => $request->input('conversation_id'),
                'post_id'           => $request->input('post_id'),
                'sender_id'         => $request->input('sender_id'),
                'sender_role'       => $request->input('sender_role'),
                'receiver_id'       => $request->input('receiver_id'),
                'receiver_role'     => $request->input('receiver_role'),
                'message_text'      => $request->input('message_text'),
                'tags_read'         => 1,
                'updated_at'        => Carbon::now()->toDateTimeString(),
                'created_at'        => Carbon::now()->toDateTimeString(),
            );
            $messages_id = $messagingchat->ConversationMessageInserUpdate($dt);
            if ($messages_id) {
                $notifiy = array(
                    'sender_id'         => $request->input('sender_id'),
                    'sender_role'       => $request->input('sender_role'),
                    'receiver_id'       => $request->input('receiver_id'),
                    'receiver_role'     => $request->input('receiver_role'),
                );
                $notifiy['notification_type']            = 7;
                $notifiy['notification_message']         = $request->input('name') . ' send a message: ' . $request->input('message_text');
                $notifiy['notification_item_id']         = $messages_id->messages_id;
                $notifiy['notification_child_item_id']   = $request->input('conversation_id');
                $notifiy['status']                       = 1;
                $notifiy['updated_at']                   = Carbon::now()->toDateTimeString();
                $notifiy['created_at']                   = Carbon::now()->toDateTimeString();

                $noti = new Notification;
                $noti->inserupdate($notifiy);

                $where = array(
                    'm.sender_id'           => $request->input('receiver_id'),
                    'm.sender_role_id'      => $request->input('receiver_role'),
                );
                $orwhere = array(
                    'm.receiver_id'         => $request->input('receiver_id'),
                    'm.receiver_role_id'    => $request->input('receiver_role'),
                );
                $result = $messagingchat->getUserConversationsListByAny(0, $where, $orwhere, array('m.conversation_id' => $request->input('conversation_id')));
                event(new eventTrigger(array($request->all(), $result, 'NewMessage')));

                return response()->json(array('status' => 'success', 'data' => $messages_id));
            } else {
                return response()->json(array('status' => 'error', 'error' => 'some issue'));
            }
        }
    }

    /* For Read and update chat */
    public function readupdate(Request $request)
    {
        if (!empty($request->all())) {
            $cmm = array();
            $cmm['tags_read']      =  2;
            $cmm['tags_user_id']   =  0;
            $cmm['tags_user_role'] =  0;
            $cmm['unread_count']   =  0;
            $messagingchat = new MessagingChat;
            $messagingchat->ConversationInserUpdate($cmm, array('conversation_id' => $request->input('cid'), 'tags_user_id' => Auth::user()->id));
            $messagingchat->ConversationMessageInserUpdate(array('tags_read' => 2), array('conversation_id' => $request->input('cid'), 'receiver_id' => Auth::user()->id, 'receiver_role' => Auth::user()->agents_users_role_id));
            return response()->json(array('status' => 'success', 'data' => $messagingchat));        }
    }

    /* Added as API for notification creation */
    public function getnotifications($limit)
    {
        $user = Auth::user();
        $notification = new Notification;
        $result = $notification->getnotification($limit, $user->id, $user->agents_users_role_id);
        return response()->json($result);
    }

    // Update the notification to be read
    public function update($id = null)
    {
        $notification = new Notification;
        $result = $notification->inserupdate(
            array('status' => 2, 'updated_at' => Carbon::now()->toDateTimeString()),
            array(
                'notification_id' => $id
            )

        );
        $response_arr = [];
        if ($result) {
            $response_arr['status'] = 100;
            $response_arr['messages'] = 'Notification read successfully';
        } else {
            $response_arr['status'] = 101;
            $response_arr['messages'] = 'Something went wrong';
        }
        return response()->json($response_arr);
    }
}
