<?php

namespace App\Http\Controllers\Administrator\Buyer;

use App\Events\eventTrigger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Post;
use App\Models\State;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Cartalyst\Stripe\Stripe;
use Illuminate\Broadcasting\BroadcastException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * For my jobs view */
    public function index()
    {
        $view = array();
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        $view['whendoyouwanttosell'] = $this->whenDoYouWantToSell();
        $view['homeType']  = $this->homeType();

        # access square ad spaces
        $square_ads = DB::table('agents_advertise as ap')
            ->join('agents_package as pa', 'ap.package_id', '=', 'pa.package_id')
            ->select('ap.id', 'ap.ad_link', 'ap.ad_banner', 'ap.ad_content', 'pa.image', 'pa.content')
            ->where(['ap.status' => 1, 'pa.type' => 'SQUARE'])
            ->get();
        $view['square_ads'] = $square_ads;

        return view('dashboard.user.buyers.post', $view);
    }


    public function validatepaymentamount(Request $request)
    {
        if ($request->exists('id')) {
            $paymentDataTemp = Session::get('paymentData');
            $paymentData = $paymentDataTemp[0];
            $stripe = new Stripe('sk_test_51Hso8eG631bdjDJFSCuMDFppsnwqfyX4JrYkoetLjz80L3XASjA7A8FieEBYZcETPOjaFTEgqOwfvL5ifSDXdtl600WOjgKSYz');
            $cardId = $request->input('card');
            $amount = $paymentData['amount'];
            try {

                $post_id = $paymentData['post_id'];
                if (strpos($post_id, ",") === false) {
                    $post = new Post();
                    $post_sell_details = $post->getSellDetails($post_id, Auth::user()->id);
                    if (isset($post_sell_details[0])) {
                        $sell_details = $post_sell_details[0];

                        $agent_comission = $sell_details->agent_comission;
                        $commission_rate = $sell_details->comission_92agent;
                        $agent_commission_amount = (($agent_comission / 100) * $sell_details->sale_price);
                        $our_commision = (($commission_rate / 100) * $agent_commission_amount);

                        $our_commision = number_format((float)$our_commision, 2, '.', '');

                        if ($amount != (string)$our_commision) {
                            $data = array('status' => 0, 'msg' => 'Payment Failed because of wrong payment amount.');
                            Session::forget('paymentData');
                            return response()->json($data);
                        }
                    } else {
                        $data = array('status' => 0, 'msg' => 'Payment Failed because of wrong data.');
                        Session::forget('paymentData');
                        return response()->json($data);
                    }

                    $charge = $stripe->charges()->create([
                        'amount' =>  $amount,
                        'currency' => 'usd',
                        'description' => $commission_rate . '% Agent Charges paying to agent',
                        'source' => $request->input('id'),
                    ]);

                    if ($charge['status'] == 'succeeded') {

                        $transactionId = strtotime(date("d-m-y h:i:s")) . $request->input('post_id') . Auth::user()->id . rand(00000, 99999);
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
                        if (DB::table('agents_payment')->insert($paymentDetails)) {
                            DB::table('agents_posts')->where('post_id', $paymentData['post_id'])->update(['agent_payment' => 'completed']);
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
                } else {
                    $post_id_arr = explode(',', $post_id);

                    $post = new Post();
                    $total_amount = 0;
                    foreach ($post_id_arr as $post_id) {
                        $post_sell_details = $post->getSellDetails($post_id, Auth::user()->id);
                        if (isset($post_sell_details[0])) {
                            $sell_details = $post_sell_details[0];

                            $agent_comission = $sell_details->agent_comission;
                            $commission_rate = $sell_details->comission_92agent;
                            $agent_commission_amount = (($agent_comission / 100) * $sell_details->sale_price);
                            $our_commision = (($commission_rate / 100) * $agent_commission_amount);
                            $total_amount += $our_commision;
                        } else {
                            // mail for wrong data
                        }
                    }

                    $total_amount = number_format((float)$total_amount, 2, '.', '');

                    if ($amount != (string)$total_amount) {
                        $data = array('status' => 0, 'msg' => 'Payment Failed because of wrong payment amount.');
                        Session::forget('paymentData');
                        return response()->json($data);
                    }


                    $charge = $stripe->charges()->create([
                        'amount' =>  $amount,
                        'currency' => 'usd',
                        'description' => 'Agent Charges paying to 92agent',
                        'source' => $request->input('id'),
                    ]);

                    if ($charge['status'] == 'succeeded') {

                        $transactionId = strtotime(date("d-m-y h:i:s")) . Auth::user()->id . rand(00000, 99999);
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
                        if (DB::table('agents_payment')->insert($paymentDetails)) {
                            foreach ($post_id_arr as $post_id) {
                                $update = DB::table('agents_posts')->where('post_id', $post_id)->update(['agent_payment' => 'completed']);
                            }


                            $data = array('status' => 1, 'msg' => '$' . $paymentData['amount'] . ' amount has been sent to agent successfully.');
                            Session::forget('paymentData');
                            return response()->json($data);
                        } else {
                            $data = array('status' => 0, 'msg' => 'Payment Failed because of some internal error.');
                            Session::forget('paymentData');
                            return response()->json($data);
                        }
                    } else {

                        $data = array('status' => 0, 'msg' => 'Payment Failed because of some internal error.');
                        Session::forget('paymentData');
                        return response()->json($data);
                    }
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

    /* For compare post */
    public function ComparePost()
    {
        $view = array();
        $view['user'] = $user = Auth::user();
        $view['userdetails'] = $userdetails = Userdetails::find($user->id);
        return view('dashboard.user.buyers.compareposts', $view);
    }

    /* For post details for buyers only */
    public function PostDetailsForBuyer($post_id = null, $compare = null)
    {

        if (Auth::user()) {
            $view = array();
            $view['user'] = $user = Auth::user();
            $view['userdetails'] = $userdetails = Userdetails::find($user->id);
            $state = new State;
            $view['city']  =  $state->getCityByAny(array('city_id' => $view['userdetails']->city_id, 'is_deleted' => '0'), 'first');
            $post = new Post;
            $view['post'] = $post->getDetailsBypostid(array(
                'agents_posts.post_id' => $post_id,
                'agents_posts.status' => '1'
            ));
            //echo '<pre>'; print_r($view['userdetails']); die;
            if ($view['post']->agents_users_role_id == 2) {
                $view['types'] = 'Buy';
            } else {
                $view['types'] = 'Sell';
            }

            $view['selecteagent'] = '';
            if ($view['post']->applied_post == 1) {
                $view['selecteagent'] = $post->getSelectedDetailsByAny(0, array('agents_posts.post_id' => $view['post']->post_id), 'first');
                //dd($view['post']);
                $getAppliedPostsBySelectedAgent = $post->getAppliedPostsBySelectedAgent($view['selecteagent']->applied_user_id);
                if ($getAppliedPostsBySelectedAgent > 5 && $view['post']->agent_payment != 'completed' && $view['post']->closing_date != '') {
                    $view['agentPaymentStatus'] = true;
                } else {
                    $view['agentPaymentStatus'] = false;
                }
            }
            $view['compare'] = $compare;
            //dd($view);



            # access square ad spaces
            $square_ads = DB::table('agents_advertise as ap')
                ->join('agents_package as pa', 'ap.package_id', '=', 'pa.package_id')
                ->select('ap.id', 'ap.ad_link', 'ap.ad_banner', 'ap.ad_content', 'pa.image', 'pa.content')
                ->where(['ap.status' => 1, 'pa.type' => 'SQUARE'])
                ->get();
            $view['square_ads'] = $square_ads;

            if ($user->agents_users_role_id == 4) {
                $view['pagetype'] = 'post';
            } else {
                $view['pagetype'] = 'agents';
            }

            /*echo "<pre>";
            print_r($view);
            exit;*/

            # notes history
            $notes_history = DB::table('agents_notes')
                ->select('*')
                ->where(['notes_type' => 5, 'notes_item_parent_id' => $post_id, 'sender_id' => $user->id])
                ->get();
            $view['notes_history'] = $notes_history;

            return view('dashboard.user.buyers.postdetails', $view);
        } else {
            return redirect('/login?usertype=' . env('user_role_' . Auth::user()->agents_users_role_id));
        }
    }



    public function addClosingDate(Request $request)
    {

        $rules = array(
            'closing_date'    => 'required',
        );

        $validator = Validator::make(array(
            'closing_date' => $request->input('closing_date'),
        ), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        } else {
            $post = Post::find($request->input('post_id'));
            $post->closing_date = Carbon::createFromFormat('d/m/Y', $request->input('closing_date'))->format('Y-m-d');
            $post->updated_at    = Carbon::now()->toDateTimeString();
            $postObj = new Post;
            $postDetails = $postObj->getAppliedPostsBySelectedAgent($request->input('agent_id'));
            //echo $postDetails;exit;
            if ($postDetails == '' || $postDetails <= 5) {
                //  $post->agent_payment = 'completed';
                /* Save Payment Data */
                $transactionId = strtotime(date("d-m-y h:i:s")) . $request->input('post_id') . Auth::user()->id . rand(00000, 99999);
                $paymentDetails = array(
                    'amount' => 0.00,
                    'discount' => 0.00,
                    'taxes' => 0.00,
                    'payment' => 'Stripe',
                    'post_id' => $request->input('post_id'),
                    'user_id' => Auth::user()->id,
                    'transaction_id' => $transactionId,
                    'stripe_order_no' => '',
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s")
                );
                DB::table('agents_payment')->insert($paymentDetails);
                /* Save Payment Data */
            }
            if ($post->save()) {
                return response()->json(["statys" => 2, "msg" => "Closing date added successfully."]);
            } else {
                return response()->json(["statys" => 1, "msg" => array('error' => 'Please try again in a few minutes.')]);
            }
        }
    }

    /* For get post details of buyer for agents */
    public function PostDetailsAgentsGetForBuyer($limit, $post_id , $userid, $roleid)

    {

        $post = new Post;

        $result = $post->AppliedAgentsListGetForBuyer($limit, $post_id, $userid, $roleid);

        return response()->json($result);
    }

    /* For post details get for buyers */
    public function PostDetailsAgentsGetForBuyerlimitfive($post_id , $userid, $roleid)

    {

        $post = new Post;

        $result = $post->AppliedAgentsListGetForBuyerlimitfive($post_id, $userid, $roleid);

        return response()->json($result);
    }

    // public function PostDetailsGetForBuyer($limit,$userid,$roleid)

    // {

    //     $post = new Post;

    //     $result = $post->AppliedPostListGetForAgents($limit,array( 'agents_users_conections.to_id' => $userid,'agents_users_conections.to_role' => $roleid ),array( 'agents_users_conections.from_id' => $userid,'agents_users_conections.from_role' => $roleid ) );

    //     return response()->json($result);

    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $sval) {
            $val = (array)$sval;
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = (object)$val;
            }
            $i++;
        }
        return (object)$temp_array;
    }




    public function store(Request $request)
    {

        if ($request->input('post_type') == 3) {

            $rules = array(
                'post_title'               => 'required',
                'details'                  => 'required',
                'address_Line_1'           => 'required',
                'city'                     => 'required',
                'state'                    => 'required',
                'zip'                      => 'required|digits:5|numeric',
                'when_do_you_want_to_sell' => 'required',
                'need_Cash_back'           => 'required',
            );

            $validator = Validator::make($request->all(), $rules, [
                'details.required' => 'The Property Details field is required',
                'zip.required' => 'The Zip Code field is required',
                'when_do_you_want_to_sell.required' => 'When Do You Want To Sell field is required'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

            $postdetailsnew = array();
            $postdetailsnew['posttitle']                           = $request->input('post_title');
            $postdetailsnew['details']                             = $request->input('details');
            $postdetailsnew['address1']                            = $request->input('address_Line_1');
            $postdetailsnew['address2']                            = $request->input('address2');
            $postdetailsnew['city']                                = $request->input('city');
            $postdetailsnew['state']                               = $request->input('state');
            $postdetailsnew['zip']                                 = $request->input('zip');
            $postdetailsnew['when_do_you_want_to_sell']            = $request->input('when_do_you_want_to_sell');
            $postdetailsnew['need_Cash_back']                      = $request->input('need_Cash_back');
            $postdetailsnew['interested_short_sale']               = $request->input('interested_short_sale');
            $postdetailsnew['got_lender_approval_for_short_sale']  = $request->input('got_lender_approval_for_short_sale');
            $postdetailsnew['home_type']                           = $request->input('home_type');
            $postdetailsnew['agents_users_role_id']                = $request->input('agents_users_role_id');
            $postdetailsnew['agents_user_id']                      = $request->input('agents_user_id');

            $words = trim(DB::table('agents_bad_contents')->select('words')->pluck('words')->first());
            if ($words != "") {
                $str = explode(',', $words);
                foreach ($str as $key => $value) {
                    if (preg_match("/$value/", $postdetailsnew['details'])) {
                        return response()->json(['bad' => 'please enter post']);
                    }
                }
            }
            if (!empty($request->input('best_features'))) {
                $emplo = $request->input('best_features');
                $bfa = array();
                !empty($emplo[0]) ? $bfa['best_features_1'] =  $emplo[0] : '';
                !empty($emplo[1]) ? $bfa['best_features_2'] =  $emplo[1] : '';
                !empty($emplo[2]) ? $bfa['best_features_3'] =  $emplo[2] : '';
                !empty($emplo[3]) ? $bfa['best_features_4'] =  $emplo[3] : '';
                !empty($emplo[4]) ? $bfa['best_features_5'] =  $emplo[4] : '';
                $postdetailsnew['best_features'] = json_encode($bfa);
            }
        } else {
            $rules = array(
                'post_title'         => 'required',
                'details'            => 'required',
                'city'               => 'required',
                'state'              => 'required',
                'area'               => 'required',
                'when_u_want_to_buy' => 'required',
                'price_range'        => 'required',
                'home_type'          => 'required',
                'need_Cash_back'     => 'required',
                'zip.*'                => 'required|digits:5|numeric',
            );


            $validator = Validator::make($request->all(), $rules, [
                'details.required' => 'The specific requirements field is required',
                'area.required' => 'The suburb / neighborhood field is required',
                'zip.required' => 'The zip code field is required',
                'home_type.required' => 'The property type field is required'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()]);
            }

            $postdetailsnew = array();
            $postdetailsnew['posttitle']                       = $request->input('post_title');
            $postdetailsnew['details']                         = $request->input('details');
            $postdetailsnew['city']                            = $request->input('city');
            $postdetailsnew['state']                           = $request->input('state');
            $postdetailsnew['area']                            = $request->input('area');
            $postdetailsnew['when_do_you_want_to_sell']        = $request->input('when_u_want_to_buy');
            $postdetailsnew['price_range']                     = $request->input('price_range');
            $postdetailsnew['home_type']                       = $request->input('home_type');
            $postdetailsnew['firsttime_home_buyer']            = $request->input('firsttime_home_buyer') ? $request->input('firsttime_home_buyer') : '0';
            $postdetailsnew['do_u_have_a_home_to_sell']        = $request->input('do_u_have_a_home_to_sell') ? $request->input('do_u_have_a_home_to_sell') : '0';

            $postdetailsnew['if_so_do_you_need_help_selling']  = $request->input('if_so_do_you_need_help_selling') ? $request->input('if_so_do_you_need_help_selling') : '0';
            $postdetailsnew['interested_in_buying']            = $request->input('interested_in_buying') ? $request->input('interested_in_buying') : '0';
            $postdetailsnew['bids_emailed']                    = $request->input('bids_emailed');
            $postdetailsnew['do_you_need_financing']           = $request->input('do_you_need_financing');
            $postdetailsnew['need_Cash_back']                  = $request->input('need_Cash_back');
            $postdetailsnew['agents_users_role_id']            = $request->input('agents_users_role_id');
            $postdetailsnew['agents_user_id']                  = $request->input('agents_user_id');
            //  $words = DB::table('agents_bad_contents')->select('*')->first();
            //  $str = explode(',', $words['words']);
            //  foreach ($str as $key => $value) {

            //     if(preg_match("/{$value}/{i}", $postdetailsnew['details'] ))
            //     {
            //         return response()->json(['ziperr'=> 'please enter post' ]);
            //     }
            // }

            if (!empty($request->input('zip')) && $request->input('zip') != '') {
                // $value = array_values(array_filter($request->input('zip')));
                // $postdetailsnew['zip'] = rtrim(implode(',', $value),',');
                $value = array();
                $alfa = array();
                foreach ($request->input('zip') as $element) {
                    if (is_numeric($element)) {
                        $value[] = $element;
                    } else {
                        $alfa = $element;
                    }
                }
                if (empty($alfa)) {
                    $count = array_count_values($value);
                    $count_values = count($count);
                    if ($count_values == 5) {
                        $postdetailsnew['zip'] = rtrim(implode(',', $value), ',');
                    } else {
                        return response()->json(['ziperr' => "Please add all different zip code."]);
                    }
                } else {
                    return response()->json(['alfa_err' => "Please fill only numeric values."]);
                }
            } else {
                return response()->json(['ziperr' => "Please add zip code."]);
            }
        }


        $postdetailsnew['post_type'] = $request->input('post_type');
        $Post = new Post;
        if (empty($request->input('id'))) {
            $postdetailsnew['created_at'] = Carbon::now()->toDateTimeString();
            $post_id = $Post->inserupdate($postdetailsnew);
            $this->CheckAlreadyConnectedUserSendNotification($postdetailsnew, $post_id);
            return response()->json(["msg" => "Your post has been added successfully"]);
        } else {
            $postdetailsnew['updated_at'] = Carbon::now()->toDateTimeString();
            $Post->inserupdate($postdetailsnew, array('post_id' => $request->input('id')));
            return response()->json(["msg" => "Your post has been updated successfully"]);
        }
    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function getpostsingalByAny(Request $request)

    {

        $Post = new Post;

        $result = $Post->getpostsingalByAny(array(
            'is_deleted' => '0',
            'agents_user_id' => $request->input('agents_user_id'),
            'agents_users_role_id' => $request->input('agents_users_role_id'),
            'status' => 1
        ));

        return response()->json($result);
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function getpostmultipalByAny(Request $request)

    {

        $Post = new Post;

        $result = $Post->getpostmultipalByAny(array('is_deleted' => '0', 'agents_user_id' => $request->input('agents_user_id'), 'agents_users_role_id' => $request->input('agents_users_role_id')));

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getDetailsByAny(Request $request, $limit)
    {

        $Post = new Post;
        $where = array(
            'agents_posts.is_deleted' => '0',
            'agents_posts.agents_user_id' => $request->input('agents_user_id'),
            'agents_posts.agents_users_role_id' => $request->input('agents_users_role_id'),
            'agents_posts.status' => '1'
        );

        if ($request->input('selectedpost') && !empty($request->input('selectedpost'))) {
            $where['agents_posts.applied_post'] = $request->input('selectedpost');
        }
        $result = $Post->getDetailsByAny($limit, $where);
        // echo '<pre>'; print_r($result); die;

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getSelectedDetailsByAny(Request $request, $limit)
    {
        //print_r($limit); exit;
        $Post = new Post;

        $result = $Post->getSelectedDetailsByAny($limit, array(
            'agents_posts.status' => '1',
            'agents_posts.is_deleted' => '0',
            'agents_posts.agents_user_id' => $request->input('agents_user_id'),
            'agents_posts.agents_users_role_id' => $request->input('agents_users_role_id')
        ));
        //dd($result);
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {

        $Post = Post::find($id);
        $Post->is_deleted = '1';
        if ($Post->save()) {
            return response()->json(["status" => 'success', "msg" => "Your Post successfully Delete!"]);
        } else {
            return response()->json(["status" => 'error', "msg" => 'Please try again in a few minutes.']);
        }
    }

    /* For check already connected user send notification */
    public function CheckAlreadyConnectedUserSendNotification($postdetailsnew, $post_id)

    {

        $query1 = DB::table('agents_users_conections');



        if ($postdetailsnew != null) :

            $query1->where(function ($query) use ($postdetailsnew) {

                $query->where(array('to_id'    => $postdetailsnew['agents_user_id'], 'to_role'    => $postdetailsnew['agents_users_role_id']));
            })

                ->orWhere(function ($query) use ($postdetailsnew) {

                    $query->where(array('from_id' => $postdetailsnew['agents_user_id'], 'from_role'   => $postdetailsnew['agents_users_role_id']));
                });

        endif;

        $query1->select('post_id', DB::raw('(CASE WHEN to_id = ' . $postdetailsnew['agents_user_id'] . ' AND to_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN from_role  WHEN from_id = ' . $postdetailsnew['agents_user_id'] . '  AND from_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN to_role END) AS role_id'), DB::raw('(CASE WHEN to_id = ' . $postdetailsnew['agents_user_id'] . ' AND to_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN from_id  WHEN from_id = ' . $postdetailsnew['agents_user_id'] . '  AND from_role = ' . $postdetailsnew['agents_users_role_id'] . ' THEN to_id END) AS id'));

        $query1->orderBy('created_at', 'DESC');

        $result = $query1->get();

        $count = count($result);

        $userdd = DB::table('agents_users_details')->select('*')

            ->where(array('details_id' => $postdetailsnew['agents_user_id']))

            ->first();

        if (!empty($count) && $count != 0) {
            $result_filtered = $this->unique_multidim_array($result, 'id');

            foreach ($result_filtered as $key => $value) {

                $notifiy = array(

                    'sender_id'         => $postdetailsnew['agents_user_id'], 'sender_role'       => $postdetailsnew['agents_users_role_id'],

                    'receiver_id'       => $value->id, 'receiver_role'     => $value->role_id

                );

                try {
                    $notifiy['notification_type']            = 12;

                    $notifiy['notification_message']         = $userdd->name . ' upload a new post(' . $postdetailsnew['posttitle'] . ')';

                    $notifiy['notification_item_id']         = $post_id;

                    $notifiy['notification_child_item_id']   = $value->id;

                    $notifiy['status']                       = 1;

                    $notifiy['updated_at']                   = Carbon::now()->toDateTimeString();

                    DB::table('agents_notification')->insertGetId($notifiy);

                    event(new eventTrigger(array($notifiy, $value, 'NewNotification')));
                } catch (\Exception $e) {
                } catch (\Throwable $th) {
                } catch (BroadcastException $brExe) {
                }
            }
        }
    }


    /* For agent applied on post */
    public function AppliedAgents($post_id = null, $agentid = null)

    {

        $user = Auth::user();

        $userdetails = Userdetails::find($user->id);



        $post = Post::find($post_id);

        $post->applied_post     = '1';

        $post->applied_user_id  = $agentid;

        $post->final_status     = 1;

        $post->updated_at       = Carbon::now()->toDateTimeString();

        $post->agent_select_date     = Carbon::now()->toDateTimeString();
        $post->cron_time     = Carbon::now()->toDateTimeString();

        $post->save();



        $user = new User;

        $agentdata = $user->getDetailsByEmailOrId(array('id' => $agentid));



        $notification = new Notification;

        $where = array();

        $where['sender_id']                    = $post->agents_user_id;

        $where['sender_role']                  = $post->agents_users_role_id;

        $where['receiver_id']                  = $agentdata->id;

        $where['receiver_role']                = $agentdata->agents_users_role_id;

        $where['notification_type']            = 13;

        $where['notification_message']         = $userdetails->name . ' select you for post (' . $post->posttitle . ')';

        $where['notification_item_id']         = $post_id;

        $where['notification_post_id']         = $post_id;

        $where['notification_child_item_id']   = $agentdata->id;

        $where['created_at']                   =  Carbon::now()->toDateTimeString();

        $where['updated_at']                   =  Carbon::now()->toDateTimeString();

        $result = $notification->inserupdate($where);

        event(new eventTrigger(array($where, $result, 'NewNotification')));



        $emaildata['url']       = url('/search/post/details/') . '/' . $post_id . '/13';

        $emaildata['email']     = $agentdata->email;

        $emaildata['name']      = ucwords($agentdata->name);

        $emaildata['posttitle'] = ucwords($post->posttitle);

        $emaildata['html']      = '<div>

                                        <h3>Hello ' . $emaildata['name'] . ',</h3>

                                        <br>

                                        <p>

                                           ' . $userdetails->name . ' select you for post `' . $emaildata['posttitle'] . '`

                                        </p>

                                        <br>



                                     <p>Visit post <a href="' . $emaildata['url'] . '">' . $emaildata['posttitle'] . '</a> </p>

                                    <br>

                                    <br>

                                    <center><a href="' . URL('/') . '"> www.92Agents.com </a></center>

                                  <div>';



        Mail::send([], [], function ($message) use ($emaildata) {

            $message->to($emaildata['email'], $emaildata['name'])

                ->subject('You are selected for post " ' . $emaildata['posttitle'] . ' "')

                ->setBody($emaildata['html'], 'text/html');

            $message->from('92agent@92agents.com', '92agent@92agents.com');
        });



        return response()->json($result);
    }

    /* For when do you want to sell */
    public function whenDoYouWantToSell($type = null)
    {

        $options = array(
            array(
                'id' => 'now',
                'option' => 'now'
            ),
            array(
                'id' => 'within 30 days',
                'option' => 'within 30 days'
            ),
            array(
                'id' => 'within 90 days',
                'option' => 'within 90 days'
            ),
            array(
                'id' => 'undecided',
                'option' => 'undecided'
            )
        );
        return $options;
    }

    /* For list of home type show inside the dropdown */
    public function homeType($type = null)
    {

        $options = array(
            array(
                'id' => 'single_family',
                'option' => 'Single Family'
            ),
            array(
                'id' => 'condo_townhome',
                'option' => 'Condo Townhome'
            ),
            array(
                'id' => 'multi_family',
                'option' => 'Multi Family'
            ),
            array(
                'id' => 'manufactured',
                'option' => 'Manufactured'
            ),
            array(
                'id' => 'lots_land',
                'option' => 'Lots/Land'
            )
        );
        return $options;
    }

    public function showdoc(Request $request)
    {

        $data = array();
        $data['shared_item_type_id'] = $request->input('postid');
        $data['sender_id'] = $request->input('userid');
        $data['receiver_id'] = $request->input('agentid');

        $query = DB::table('agents_upload_share_all as a')->select('a.attachments')
            ->join('agents_shared', 'shared_item_id', '=', 'a.upload_share_id')->where($data)->first();
        // $html['data'] = '';
        // while ($query) {
        //     $html .='<embed src="'.$query['attachments'].'" type="application/pdf"   height="300px" width="100%" class="responsive">';
        // }
        return json_encode($query);
    }


    public function selldetails(Request $request)
    {

        $agent_comission = !empty($request->input('agent_comission')) ? $request->input('agent_comission') : 3;
        $comission_92agent = !empty($request->input('comission_92agent')) ? $request->input('comission_92agent') : 3;

        $insert_arr = array(
            'sellers_name' => $request->input('sellers_name'),
            'address' => $request->input('address'),
            'sale_date' => date('Y-m-d h:i:s', strtotime($request->input('sale_date'))),
            'sale_price' => $request->input('sale_price'),
            'post_id' => $request->input('post_id'),
            'agent_id' => $request->input('selected_agent'),
            'agent_comission' => $agent_comission,
            'comission_92agent' => $comission_92agent,
        );

        $selldetail_id = DB::table('agents_selldetails')->insertGetId($insert_arr);

        if (isset($selldetail_id)) {
            $view['c_status'] = 'success';
            $view['c_message'] = 'Sell details upadted successfully';
        } else {
            $view['c_status'] = 'failed';
            $view['c_message'] = 'Failed to update sell details';
        }
        return redirect(url()->previous())->with($view);
    }
}
