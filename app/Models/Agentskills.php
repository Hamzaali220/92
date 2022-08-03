<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agentskills extends Model
{
    protected $table = 'agents_users_agent_skills';
    protected $primaryKey = "skill_id";

    /* For insert and update agent skills */
    public function inserupdate($data = null, $id = null)
    {
        if (empty($id)) {
            $result = DB::table('agents_users_agent_skills')->insertGetId($data);
        } else {
            $result = DB::table('agents_users_agent_skills')->where($id)->update($data);
        }
        return $result;
    }

    /* get all data any filed using*/
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

    /* get all data any filed using*/
    public function getDetailsByAnylimit($limit, $where = null)
    {
        $query = DB::table('agents_users_agent_skills')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        $query->where('agents_users_agent_skills.is_deleted', '0');
        $count = $query->count();
        $result = $query->skip($limit * 3)->take(3)->get();
        $coun = floor($count / 3);
        $prview = $limit == 0 ? 0 : $limit - 1;
        $next   = $coun == $limit ? 0 : ($count <= 3 ? 0 : $limit + 1);
        $rlimit = $limit * 3 == 0 ? 1 : $limit * 3;
        $llimit = $next * 3 == 0 ? $count : $next * 3;

        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }
    /* get all data any filed using Answers table*/
    public function getsinglerowByAny($where = null)
    {
        $query = DB::table('agents_users_agent_skills')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        $query->where('agents_users_agent_skills.is_deleted', '0');
        return $result = $query->first();
    }
}
