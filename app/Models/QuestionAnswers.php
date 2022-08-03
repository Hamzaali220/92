<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuestionAnswers extends Model
{
	protected $table = 'agents_question';

	protected $primaryKey = "question_id";

	/* get all data any filed using*/
    public function getDetailsByAnylimit($limit,$where=null){

		$query= DB::table('agents_question')->select('*');

		if($where != null){

			$query->where($where);

		}

		$query->orderBy('updated_at','DESC');

		$count = $query->count();

		$result = $query->skip($limit*3)->take(3)->get();

		$coun = floor($count/3);

        $prview = $limit == 0 ? 0 : $limit-1;

        $next   = $coun==$limit ? 0 : ($count <= 3 ? 0 : $limit+1);

        $rlimit = $limit*3==0 ? 1 : $limit*3;

        $llimit = $next*3 == 0 ? $count : $next*3;

	 	$data = array('result' => $result,'count' => $count,'llimit' => $llimit, 'rlimit' => $rlimit,'prview' => $prview, 'next' => $next);

		return $data;

	}


	/* Insert & update questions */
	public function inserupdate($data=null,$id=null)
	{
		if(empty($id)){

			$result = DB::table('agents_question')->insertGetId($data);

		}else{

			$result = DB::table('agents_question')->where($id)->update($data);

		}

		return $result;
	}


	/* For insert and updat answer */
	public function inserupdateAnswers($data=null,$id=null)
	{
		if(empty($id)){

			$result = DB::table('agents_answers')->insertGetId($data);

		}else{

			DB::table('agents_answers')->where($id)->update($data);

			$result = $id['answers_id'];
		}

		return $result;

	}

	/* For all answer update and insert */
	public function inserupdateAnswersall($data=null,$id=null)
	{
		if(empty($id)){
			$result = DB::table('agents_answers')->insertGetId($data);
		}else{
			$dd = DB::table('agents_answers')->where($id)->update($data);
			if($dd==1){
				$result = $id['answers_id'];
			}
			if($dd==0){
				return 'noupdate';
			}
		}
		return $result;
	}

	/* get all data any filed using Answers table*/
    public function getDetailsAnswersByAny($where=null){

		$query= DB::table('agents_answers')->select('*');



		if($where != null){

			$query->where($where);

		}

		$query->orderBy('updated_at','DESC');

		return $result = $query->get();

	}

	/* get all data any filed using Answers table*/
    public function getDetailsAnswerswithuserByAny($where=null){

		$query= DB::table('agents_answers as a')->select('a.*','c.name','c.photo','d.role_name');

		$query->leftJoin('agents_users as b', 'b.id', '=', 'a.from_id');

		$query->leftJoin('agents_users_details as c', 'c.details_id', '=', 'a.from_id');

		$query->leftJoin('agents_users_roles as d', 'd.role_id', '=', 'b.agents_users_role_id');

		if($where != null){

			$query->where($where);

		}

		$query->orderBy('a.updated_at','DESC');

		return $result = $query->get();

	}

	/* get all data any filed using Answers table*/
    public function getAnswersByAny($where=null){
		$query= DB::table('agents_answers')->select('*');
		if($where != null){
			$query->where($where);
		}
		$query->orderBy('updated_at','DESC');
		return $result = $query->first();
	}

	/* get all data any filed using*/
    public function getQuestionByAny($where=null){

		$query= DB::table('agents_question')->select('*');
		if($where != null){
			$query->where($where);
		}
		$query->orderBy('updated_at','DESC');
		return $result = $query->get();

	}

	/* get all data any filed using*/
    public function getQuestionsingalByAny($where=null){

		$query= DB::table('agents_question')->select('*');

		if($where != null){

			$query->where($where);

		}
		$query->orderBy('updated_at','DESC');

		return $result = $query->first();
	}

	/* get all QuestionAnswers data any filed using*/
    public function getquestionandanswers($where=null){

		$$query= DB::table('agents_question')->select('*');

		$query->join('agents_answers', 'agents_answers.question_id', '=', 'agents_question.question_id');

		if($where != null){

			$query->where($where);

		}

		$query->orderBy('updated_at','DESC');

		$result = $query->get();

		return $result;

	}

	/* For get question answer info */
	public function getQuestionAnswersList($request,$limit=NUll,$offset=NULL){

		$result=array();

		$query= DB::table('agents_question as a')->select('a.*','b.role_name');

		$query->Join('agents_users_roles as b', 'b.role_id', '=', 'a.question_type');

		$query->where(array('a.is_deleted' => '0','a.add_by' => '1','a.add_by_role' => '1'));



		if (!empty($request['search']['value'])) {

			$query->where('a.question', 'like', "%".$request['search']['value']."%");

		}

		$result['num'] =  count($query->get());

		if(!empty($limit)){

			$query->take($limit)

			->skip($offset);

		}
		$query->orderBy('a.question_id', 'DESC');

		$result['result'] =  $query->get();

		return $result;

	}

}

