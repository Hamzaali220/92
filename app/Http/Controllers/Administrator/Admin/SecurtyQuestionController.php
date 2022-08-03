<?php

namespace App\Http\Controllers\Administrator\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\SecurtyQuestion;

class SecurtyQuestionController extends Controller
{
    /* For security questions show in admin. */
	public function index() {
        $user = auth()->guard('admin')->user();
		return view('admin.pages.securtyquestion.securtyquestionlist');
    }

	public function getsecurtyquestionlist() {

		$SecurtyQuestion = new SecurtyQuestion;
		$list= $SecurtyQuestion->getSecurtyQuestionList($_REQUEST,$_REQUEST['length'],$_REQUEST['start']);
		$data = array();
		$no = $_REQUEST['start'];
		foreach ($list['result'] as $result) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = isset($result->question)?ucwords(strtolower($result->question)):'';
			$row[] = isset($result->created_at)?$this->mmddyyy($result->created_at):'';

			if((isset(session('user_access_data')->squeschange) && session('user_access_data')->squeschange == 1) OR session("userid") == 1){
				$row[] =  $result->status==1 ? '<button class="btn btn-success" onClick ="status_change_function(\''.
			$result->securty_question_id.'\',0,\'Are you sure want to deactive this record ? \');">Active</button>' :
            '<button class="btn btn-danger" onClick ="status_change_function(\''.$result->securty_question_id.'\',1,\'Are you sure want to active this record ? \');">Deactive</button>';
			}else{
				$row[] =  $result->status==1 ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">Deactive</button>';
			}

			if((isset(session('user_access_data')->squeschange) && session('user_access_data')->squeschange == 1) OR session("userid") == 1){
			$row[] = '<a class="btn btn-success" href="'.url("/agentadmin/securtyquestionaddedit/").'/'.$result->securty_question_id.'"><i class="fa fa-pencil fa-xs"></i></a>
					 <button class="btn btn-danger" onClick ="confirm_function(\''.$result->securty_question_id.'\',\'Are you sure, you want to delete this record? \');"><i class="fa fa-trash-o fa-xs"></i></button>';
			}else{
				$row[] = 'No access';
			}

			$data[] = $row;
		}

		$output = array(
			"draw" => isset($_REQUEST['draw'])?intval($_REQUEST['draw']):'',
			"recordsTotal" => intval($list['num']),
			"recordsFiltered" => intval($list['num']),
			"data" => $data,
		);
		// print_r($output);
		echo json_encode($output);
	}

	public function securtyquestionaddedit($id=null) {
        $user = auth()->guard('admin')->user();
		$result=array();
		$SecurtyQuestion = new SecurtyQuestion;
		if(!empty($id)):
			$result = $SecurtyQuestion->getSecurtyQuestionByid(array('securty_question_id'=>$id));
		endif;

		$view=array(
			'result'=> count($result) > 0 ? $result[0] : ''
		);
		$view['tag'] = count($result) != 0 ? 'Edit' : 'Add';
		return view('admin.pages.securtyquestion.securtyquestion',$view);
    }

	public function save(Request $request)
    {

        $rules = array(
            'question'  => 'required|string|unique:agents_securty_question',
		);

		$securty_question_id = $request->input('securty_question_id') ? $request->input('securty_question_id') : '';

		if($securty_question_id !== ""){
			$rules = array(
				'question'  => "required|string|unique:agents_securty_question,question,$securty_question_id,securty_question_id",
			);
		}

        $input_arr = array(
            'question' => $request->input('question'),
        );
        $validator = Validator::make($input_arr,$rules);
        if( $validator->fails() ):
            return Redirect::back()->withErrors($validator)->withInput();
        else:



			$data_arr = array(
				'question'=>$request->input('question'),
				'is_deleted'=>'0',
				'updated_at'=>date('Y-m-d H:i:s')
			);
			if(!empty($securty_question_id)):
				DB::table('agents_securty_question')->where(array('securty_question_id'=>$securty_question_id))->update($data_arr);
				 return Redirect::back()->with('success','security question has been updated successfully.');
			else:
				$data_arr['created_at']=date('Y-m-d H:i:s');
				DB::table('agents_securty_question')->insertGetId($data_arr);
			 	return Redirect::back()->with('success','security question has been created successfully.');
			endif;

			 return Redirect::back()->with('dbError','Oops Something went wrong !!');
        endif;
    }

	public function mmddyyy($date=Null){
			$formate="";
			if(!empty($date) && $date!="0000-00-00 00:00:00"):
				$formate = date('M d Y',strtotime($date));
			endif;
			return $formate;

	}

	public function deletesecurtyquestion(Request $request){

		$id = $request->input('id');
		$tag = $request->input('tag');
		if(!empty($id)){
			if($tag=='Delete'):
				DB::table('agents_securty_question')->where(array('securty_question_id'=>$id))->update(array('is_deleted'=>'1'));
			elseif($tag=='status'):
				 $value = $request->input('value');
                DB::table('agents_securty_question')->where(array('securty_question_id'=>$id))->update(array('status'=>$value));
			endif;
		}
	}
}
