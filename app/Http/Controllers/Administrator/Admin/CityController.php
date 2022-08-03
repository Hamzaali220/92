<?php

namespace App\Http\Controllers\Administrator\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\State;

class CityController extends Controller {

	/* For show city list view. */
	public function cities() {
        $user = auth()->guard('admin')->user();
		return view('admin.pages.city.cityList');
    }

	/* For get city information for city list */
	public function city($id=null) {
        $user = auth()->guard('admin')->user();
		$result=array();
		$state = new State;
		if(!empty($id)):
			$result = $state->getCityByAny(array('city_id'=>$id),'1');
		endif;

		$view=array(
			'result'=>$result
		);

		return view('admin.pages.city.city',$view);
    }

	/* city add inside the admin */
	public function save(Request $request)
    {
        $rules = array(
            'city_name'  => 'required|string|unique:agents_city',
            'state_id'  => 'required',
        );

		$city_id = $request->input('city_id')?$request->input('city_id'):'';

		if($city_id !== ""){
			$rules = array(
				'city_name'  => "required|string|unique:agents_city,city_name,$city_id,city_id",
				'state_id'  => 'required',
			);
		}

		$input_arr = array(
            'city_name' => $request->input('city_name'),
            'state_id' => $request->input('state'),
        );


        $validator = Validator::make($input_arr,$rules);
        if( $validator->fails() ):
            return Redirect::back()->withErrors($validator)->withInput();
        else:


			$data_arr = array(
				'city_name'=>$request->input('city_name'),
				'is_deleted'=>'0',
				'state_id' => $request->input('state'),
				'updated_at'=>date('Y-m-d H:i:s')
			);
			if(!empty($city_id)):
				DB::table('agents_city')->where(array('city_id'=>$city_id))->update($data_arr);
				 return Redirect::back()->with('success','City has been updated successfully.');
			else:
				$data_arr['created_at']=date('Y-m-d H:i:s');
				DB::table('agents_city')->insertGetId($data_arr);
				 return Redirect::back()->with('success','City has been created successfully.');
			endif;

			 return Redirect::back()->with('dbError','Oops Something went wrong !!');
        endif;
    }

	/* For date and time */
	public function mmddyyy($date=Null){
			$formate="";
			if(!empty($date) && $date!="0000-00-00 00:00:00"):
				$formate = date('M d Y',strtotime($date));
			endif;
			return $formate;

	}

	/* For show cities list. */
	public function getCitiesList(){

		$state = new State;
		$list= $state->getCitiesList($_REQUEST,$_REQUEST['length'],$_REQUEST['start']);
		$data = array();
		$no = $_REQUEST['start'];
		foreach ($list['result'] as $result) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] =isset($result->city_name)?ucwords(strtolower($result->city_name)):'';
			$row[] =isset($result->created_at)?$this->mmddyyy($result->created_at):'';
			if((isset(session('user_access_data')->statechange) && session('user_access_data')->statechange == 1) OR session("userid") == 1){
			$row[] =  '<a class="btn btn-success" href="city/'.$result->city_id.'">
						<i class="fa fa-pencil fa-xs"></i></a>
						<button class="btn btn-danger" onClick ="confirm_function(\''.$result->city_id.'\',\'Are you sure, you want to delete this record? \');">
						<i class="fa fa-trash-o fa-xs"></i></button>';
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
		echo json_encode($output);
	}

	/* For delete city */
	public function deleteCity(Request $request){

		$id = $request->input('id');
		$tag = $request->input('tag');
		if(!empty($id)){
			if($tag=='Delete'):
				DB::table('agents_city')->where(array('city_id'=>$id))->update(array('is_deleted'=>'1'));
			elseif($tag=='status'):

			endif;
		}
	}

}
