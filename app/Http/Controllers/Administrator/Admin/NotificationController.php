<?php

namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /* For notification view */
    public function index()
    {
        $user = auth()->guard('admin')->user();
        return view('admin.pages.notification.notificationList');
    }

    /* For get notification */
    public function getNotification($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        $query = DB::table('agents_notification_type as a')->select('*');
        $query->where('a.is_deleted', '0');

        if (!empty($request['search']['value'])) {
            $query->where('a.title', 'like', "%" . $request['search']['value'] . "%");
        }

        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)
                ->skip($offset);
        }

        $query->orderBy('a.title', 'ASC');
        $result['result'] =  $query->get();
        return $result;
    }

    /* For date and time */
    public function mmddyyy($date = Null)
    {

        $formate = "";
        if (!empty($date) && $date != "0000-00-00 00:00:00") :
            $formate = date('M d Y', strtotime($date));
        endif;
        return $formate;
    }

    /* Get notification list */
    public function getNotificationList()
    {

        $list = $this->getNotification($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list['result'] as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->title) ? ucwords(strtolower($result->title)) : '';
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';
            $row[] =  $result->status == 1 ? '<button class="btn btn-success" onClick ="status_change_function(\'' . $result->type_id . '\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
                '<button class="btn btn-danger" onClick ="status_change_function(\'' . $result->type_id . '\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : '',
            "recordsTotal" => intval($list['num']),
            "recordsFiltered" => intval($list['num']),
            "data" => $data,
        );
        echo json_encode($output);
    }

    /* For delete notification */
    public function deleteNoti(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_notification_type')->where(array('type_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :
                $value = $request->input('value');
                DB::table('agents_notification_type')->where(array('type_id' => $id))->update(array('status' => $value));
            endif;
        }
    }
}
