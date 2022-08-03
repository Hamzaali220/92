<?php

namespace App\Http\Controllers\Administrator;

use App\Events\eventTrigger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\QuestionAnswers;
use App\Models\Survey;
use App\Models\Shared;
use App\Models\Notification;
use App\Models\Bookmark;
use App\Models\Rating;
use App\Models\Importance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class QuestionAnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('admin.pages.questionanswer.questionanswerlist');
    }

    /* For get question answers list details */
    public function getQuestionAnswersList()
    {

        $queansw = new QuestionAnswers;
        $list = $queansw->getQuestionAnswersList($_REQUEST, $_REQUEST['length'], $_REQUEST['start']);
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($list['result'] as $result) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = isset($result->question) ? ucwords(strtolower($result->question)) : '';
            $row[] = isset($result->role_name) ? ucwords(strtolower($result->role_name)) : '';
            $row[] = isset($result->survey) && $result->survey == 1 ? 'Yes' : 'No';
            $row[] = isset($result->created_at) ? $this->mmddyyy($result->created_at) : '';

            $row[] =
                '<a class="btn btn-info" href="' . url("/agentadmin/questionviewwithanswer/") . '/' . $result->question_id . '">    View</a>
                    <a class="btn btn-success" href="' . url("/agentadmin/questionanswers/") . '/' . $result->question_id . '">Edit</a>
                    <button class="btn btn-danger" onClick ="confirm_function(\'' . $result->question_id . '\',\'Are you sure, you want to delete this record?\');">Delete</button>';
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

    /* For delete question answers */
    public function deleteQuestionAnswers(Request $request)
    {

        $id = $request->input('id');
        $tag = $request->input('tag');
        if (!empty($id)) {
            if ($tag == 'Delete') :
                DB::table('agents_question')->where(array('question_id' => $id))->update(array('is_deleted' => '1'));
            elseif ($tag == 'status') :

            endif;
        }
    }

    /* For get date and time */
    public function mmddyyy($date = Null)
    {
        $formate = "";
        if (!empty($date) && $date != "0000-00-00 00:00:00") :
            $formate = date('M d Y', strtotime($date));
        endif;
        return $formate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function questioneditadd($id = null)
    {
        $queansw = new QuestionAnswers;
        $view = array();
        if (!empty($id)) :
            $view['question'] = $queansw->getQuestionsingalByAny(array('question_id' => $id));
            $view['tag'] = 'Edit';
            $view['id'] = $id;
        else :
            $view['id'] = '';
            $view['question'] = '';
            $view['tag'] = 'Add';
        endif;
        return view('admin.pages.questionanswer.questionanswer', $view);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $where = $update = array();
        $rules = array(
            'question'              => 'required',
            'question_type'              => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) :
            return Redirect::back()->withErrors($validator)->withInput();
        endif;

        if (!empty($request->input('question_id'))) {
            $QuestionAnswers                =  QuestionAnswers::find($request->input('question_id'));
        } else {
            $QuestionAnswers                = new QuestionAnswers;
        }
        $QuestionAnswers->question      = $request->input('question');
        $QuestionAnswers->question_type =  $request->input('question_type');
        $QuestionAnswers->add_by        =  $request->input('add_by');
        $QuestionAnswers->add_by_role   =  $request->input('add_by_role');
        $QuestionAnswers->updated_at    =  Carbon::now()->toDateTimeString();

        if ($request->input('survey')) {

            $QuestionAnswers->survey        =  $request->input('survey');
        } else {

            $QuestionAnswers->survey        =  '0';
        }
        if ($request->input('importance1')) {

            $QuestionAnswers->importance    =  $request->input('importance1');
        } else {

            $QuestionAnswers->importance    =  '0';
        }
        $QuestionAnswers->save();
        $result                                  =   $QuestionAnswers;

        $qid = $result->question_id;
        if ($request->input('survey') == 1) {

            $Survey = new Survey();
            $acheck = $Survey->getSurveySingalByAny(array('question_id' => $qid, 'agents_user_id' => $request->input('add_by'), 'agents_users_role_id' => $request->input('add_by_role')));
            if (!empty($acheck)) {
                $bookbarkupdate                         =  Survey::find($acheck->survey_id);
                $bookbarkupdate->question_id            = $qid;
                $bookbarkupdate->agents_user_id         = $request->input('add_by');
                $bookbarkupdate->agents_users_role_id   = $request->input('add_by_role');
                $bookbarkupdate->updated_at             =  Carbon::now()->toDateTimeString();
                $bookbarkupdate->save();
                $result                                 =   $bookbarkupdate;
            } else {
                $Survey->question_id                    = $qid;
                $Survey->agents_user_id                 = $request->input('add_by');
                $Survey->agents_users_role_id           = $request->input('add_by_role');
                $Survey->updated_at                     =  Carbon::now()->toDateTimeString();
                $Survey->save();
                $result                                 =   $Survey;
            }
        } else {
            DB::table('agents_survey')->where('question_id', $qid)->delete();
        }
        if (!empty($request->input('question_id'))) {

            return Redirect::back()->with('success', 'Question has been updated successfully.');
        } else {
            return Redirect::back()->with('success', 'Question has been created successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($question_id = null)
    {
        $answers = array();
        $question = new QuestionAnswers;
        $result = $question->getQuestionsingalByAny(array('is_deleted' => '0', 'question_id' => $question_id));
        $ans = $question->getDetailsAnswerswithuserByAny(array('a.is_deleted' => '0', 'a.question_id' => $result->question_id));

        $view['question'] = $result;
        $view['answers'] = $ans;
        return view('admin.pages.questionanswer.questionanswerview', $view);
    }
}
