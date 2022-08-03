<?php

namespace App\Http\Controllers\Api;
use App\Events\eventTrigger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Userdetails;
use App\Models\Shared;
use App\Models\UploadAndShare;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class UploadAndShareController extends Controller
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

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

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



        if(empty($request->input('id'))){

        $rules = array(

         'uploadshare'=> 'required|mimes:jpeg,jpg,png,doc,pdf,docx|max:15360',

        );

        // |mimes:jpg,png,doc,pdf,docx

        // |mimes:jpg,png,doc,pdf,docx|

        /*'uploadshare'           => 'required|mimes:doc,pdf,docx|max:20000',*/



        $validator = Validator::make($request->all(),$rules,['uploadshare.max' => 'File Upload should be less then 15MB.']);



        if($validator->fails()){

           return response()->json(['error'=> $validator->errors() ]);

        }



         $image = $request->file('uploadshare');

         $filename = time().'.'.$image->getClientOriginalExtension();

         $destinationPath = public_path('assets/img/upload_and_share/');

         $image->move($destinationPath, $filename);

         $filepath = url("assets/img/upload_and_share/".$filename);

         $postdetailsnew=array();

         $postdetailsnew['agents_user_id'] = $request->input('agents_user_id');

         $postdetailsnew['agents_users_role_id'] = $request->input('agents_users_role_id');

         $postdetailsnew['attachments'] = $filepath;

         $uploadandshare = new UploadAndShare;



         $re = $uploadandshare->inserupdate($postdetailsnew);



        }else{



         $uploadandshare = UploadAndShare::find($request->input('id'));

         $re=1;

         if($request->file('uploadshare') && !empty($request->file('uploadshare'))){

            $atachpath = str_replace(url('/').'/', '', $uploadandshare->attachments);

            File::delete($atachpath);

            $image = $request->file('uploadshare');

            $filename = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('assets/img/upload_and_share/');

            $image->move($destinationPath, $filename);

            $filepath = url("assets/img/upload_and_share/".$filename);

            $uploadandshare->attachments = $filepath;

            $uploadandshare->updated_at = Carbon::now()->toDateTimeString();

            $re = $uploadandshare->save();

         }

        }

        if($re){



            return response()->json(["msg" => "Your file has been uploaded successfully"]);
        }else{
            return response()->json(["msg" => array('error' => 'Please try again in a few minutes.')]);
        }

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show(Request $request)

    {
            $user =  Auth::user();
            $userdetails = Userdetails::find($user->id);

              $where = (array('is_deleted' => '0','agents_user_id' => $user->id,'agents_users_role_id' => $user->agents_users_role_id));


		$query= DB::table('agents_upload_share_all')->select('*');

		if($where != null){
			$query->where($where);
		}
		$query->orderBy('created_at','DESC');
		$result = $query->get();
        	return response()->json(['status'=>'100','response'=>$result]);

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function showten($limit,$userid,$role)

    {

        $uploadandshare = new UploadAndShare;

        $result = $uploadandshare->gettenDetailsByAny($limit,array('is_deleted' => '0','agents_user_id' => $userid,'agents_users_role_id' => $role));

        return response()->json($result);

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function getfileswithshared($files)

    {

        $sproposal = array();

        $proposals = new UploadAndShare;

        $shared = new Shared;

        //$result = $proposals->getDetailsByAny( '0', array('is_deleted' => '0','agents_user_id' => '105','agents_users_role_id' => '3' ) );
         $result = $proposals->getDetailsByAny( '0', array('is_deleted' => '0','agents_user_id' => '105','agents_users_role_id' => '3' ) );

        foreach ($result['result'] as $value) {



            $aa['shared_type']          = 2;

            $aa['shared_item_id']       = $value->upload_share_id;

            $aa['shared_item_type']     = 2;

            $aa['shared_item_type_id']  =  '59';//$files['post_id'];

            $aa['sender_id']            = '105'; //$files['sender_id'];

            $aa['sender_role']          = '3';//$files['sender_role'];

            $aa['receiver_id']          ='116'; $files['receiver_id'];

            $aa['receiver_role']        = '4';

            $ss = $shared->getsinglerowByAny($aa);

            if(empty($ss)){

                $sproposal[$value->upload_share_id] = '';

            }else{

                $sproposal[$value->upload_share_id] = $ss;

            }

        }

        $sproposal['result']=$result;
        return $sproposal;

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

        $uploadandshare = UploadAndShare::find($request->input('document_id'));

        $uploadandshare->is_deleted = '1';

        if($uploadandshare->save()){

            return response()->json(["status" => '100',"response" => "You file has been deleted successfully"]);



        }else{

            return response()->json(["status" => '101',"error" => 'Please try again in a few minutes.']);



        }

    }

    //demo starts
    public function uploadFileDemo(Request $request){

        $insert=$update="";

        $rules=array(
            'str' => 'required',
        );//rules for validation

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            if($request->ajax()){
                $res=array(
                    'status'=>2,
                    'message'=>'Validation Failed',
                    'errors'=>$validator->errors()
                );

            }else{
                $res=array(
                    'status'=>2,
                    'message'=>'Validation Failed',
                    'errors'=>$validator->errors()
                );

            }
            return response()->json($res);
        }//if validator fails

        $str = $request->input('str');

        $data = array(
            'str'=>$str,
        );
        if($request->file('file')){

            $res=array(
                'status'=>true,
                'message'=>'Yes',
            );
            $file = $request->file('file');

            // $destinationPath = 'uploads';
            // $filename=date('Y_m_d_i_s').mt_rand().'.'.$file->getClientOriginalExtension();
            // $file->move($destinationPath,$filename);
            // $data['file']=$filename;

            // $res_data=array(
            //     'str'=>$str,
            //     'file'=>asset('uploads/'.$filename),
            // );

            // $res=array(
            //     'status'=>1,
            //     'message'=>'Success',
            //     'data'=>$res_data,
            // );
            return response()->json($res);
        }else{
            $res=array(
                'status'=>true,
                'message'=>'No',
            );
        }
        return response()->json($res);
    }//demo ends

}

