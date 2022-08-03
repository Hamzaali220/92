<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Importance extends Model
{
    protected $table = 'agents_importance';
    protected $primaryKey = "importance_id";

	/* get all data any filed using*/
    public function getImportanceByAny($where=null){
		$query= DB::table('agents_importance')->select('*');
		if($where != null){
			$query->where($where);
		}
		$query->orderBy('agents_importance.updated_at','DESC');
		$query->where('agents_importance.is_deleted', '0');
		return $result = $query->get();
	}

	/* Importannt insert updte */
	public function inserupdate($data=null,$id=null)
	{
		if(empty($id)){
			$result = DB::table('agents_importance')->insertGetId($data);
		}else{
			$result = DB::table('agents_importance')->where($id)->update($data);
		}
		return $result;
	}

	/* get all data any filed using*/
    public function getDetailsByAny($limit,$where=null){
		$query= DB::table('agents_importance')->select('*');

		$query->leftJoin('agents_question', 'agents_question.question_id', '=', 'agents_importance.importance_item_id');

		if($where != null){

			$query->where($where);

		}
		$query->orderBy('agents_importance.updated_at','DESC');

		$query->where('agents_importance.is_deleted', '0');

		$count = $query->count();

		$result = $query->skip($limit*10)->take(10)->get();

		$coun = floor($count/10);

        $prview = $limit == 0 ? 0 : $limit-1;

        $next   = $coun==$limit ? 0 : ($count <= 10 ? 0 : $limit+1);

        $rlimit = $limit*10==0 ? 1 : $limit*10;

        $llimit = $next*10 == 0 ? $count : $next*10;
	 	$data = array('result' => $result,'count' => $count,'llimit' => $llimit, 'rlimit' => $rlimit,'prview' => $prview, 'next' => $next);

		return $data;
	}
}

