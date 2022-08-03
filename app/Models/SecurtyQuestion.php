<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SecurtyQuestion extends Model

{

    protected $table = 'agents_securty_question';

    protected $primaryKey = "securty_question_id";



    /* get all data any filed using*/
    public function getSecurtyQuestionByid($where = null)
    {

        $query = DB::table('agents_securty_question')->select('*');



        if ($where != null) {

            $query->where($where);
        }



        return $result = $query->get();
    }


    /* get security questions */
    public function getSecurtyQuestionByuserid($userid)

    {

        $query = DB::table('agents_users_details')->select('agents_users_details.details_id', 'agents_users_details.question_1', 'agents_users_details.answer_1', 'agents_users_details.question_2', 'agents_users_details.answer_2', 'q1.question as question1', 'q2.question as question2');

        $query->leftJoin('agents_securty_question as q1', 'q1.securty_question_id', '=', 'agents_users_details.question_1');

        $query->leftJoin('agents_securty_question as q2', 'q2.securty_question_id', '=', 'agents_users_details.question_2');

        $query->where(array('agents_users_details.details_id' => $userid, 'q1.is_deleted' => '0', 'q2.is_deleted' => '0'));

        $result = $query->first();

        return $result;
    }

    /* For get security questions detail */
    public function getSecurtyQuestionList($request, $limit = NUll, $offset = NULL)
    {
        $result = array();

        $query = DB::table('agents_securty_question as a')->select('*');

        $query->where('a.is_deleted', '0');



        if (!empty($request['search']['value'])) {

            $query->where('a.question', 'like', "%" . $request['search']['value'] . "%");
        }

        $result['num'] =  count($query->get());



        if (!empty($limit)) {

            $query->take($limit)

                ->skip($offset);
        }



        $query->orderBy('a.securty_question_id', 'DESC');

        $result['result'] =  $query->get();

        return $result;
    }
}
