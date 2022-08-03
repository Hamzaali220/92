<?php

namespace App\Http\Controllers\Administrator\Compare;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Compare;
use App\Models\User;
use App\Models\Shared;
use App\Models\Userdetails;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class CompareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()) {
            $compare = new Compare;
            if (!empty($request->input('compare_id'))) {
                $sataging = array(
                    'asked_question' => $request->input('asked_question') != '' ? $request->input('asked_question') : '',
                    'bookmark_agents' => $request->input('bookmark_agents') != '' ? $request->input('bookmark_agents') : '',
                    'bookmark_answers' => $request->input('bookmark_answers') != '' ? $request->input('bookmark_answers') : '',
                    'bookmark_messages' => $request->input('bookmark_messages') != '' ? $request->input('bookmark_messages') : '',
                    'bookmark_proposal' => $request->input('bookmark_proposal') != '' ? $request->input('bookmark_proposal') : '',
                    'rating_answers' => $request->input('rating_answers') != '' ? $request->input('rating_answers') : '',
                    'rating_messages' => $request->input('rating_messages') != '' ? $request->input('rating_messages') : '',
                    'proposals' => $request->input('proposals') != '' ? $request->input('proposals') : '',
                    'documents' => $request->input('documents') != '' ? $request->input('documents') : '',
                    'notes_messages' => $request->input('notes_messages') != '' ? $request->input('notes_messages') : '',
                    'notes_asked_question' => $request->input('notes_asked_question') != '' ? $request->input('notes_asked_question') : '',
                    'notes_answers' => $request->input('notes_answers') != '' ? $request->input('notes_answers') : '',
                    'notes_proposal' => $request->input('notes_proposal') != '' ? $request->input('notes_proposal') : '',
                    'notes_agents' => $request->input('notes_agents') != '' ? $request->input('notes_agents') : '',
                    'asked_question_list' => $request->input('asked_question_list') != '' ? $request->input('asked_question_list') : '',
                    'asked_question_text' => $request->input('asked_question_text') != '' && $request->input('asked_question_list') != '' ? array_intersect_key($request->input('asked_question_text'), $request->input('asked_question_list')) : '',
                );

                $compare_json = json_encode($sataging);
                $compare->inserupdate(array('compare_json' => $compare_json), array('compare_id' => $request->input('compare_id')));
                $postdata = $request->all();
                Session::put('comparedata',  $postdata);
                Session::put('sataging',  $sataging);
            } else {
                $postdata = Session::has('comparedata') ? Session::get('comparedata') : '';
                $sataging = Session::has('sataging') ? Session::get('sataging') : '';
            }

            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['sataging'] = $sataging;
            $view['result'] = $compare->getcomparragenstlist($postdata);
            $userdetails = new Userdetails;
            $certifications = $userdetails->getCertificationsByAny();
            $certificationsarray = [];
            foreach ($certifications as $key => $value) {
                $certificationsarray[$value->certifications_id] = $value->certifications_name;
            }
            $view['certifications'] = $certificationsarray;

            $specialization = $userdetails->getSpecializationByAny();
            $specializationarray = [];
            foreach ($specialization as $key => $value) {
                $specializationarray[$value->skill_id] = $value->skill;
            }
            $view['specialization'] = $specializationarray;

            $franchise = $userdetails->getFranchiseByAny();
            $franchisearray = [];
            foreach ($franchise as $key => $value) {
                $franchisearray[$value->franchise_id] = $value->franchise_name;
            }
            $view['franchise'] = $franchisearray;

            return view('dashboard.user.compare.compare', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $update = array();
        $update['post_id']              =   $request->input('post_id');
        $update['sender_id']            =   Auth::user()->id;
        $update['sender_role']          =   Auth::user()->agents_users_role_id;

        $compare = new Compare;
        $acheck = $compare->getCompareSingalByAny($update);
        $update['compare_item_id']      =   $request->input('compare_item_id');
        if (!empty($acheck)) {
            if (empty($compare->checkcompareintableagents($update))) {

                if ($acheck->compare_item_id != '') {
                    $countcompareitem = explode(',', $acheck->compare_item_id);
                    if (count($countcompareitem) < 5) {

                        $compare_item_id = rtrim(($acheck->compare_item_id != '' ? $acheck->compare_item_id . ',' : '') . ($update['compare_item_id']), ',');
                    } else {
                        $countcompareitem = array_pop($countcompareitem);
                        $compare_item_id = rtrim($update['compare_item_id'] . ',' . implode(',', $countcompareitem), ',');
                    }
                } else {
                    $compare_item_id = $update['compare_item_id'];
                }

                $bookbarkupdate                         =  Compare::find($acheck->compare_id);
                $bookbarkupdate->post_id                =  $update['post_id'];
                $bookbarkupdate->compare_item_id        =  $compare_item_id;
                $bookbarkupdate->sender_id              =  $update['sender_id'];
                $bookbarkupdate->sender_role            =  $update['sender_role'];
                $bookbarkupdate->updated_at             =  Carbon::now()->toDateTimeString();
                $bookbarkupdate->save();
                $result                                 =   $bookbarkupdate->compare_id;
            } else {
                $result =  $acheck->compare_id;
            }
        } else {
            $compare->post_id                       =   $request->input('post_id');
            $compare->compare_item_id               =   $update['compare_item_id'];
            $compare->sender_id                     =   $update['sender_id'];
            $compare->sender_role                   =   $update['sender_role'];
            $compare->updated_at                    =   Carbon::now()->toDateTimeString();
            $compare->save();
            $result                                 =   $compare->compare_id;
        }
        return response()->json(['data' => $result]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compare  $compare
     * @return \Illuminate\Http\Response
     */
    public function show($limit, $userid = null, $role = null, $post_id = null)
    {
        $compare = new Compare;
        $result = $compare->getDetailsByAny($limit, array('agents_compare.post_id' => $post_id, 'agents_compare.sender_id' => $userid, 'agents_compare.sender_role' => $role));
        return response()->json($result);
    }

    /**
     * Show ComparedDataGetByPost
     */
    public function ComparedDataGetByPost($post_id = null, $sender_id = null, $sender_role = null)
    {
        $update = array();
        $update['post_id']              =   $post_id;
        $update['sender_id']            =   $sender_id;
        $update['sender_role']          =   $sender_role;

        $compare = new Compare;
        $comparedata = $compare->getCompareSingalByAny($update);
        $askedquestiondata = [];
        if (!empty($comparedata)) {
            $sharedquestion = $compare->GetAskedQuestion(
                array(
                    'agents_shared.shared_type' => '1',
                    'agents_shared.shared_item_type' => '2',
                    'agents_shared.shared_item_type_id' => $post_id,
                    'agents_shared.sender_id' => $sender_id,
                    'agents_shared.sender_role' => $sender_role,
                    'agents_shared.receiver_role' => '4',
                    'agents_question.is_deleted' => '0',
                ),
                array('colume' => 'agents_shared.receiver_id', 'value' => explode(',', $comparedata->compare_item_id))
            );
            foreach ($sharedquestion as $key => $value) {
                $askedquestion = array('asked' => '');
                if ($comparedata->compare_json != null) {
                    $jsondata = json_decode($comparedata->compare_json);
                    if ($jsondata->asked_question == 1 && !empty($jsondata->asked_question_list)) {
                        $jsak = (array) $jsondata->asked_question_list;
                        shuffle($jsak);
                        $asked = @in_array($value->question_id, $jsak) == 1 ? $value->question_id : '';
                        $askedquestion = array('asked' =>  $asked);
                    }
                }
                $askedquestiondata[] = (object) array_merge((array) $value, (array) $askedquestion);
            }
        }
        return response()->json(array('comparedata' => $comparedata, 'askedquestiondata' => $askedquestiondata));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compare  $compare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compare $compare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($compare_id, $user_id)
    {
        $update = array();
        $update['compare_id']              =   $compare_id;
        $compare = new Compare;
        $acheck = $compare->getCompareSingalByAny($update);
        if (!empty($acheck)) {
            $bookbarkupdate                         =  Compare::find($acheck->compare_id);
            $bookbarkupdate->compare_item_id        =  $this->removeItemString($acheck->compare_item_id, $user_id);
            // $bookbarkupdate->compare_item_role_id   =  $this->removeItemString($acheck->compare_item_role_id,$user_roleid);
            $bookbarkupdate->updated_at             =  Carbon::now()->toDateTimeString();
            $bookbarkupdate->save();
            $result                                 =   $bookbarkupdate->compare_id;
        }
        return response()->json(['data' => $result]);
    }
    public function removeItemString($str, $item)
    {
        $parts = explode(',', $str);
        while (($i = array_search($item, $parts)) !== false) {
            unset($parts[$i]);
        }
        return implode(',', $parts);
    }
}
