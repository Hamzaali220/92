<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Survey extends Model

{

    protected $table = 'agents_survey';

    protected $primaryKey = "survey_id";



    /* get all data any filed using*/
    public function getSurveyByAny($where = null)
    {

        $query = DB::table('agents_survey')->select('*');



        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('updated_at', 'DESC');

        return $result = $query->get();
    }

    /* get all data any filed using*/
    public function getSurveySingalByAny($where = null)
    {

        $query = DB::table('agents_survey')->select('*');



        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('updated_at', 'DESC');

        return $result = $query->first();
    }


    /* Data insert and update in survey */
    public function inserupdate($data = null, $id = null)

    {

        if (empty($id)) {

            $result = DB::table('agents_survey')->insertGetId($data);
        } else {

            $result = DB::table('agents_survey')->where($id)->update($data);
        }

        return $result;
    }

    /* get all data any filed using*/
    public function getDetailsByAny($limit, $where = null)
    {

        $query = DB::table('agents_survey')->select('*');

        $query->leftJoin('agents_question', 'agents_question.question_id', '=', 'agents_survey.question_id');

        if ($where != null) {

            $query->where($where);
        }

        $query->orderBy('agents_survey.updated_at', 'DESC');

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



    /* get Survay Loop Question By Any */
    public function getSurvayLoopQuestionByAny($where = null, $orwhere = null)
    {

        $query2 = DB::table('agents_question')

            ->select('agents_question.*')

            ->where(array('agents_question.is_deleted' => '0', 'agents_question.add_by' => '1', 'agents_question.add_by_role' => '1', 'agents_question.survey' => '1', 'agents_question.question_type' => $where['agents_users_conections.to_role']))

            ->whereNOTIn('agents_question.question_id', function ($query) use ($where, $orwhere) {

                $query->select('question_id')

                    ->from('agents_answers')

                    ->where(array('from_id' => $where['agents_users_conections.to_id'], 'from_role' => $where['agents_users_conections.to_role']));
            });



        $query1 = DB::table('agents_users_conections')

            ->join('agents_question', function ($join) {

                $join->on('agents_question.add_by', '=', 'agents_users_conections.to_id')

                    ->orOn('agents_question.add_by', '=', 'agents_users_conections.from_id');
            })

            ->where(function ($query) use ($where, $orwhere) {

                $query->where($where);

                $query->orWhere($orwhere);
            })

            ->where(array('agents_question.is_deleted' => '0', 'agents_question.survey' => '1', 'agents_question.question_type' => $where['agents_users_conections.to_role']))

            ->where(function ($query) use ($where, $orwhere) {

                $query->whereRaw(DB::raw(



                    'CASE WHEN agents_users_conections.to_id = ' . $where['agents_users_conections.to_id'] . ' AND agents_users_conections.to_role = ' . $where['agents_users_conections.to_role'] . '

			                    THEN agents_users_conections.from_id 	= 	agents_question.add_by

			                    WHEN agents_users_conections.from_id 	= ' . $orwhere['agents_users_conections.from_id'] . '  AND agents_users_conections.from_role = ' . $orwhere['agents_users_conections.from_role'] . '

			                    THEN agents_users_conections.to_id 		= 	agents_question.add_by END'



                ));
            })

            ->select('agents_question.*');



        $results = $query1->union($query2)

            ->whereNOTIn('agents_question.question_id', function ($query) use ($where, $orwhere) {

                $query->select('question_id')

                    ->from('agents_answers')

                    ->where(array('from_id' => $where['agents_users_conections.to_id'], 'from_role' => $where['agents_users_conections.to_role']));
            })

            ->orderByRaw("RAND()")

            ->first();

        return $results;
    }
}
