<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Userdetails;
use App\Models\Survey;
use App\Models\QuestionAnswers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buyersindex()
    {
        $view = array();
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        return view('dashboard.user.buyers.survey', $view);
    }

    /* For agents survey view */
    public function agentsindex()
    {
        $view = array();
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        return view('dashboard.user.agents.survey', $view);
    }

    /* Get limited data by any */
    public function getLimitedDataByAny($limit = null, $agents_user_id = null, $agents_users_role_id = null)
    {
        $import = new Survey;
        $result = $import->getDetailsByAny($limit, array('agents_question.survey' => '1', 'agents_survey.is_deleted' => '0', 'agents_survey.agents_user_id' => $agents_user_id, 'agents_survey.agents_users_role_id' => $agents_users_role_id));
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

            $QuestionAnswers = QuestionAnswers::find($request->input('question_id'));
            $QuestionAnswers->survey = '1';
            $QuestionAnswers->updated_at = Carbon::now()->toDateTimeString();
            $QuestionAnswers->save();

            $import = new Survey;
            if ($import->inserupdate(array('question_id' => $request->input('question_id'), 'agents_user_id' => $request->input('agents_user_id'), 'agents_users_role_id' => $request->input('agents_users_role_id')))) {

                return response()->json(["status" => 'success', "msg" => "Survey Question has been added successfully"]);
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
    public function removeservaylistquestion(Request $request)
    {
        DB::table('agents_survey')->where(array('question_id' => $request->input('question_id'), 'agents_user_id' => $request->input('add_by'), 'agents_users_role_id' => $request->input('add_by_role')))->delete();
        $QuestionAnswers = QuestionAnswers::find($request->input('question_id'));
        $QuestionAnswers->survey = '0';
        $QuestionAnswers->updated_at = Carbon::now()->toDateTimeString();
        $QuestionAnswers->save();
        return response()->json(["status" => 'success', "msg" => "Your Survey Question is deleted successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $survey = Survey::find($id);
        $QuestionAnswers = QuestionAnswers::find($survey->question_id);
        $QuestionAnswers->survey = '0';
        $QuestionAnswers->updated_at = Carbon::now()->toDateTimeString();
        $QuestionAnswers->save();
        DB::table('agents_survey')->where('survey_id', $id)->delete();
        return response()->json(["status" => 'success', "msg" => "Your Survey Question is deleted successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function SurvayLoopQuestion(Request $request)
    {
        $Survey = new Survey;
        $where = array(
            'agents_users_conections.to_id'     => Auth::user()->id,
            'agents_users_conections.to_role'   => Auth::user()->agents_users_role_id,
        );
        $orwhere = array(
            'agents_users_conections.from_id'   => Auth::user()->id,
            'agents_users_conections.from_role' => Auth::user()->agents_users_role_id,
        );
        $result = $Survey->getSurvayLoopQuestionByAny($where, $orwhere);
        return response()->json($result);
    }
}
