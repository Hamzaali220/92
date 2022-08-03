<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UploadAndShare extends Model
{
    protected $table = 'agents_upload_share_all';
    protected $primaryKey = "upload_share_id";

    /* get all data any filed using*/
    public function getDetailsByAny($limit, $where = null)
    {
        $query = DB::table('agents_upload_share_all')->select('*');



        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('created_at', 'DESC');

        $count = $query->get()->count();

        $result = $query->skip($limit * 3)->take(3)->get();

        $coun = floor($count / 3);

        $prview = $limit == 0 ? 0 : $limit - 1;

        $next   = $coun == $limit ? 0 : ($count <= 3 ? 0 : $limit + 1);

        $rlimit = $limit * 3 == 0 ? 1 : $limit * 3;

        $llimit = $next * 3 == 0 ? $count : $next * 3;



        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);



        return $data;
    }

    /* get all data any filed using*/
    public function gettenDetailsByAny($limit, $where = null)
    {

        $query = DB::table('agents_upload_share_all')->select('*');



        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('created_at', 'DESC');

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


    /* For upload and share insert update */
    public function inserupdate($data = null, $id = null)

    {

        if (empty($id)) {

            $result = DB::table('agents_upload_share_all')->insertGetId($data);
        } else {

            $result = DB::table('agents_upload_share_all')->where($id)->update($data);
        }

        return $result;
    }
}
