<?php

namespace App\Http\Controllers\Administrator\Buyer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Userdetails;
use App\Models\Importance;
use App\Models\QuestionAnswers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ImportanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = array();
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        // $view['editfield'] = '<a class="profile-edit-button field-edit"><i class="fa fa-pencil"></i></a>';
        return view('dashboard.user.buyers.importance', $view);
    }

    public function getLimitedDataByAny(Request $request, $limit = null, $agents_user_id = null, $agents_users_role_id = null)
    {
        $import = new Importance;
        $result = $import->getDetailsByAny($limit, array('agents_importance.is_deleted' => '0', 'agents_importance.agents_user_id' => $agents_user_id, 'agents_importance.agents_users_role_id' => $agents_users_role_id));
        return  response()->json($result);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->all() != '') {

            $QuestionAnswers = QuestionAnswers::find($request->input('importance_item_id'));
            $QuestionAnswers->importance = '1';
            $QuestionAnswers->updated_at = Carbon::now()->toDateTimeString();
            $QuestionAnswers->save();

            $import = new Importance;
            if ($import->inserupdate(array('importance_item_id' => $request->input('importance_item_id'), 'importance_type' => $request->input('importance_type'), 'agents_user_id' => $request->input('agents_user_id'), 'agents_users_role_id' => $request->input('agents_users_role_id')))) {

                return response()->json(["status" => 'success', "msg" => "Your Question Importance successfully!"]);
            } else {

                return response()->json(["status" => 'error', "msg" => 'Please try again in a few minutes.']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeimportancelistquestion(Request $request)
    {
        DB::table('agents_importance')->where(array('importance_type' => '1', 'importance_item_id' => $request->input('question_id'), 'agents_user_id' => $request->input('add_by'), 'agents_users_role_id' => $request->input('add_by_role')))->delete();
        $QuestionAnswers = QuestionAnswers::find($request->input('question_id'));
        $QuestionAnswers->importance = '0';
        $QuestionAnswers->updated_at = Carbon::now()->toDateTimeString();
        $QuestionAnswers->save();        //echo '<pre>'; print_r($QuestionAnswers); die;
        return response()->json(["status" => 'success', "msg" => "Your Question has been removed from Important List"]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Importance = Importance::find($id);
        $QuestionAnswers = QuestionAnswers::find($Importance->importance_item_id);
        $QuestionAnswers->importance = '0';
        $QuestionAnswers->updated_at = Carbon::now()->toDateTimeString();
        $QuestionAnswers->save();
        DB::table('agents_importance')->where('importance_id', $id)->delete();
        return response()->json(["status" => 'success', "msg" => "Your Question has been removed from Important List"]);
    }
}
