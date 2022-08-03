<?php

namespace App\Http\Controllers\Administrator\Agents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Userdetails;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Stripe\Stripe;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /* For applied post for agents */
    public function agentSelectedPosts()
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            return view('dashboard.user.agents.agentselectedpost', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }

    /* For applied post for agents */
    public function agentSelectedAllPosts()
    {
        $post =  new Post;
        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $view['all_posts'] = $post->getAppliedPostsDataBySelectedAgent($user->id);
            return view('dashboard.user.agents.agent_all_post', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }


    public function agentSelectedPostsAjx($limit, $userid, $roleid, $user_role_id = null)
    {

        $post = new Post();
        $where_selected = array(
            'agents_posts.applied_user_id' => $userid
        );

        if ($user_role_id != null) {
            $where_selected['agents_posts.agents_users_role_id'] =  $user_role_id;
        }
        $result = $post->SelectedPostListGetForAgents($limit, $where_selected, 1);
        return response()->json($result);
    }

    public function validatepaymentamount(Request $request)
    {
        if ($request->exists('id')) {
            $paymentDataTemp = Session::get('paymentData');
            $paymentData = $paymentDataTemp[0];
            $stripe = new Stripe('sk_test_yRZidact2uyiVpwIRpl7e32L');
            $cardId = $request->input('card');
            $amount = (int)$paymentData['amount'];
            try {
                $charge = $stripe->charges()->create([
                    'amount' =>  $amount,
                    'currency' => 'usd',
                    'description' => '3% Agent Charges paying to agent',
                    'source' => $request->input('id'),
                ]);
                if ($charge['status'] == 'succeeded') {

                    $transactionId = strtotime(date("d-m-y h:i:s")) . $request->input('post_id') . Auth::user()->id . rand(00000, 99999);
                    //echo $paymentData['post_id'];exit;
                    $paymentDetails = array(
                        'amount' => $amount,
                        'discount' => 0.00,
                        'taxes' => 0.00,
                        'payment' => 'Stripe',
                        'post_id' => $paymentData['post_id'],
                        'user_id' => Auth::user()->id,
                        'transaction_id' => $transactionId,
                        'stripe_order_no' => $charge['id'],
                        'created_at' => date("Y-m-d h:i:s"),
                        'updated_at' => date("Y-m-d h:i:s")
                    );
                    $notificationDetails = array(
                        'sender_id' => $paymentData['sender_id'],
                        'sender_role' => $paymentData['sender_role'],
                        'receiver_id' => $paymentData['receiver_id'],
                        'receiver_role' => $paymentData['receiver_role'],
                        'notification_type' => 16,
                        'notification_message' => $paymentData['amount'] . '$ amount has been sent.',
                        'notification_post_id' => $paymentData['post_id'],
                        'show' => 1
                    );
                    if (DB::table('agents_payment')->insert($paymentDetails)) {
                        DB::table('agents_posts')->where('post_id', $paymentData['post_id'])->update(['agent_payment' => 'completed']);
                        $result = DB::table('agents_notification')->insert($notificationDetails);
                        //print_r($result);exit;
                        $data = array('status' => 1, 'msg' => '$' . $paymentData['amount'] . ' amount has been sent to agent successfully.');
                        Session::forget('paymentData');
                        return response()->json($data);
                    } else {
                        $data = array(
                            'status' => 1,
                            'msg' => $paymentData['amount'] . '$ amount has been sent.'
                        );
                        Session::forget('paymentData');
                        return response()->json($data);
                    }
                } else {
                    $data = array('status' => 0, 'msg' => 'Payment Failed because of some internal error.');
                    Session::forget('paymentData');
                    return response()->json($data);
                }
            } catch (\Exception $e) {
                $data = array('status' => 0, 'msg' => 'Payment Failed because of some internal error.');
                Session::forget('paymentData');
                return response()->json($data);
            }
        }

        $rules = array('amount'    => 'required|regex:^[1-9]\d*(\.\d+)?$^',);
        $validator = Validator::make(array('amount' => $request->input('amount'),), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $this->amount = $request->input('amount');
            Session::push('paymentData', $request->input());
            return response()->json(["status" => 2, "msg" => "You can make payment."]);
        }
    }
}
