<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Proposals;
use App\Models\Shared;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuinate\Support\Facades\Redirect;
use Carbon\Carbon;

class ProposalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->file('data'));
        // die;
        if (empty($request->input('id'))) {
            $rules = array(

                'proposals_title'         => 'required',

                'type'                    => 'required',

            );

            $validator = Validator::make($request->all(), $rules, ['proposal_file' => 'Proposal should be less then 2MB.']);

            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors()]);
            }

            if ($request->input('type') == 1) {
                $rules = array(
                    'proposal_file'           => 'required|mimes:jpeg,jpg,png,doc,pdf,docx|max:15360',
                );
            } else {
                $rules = array(
                    'proposals_html'           => 'required',
                );
            }
            $validator = Validator::make($request->all(), $rules, ['proposal_file.max' => 'Proposal should be less then 15MB.', 'proposal_file.required' => 'Please upload file']);
            if ($validator->fails()) {
                return response()->json(['status' => '101', $validator->errors()]);
            }
            $postdetailsnew = array();


            $filepath = '';
            if ($request->input('type') == 1) {

                $image = $request->file('proposal_file');

                $filename = time() . '.' . $image->getClientOriginalExtension();

                $destinationPath = public_path('assets/img/proposale/');

                $image->move($destinationPath, $filename);

                $filepath = url("assets/img/proposale/" . $filename);
            } else if ($request->input('type') == 2 && !empty($request->file('data'))) {

                $image = $request->file('data');

                $filename = time() . '.pdf';

                $destinationPath = public_path('assets/img/proposale/');

                $image->move($destinationPath, $filename);

                $filepath = url("assets/img/proposale/" . $filename);

                $postdetailsnew['proposals_html'] = $request->input('proposals_html');
            }

            $postdetailsnew['agents_user_id'] = $request->input('agents_user_id');

            $postdetailsnew['agents_users_role_id'] = $request->input('agents_users_role_id');

            $postdetailsnew['proposals_title'] = $request->input('proposals_title');

            $postdetailsnew['type'] = $request->input('type');

            $postdetailsnew['proposals_attachments'] = $filepath;

            $proposals = new Proposals;

            $re = $proposals->inserupdate($postdetailsnew);
        } else {

            $rules = array(

                'proposals_title'     =>     'required',

                'type'                    => 'required',

            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return response()->json(['status' => '101', 'error' => $validator->errors()]);
            }

            $proposals = Proposals::find($request->input('id'));

            if ($request->input('type') == 1) {

                if (!empty($request->file('proposal_file'))) {

                    $atachpath = str_replace(url('/') . '/', '', $proposals->proposals_attachments);

                    File::delete($atachpath);

                    $image = $request->file('proposal_file');

                    $filename = time() . '.' . $image->getClientOriginalExtension();

                    $destinationPath = public_path('assets/img/proposale/');

                    $image->move($destinationPath, $filename);

                    $filepath = url("assets/img/proposale/" . $filename);

                    $proposals->proposals_attachments = $filepath;
                }
            } else {

                if (!empty($request->file('data'))) {

                    $atachpath = str_replace(url('/') . '/', '', $proposals->proposals_attachments);

                    File::delete($atachpath);

                    $image = $request->file('data');

                    $filename = time() . '.pdf';

                    $destinationPath = public_path('assets/img/proposale/');

                    $image->move($destinationPath, $filename);

                    $filepath = url("assets/img/proposale/" . $filename);

                    $proposals->proposals_attachments = $filepath;
                }

                $proposals->proposals_html = $request->input('proposals_html');
            }

            $proposals->proposals_title = $request->input('proposals_title');

            $proposals->type = $request->input('type');

            $proposals->updated_at = Carbon::now()->toDateTimeString();

            $re = $proposals->save();
        }

        if ($re) {

            return response()->json(['status' => '100', "response" => "Your Proposals successfully Upload!"]);
        } else {

            return response()->json(["status" => "101", "error"  => " Please try again in a few minutes."]);
        }
    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($limit, $userid, $role)
    {
        $proposals = new Proposals;

        $result = $proposals->getDetailsByAny($limit, array('is_deleted' => '0', 'agents_user_id' => $userid, 'agents_users_role_id' => $role));

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function showten($limit, $userid, $role)
    {
        $proposals = new Proposals;

        $result = $proposals->gettenDetailsByAny($limit, array('is_deleted' => '0', 'agents_user_id' => $userid, 'agents_users_role_id' => $role));

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getproposalwithshared(Request $request, $limit)
    {
        $sproposal = array();

        $proposals = new Proposals;

        $shared = new Shared;

        $result = $proposals->getDetailsByAny($limit, array('is_deleted' => '0', 'agents_user_id' => $request->input('sender_id'), 'agents_users_role_id' => $request->input('sender_role')));

        foreach ($result['result'] as $value) {

            $aa['shared_type']          = 3;

            $aa['shared_item_id']       = $value->proposals_id;

            $aa['shared_item_type']     = $request->input('shared_item_type');

            $aa['shared_item_type_id']  = $request->input('post_id');

            $aa['sender_id']            = $request->input('sender_id');

            $aa['sender_role']          = $request->input('sender_role');

            $aa['receiver_id']          = $request->input('receiver_id');

            $aa['receiver_role']        = $request->input('receiver_role');

            $ss = $shared->getsinglerowByAny($aa);

            if (empty($ss)) {

                $sproposal[$value->proposals_id] = '';
            } else {

                $sproposal[$value->proposals_id] = $ss;
            }
        }

        return response()->json(array($result, $sproposal));
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

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function delete(Request $request)

    {

        $proposals = Proposals::find($request->input('proposal_id'));

        $proposals->is_deleted = '1';

        if ($proposals->save()) {

            return response()->json(["status" => '100', "response" => "Your Proposals successfully Delete!"]);
        } else {

            return response()->json(["status" => '101', "error" => 'Please try again in a few minutes.']);
        }
    }
}
