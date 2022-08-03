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
use App\Models\Bookmark;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class BookmarkController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()
    {
        if (Auth::user()) {

            $view = array();

            $view['user'] = $user = Auth::user();

            $view['userdetails'] = $userdetails = Userdetails::find($user->id);

            if ($user->agents_users_role_id == 4) {

                $view['pagetype'] = 'post';
            } else {

                $view['pagetype'] = 'agents';
            }

            $view['user_type'] = env('user_role_' . $user->agents_users_role_id);

            return view('dashboard.user.bookmark.bookmark', $view);
        } else {

            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
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

        return response()->json(['data' => $result]);
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

    public function GetBookmarkedList($id, $role, $bookmark_type, $bookmark_item_id, $bookmark_item_parent_id)

    {

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

    public function GetBookmarkListByDashbord($limit)

    {

        $user = Auth::user();

        $bookmark = new Bookmark;

        $result = $bookmark->getbookmarklistingwithjoinalldata($limit, $user->id, $user->agents_users_role_id);

        return response()->json($result);
    }





    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function delete($id)

    {

        $result = DB::table('agents_bookmark')->where('bookmark_id', $id)->delete();

        return response()->json($result);
    }
}
