<?php

namespace App\Http\Controllers\Api;

use App\Events\eventTrigger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Bookmark;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BookmarkController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $post_id agent_id
     * @return \Illuminate\Http\Response
     */
    public function AppliedAgents($post_id = null, $agentid = null)
    {
        $user = Auth::user();
        $userdetails = Userdetails::find($user->id);
        $post = Post::find($post_id);
        $post->applied_post     = '1';

        $post->applied_user_id  = $agentid;

        $post->updated_at       = Carbon::now()->toDateTimeString();

        $post->agent_select_date     = Carbon::now()->toDateTimeString();
        $post->cron_time     = Carbon::now()->toDateTimeString();

        $post->save();
        $user = new User;

        $agentdata = $user->getDetailsByEmailOrId(array('id' => $agentid));

        $notification = new Notification;

        $where = array();

        $where['sender_id']                    = $post->agents_user_id;

        $where['sender_role']                  = $post->agents_users_role_id;

        $where['receiver_id']                  = $agentdata->id;

        $where['receiver_role']                = $agentdata->agents_users_role_id;

        $where['notification_type']            = 13;

        $where['notification_message']         = $userdetails->name . ' select you for post (' . $post->posttitle . ')';

        $where['notification_item_id']         = $post_id;

        $where['notification_post_id']         = $post_id;

        $where['notification_child_item_id']   = $agentdata->id;

        $where['created_at']                   =  Carbon::now()->toDateTimeString();

        $where['updated_at']                   =  Carbon::now()->toDateTimeString();

        $result = $notification->inserupdate($where);

        event(new eventTrigger(array($where, $result, 'NewNotification')));



        $emaildata['url']       = url('/search/post/details/') . '/' . $post_id . '/13';

        $emaildata['email']     = $agentdata->email;

        $emaildata['name']      = ucwords($agentdata->name);

        $emaildata['posttitle'] = ucwords($post->posttitle);

        $emaildata['html']      = '<div>

                                        <h3>Hello ' . $emaildata['name'] . ',</h3>

                                        <br>

                                        <p>

                                           ' . $userdetails->name . ' select you for post `' . $emaildata['posttitle'] . '`

                                        </p>

                                        <br>



                                     <p>Visit post <a href="' . $emaildata['url'] . '">' . $emaildata['posttitle'] . '</a> </p>

                                    <br>

                                    <br>

                                    <center><a href="' . URL('/') . '"> www.92Agents.com </a></center>

                                  <div>';



        Mail::send([], [], function ($message) use ($emaildata) {

            $message->to($emaildata['email'], $emaildata['name'])

                ->subject('You are selected for post " ' . $emaildata['posttitle'] . ' "')

                ->setBody($emaildata['html'], 'text/html');

            $message->from('92agent@92agents.com', '92agent@92agents.com');
        });

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $update = $notifiy = array();
        $update['bookmark_type']                             =   $request->input('bookmark_type');
        $update['bookmark_item_id']                          =   $request->input('bookmark_item_id');
        $update['bookmark_item_parent_id']                   =   $request->input('bookmark_item_parent_id');
        $notifiy['sender_id'] = $update['sender_id']         =   $request->input('sender_id');
        $notifiy['sender_role'] = $update['sender_role']     =   $request->input('sender_role');
        $notifiy['receiver_id'] = $update['receiver_id']     =   $request->input('receiver_id');
        $notifiy['receiver_role'] = $update['receiver_role'] =   $request->input('receiver_role');

        $bookmark = new Bookmark();
        $acheck = $bookmark->getBookmarkSingalByAny($update);
        if (!empty($acheck)) {
            $bookbarkupdate                         =  Bookmark::find($acheck->bookmark_id);
            $bookbarkupdate->bookmark_type          =  $request->input('bookmark_type');
            $bookbarkupdate->bookmark_item_id       =  $request->input('bookmark_item_id');
            $bookbarkupdate->bookmark_item_parent_id =  $request->input('bookmark_item_parent_id');
            $bookbarkupdate->sender_id              =  $request->input('sender_id');
            $bookbarkupdate->sender_role            =  $request->input('sender_role');
            $bookbarkupdate->receiver_id            =  $request->input('receiver_id');
            $bookbarkupdate->receiver_role          =  $request->input('receiver_role');
            $bookbarkupdate->updated_at             =  Carbon::now()->toDateTimeString();
            $bookbarkupdate->save();
            $result                                 =   $bookbarkupdate->bookmark_id;
        } else {
            $bookmark->bookmark_type                =   $request->input('bookmark_type');
            $bookmark->bookmark_item_id             =   $request->input('bookmark_item_id');
            $bookmark->bookmark_item_parent_id      =   $request->input('bookmark_item_parent_id');
            $bookmark->sender_id                    =   $request->input('sender_id');
            $bookmark->sender_role                  =   $request->input('sender_role');
            $bookmark->receiver_id                  =   $request->input('receiver_id');
            $bookmark->receiver_role                =   $request->input('receiver_role');
            $bookmark->updated_at                   =   Carbon::now()->toDateTimeString();
            $bookmark->save();
            $result                                 =   $bookmark->bookmark_id;
        }
        // if($result){
        //     $notifiy['notification_type']            = $request->input('notification_type');
        //     $notifiy['notification_message']         = $request->input('notification_message');
        //     $notifiy['notification_item_id']         = $result;
        //     $notifiy['notification_child_item_id']   = $request->input('bookmark_item_id');
        //     $notifiy['updated_at']                   =  Carbon::now()->toDateTimeString();

        // $noti = new Notification;
        // $noti->inserupdate($notifiy);

        // }
        return response()->json(['bookmark_id' => $result, 'status' => '100', 'response' => 'bookmarked']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($limit, $userid, $role)
    {
        $Bookmark = new Bookmark;
        $result = $Bookmark->getDetailsByAny($limit, array('agents_user_id' => $userid, 'sender_role' => $role));
        return response()->json($result);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetBookmarkedList(Request $request)
    {

        $id = $request->input('sender_id');
        $role = $request->input('sender_role');
        $bookmark_type = $request->input('bookmark_type');
        $bookmark_item_id = $request->input('bookmark_item_id');
        $bookmark_item_parent_id = $request->input('bookmark_item_parent_id');

        $Bookmark = new Bookmark;
        $result = $Bookmark->getBookmarkSingalByAny(array('sender_id' => $id, 'sender_role' => $role, 'bookmark_type' => $bookmark_type, 'bookmark_item_id' => $bookmark_item_id, 'bookmark_item_parent_id' => $bookmark_item_parent_id));
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getbookmarklistingwithjoinalldata($limit, $userid, $roleid)
    {
        $bookmark = new Bookmark;
        $query = DB::table('agents_bookmark')
            ->where(array(
                'agents_bookmark.sender_id' => $userid,
                'agents_bookmark.sender_role' => $roleid,
            ))
            ->select('*')
            ->orderBy('agents_bookmark.created_at', 'DESC');

        $count = $query->count();
        $result = $query->get();
        $obj = [];
        foreach ($result as $value) {
            $mergedata = '';
            if ($value->bookmark_type == 1) {
                $mergedata = $bookmark->bookmarkquestion($value, $userid, $roleid);
            }
            if ($value->bookmark_type == 2) {
                $mergedata = $bookmark->bookmark_s_b_a($value, $userid, $roleid);
            }
            if ($value->bookmark_type == 3) {
                $mergedata = $bookmark->bookmarkmessage($value, $userid, $roleid);
            }
            if ($value->bookmark_type == 4) {
                $mergedata = $bookmark->bookmarkanswers($value, $userid, $roleid);
            }
            if ($value->bookmark_type == 5) {
                $mergedata = $bookmark->bookmarkpraposal($value, $userid, $roleid);
            }

            $obj[] = (object) array_merge((array) $value, (array) $mergedata);
        }
        $result = $obj;

        return $result;
    }

    /* For get bookmark list by dashboard */
    public function GetBookmarkListByDashbord()
    {
        $limit = "4";
        $user = Auth::user();

        $result = $this->getbookmarklistingwithjoinalldata($limit, $user->id, $user->agents_users_role_id);
        return response()->json(['status' => '100', 'response' => $result]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('bookmark_id');
        $result = DB::table('agents_bookmark')->where('bookmark_id', $id)->delete();
        if ($result == '1') {
            $result = "deleted";
            return response()->json(['status' => '100', 'response' => $result]);
        }
        return response()->json(['status' => '101', 'response' => $result]);
    }
}
