<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\State;
use App\Models\City;

class StateController extends Controller
{

	/* For states */
	public function states()
	{
		$state = new State;
		$states = State::with('stateAndCity')->where('is_deleted', '=', '0')->get();
		return response()->json(['status' => '100', 'states' => $states]);
	}

	/* State detail */
	public function state($id = null)
	{
		$user = auth()->guard('admin')->user();
		$result = array();
		$state = new State;
		if (!empty($id)) :
			$result = $state->getStateByAny(array('state_id' => $id), '1');
		endif;

		$view = array(
			'result' => $result
		);
	}


	/* Save state info */
	public function save(Request $request)
	{

		$rules = array(
			'state_name'  => 'required',
			'state_code'  => 'required',
		);
		$input_arr = array(
			'state_name' => $request->input('state_name'),
			'state_code' => $request->input('state_code'),

		);
		$validator = Validator::make($input_arr, $rules);
		if ($validator->fails()) :
			return Redirect::back()->withErrors($validator)->withInput();
		else :

			$state_id = $request->input('state_id') ? $request->input('state_id') : '';

			$data_arr = array(
				'state_name' => $request->input('state_name'),
				'state_code' => $request->input('state_code'),
				'is_deleted' => '0',
				'updated_at' => date('Y-m-d H:i:s')
			);
			if (!empty($state_id)) :
				DB::table('agents_state')->where(array('state_id' => $state_id))->update($data_arr);
				return Redirect::back()->with('success', 'State has been updated successfully.');
			else :
				$data_arr['created_at'] = date('Y-m-d H:i:s');
				DB::table('agents_state')->insertGetId($data_arr);
				return Redirect::back()->with('success', 'State has been created successfully.');
			endif;

			return Redirect::back()->with('dbError', 'Oops Something went wrong !!');
		endif;
	}

	/* For  date and time */
	public function mmddyyy($date = Null)
	{
		$formate = "";
		if (!empty($date) && $date != "0000-00-00 00:00:00") :
			$formate = date('M d Y', strtotime($date));
		endif;
		return $formate;
	}

	/* Get state info for state lsit */
	public function getStateList()
	{

		$state = new State;
		$list = $state->getStateList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
		$data = array();
		$no = $_REQUEST['start'];
		foreach ($list['result'] as $result) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = isset($result->state_name) ? ucwords(strtolower($result->state_name)) : '';
			$row[] = isset($result->state_code) ? strtoupper($result->state_code) : '';
			$row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';
			$row[] =  '<a class="btn btn-success" href="state/' . $result->state_id . '">
						<i class="fa fa-pencil fa-xs"></i></a>
						<button class="btn btn-danger" onClick ="confirm_function(\'' . $result->state_id . '\',\'Are you sure want to delete this record ? \');">
						<i class="fa fa-trash-o fa-xs"></i></button>';
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

	/* For delete state */
	public function deleteState(Request $request)
	{

		$id = $request->input('id');
		$tag = $request->input('tag');
		if (!empty($id)) {
			if ($tag == 'Delete') :
				DB::table('agents_state')->where(array('state_id' => $id))->update(array('is_deleted' => '1'));
			elseif ($tag == 'status') :

			endif;
		}
	}
}
