<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessagingChat extends Model
{
    protected $table = 'agents_conversation';
	protected $primaryKey = "conversation_id";

	/* get all data any filed using*/
    public function getConversationByAny($where=null,$orwhere=null,$norwhere=null){
		$query1= DB::table('agents_conversation')->select('*');
		if($where != null){
		    $query1->where(function($query2) use($where, $orwhere){
		    	  $query2->where(function($query3) use ($where, $orwhere)
	              {
						$query3->where( $where );
	              })
	              ->orWhere(function($query3) use ($where, $orwhere)
	              {
						$query3->where( $orwhere );
	              });
			})
			->where($norwhere);
		}
		$query1->orderBy('created_at','DESC');
		return $result = $query1->get();
	}

	/* For get conversation messages by any */
    public function getConversationMessageByAny($where=null,$orwhere=null){
		$query1= DB::table('agents_conversation_message')->select('*');
		if($where != null){
			 $query1->where(function($query) use ($where, $orwhere)
              {
                  $query->where($where)
                        ->where($orwhere);
              })
              ->orWhere(function($query) use ($where, $orwhere)
              {
                  $query->Where($where)
                        ->Where($orwhere);
              });
		}
		$query1->orderBy('created_at','DESC');
		return $result = $query1->get();
	}

	/* For conversation insert and update */
	public function ConversationInserUpdate($data=null,$id=null)
	{
		if(empty($id)){
			$result = DB::table('agents_conversation')->insertGetId($data);
		}else{
			$result = DB::table('agents_conversation')->where($id)->update($data);
		}
		return $result;
	}

	/* For insert update conversation messages */
	public function ConversationMessageInserUpdate($data=null,$id=null)
	{
		if(empty($id)){
			$result = DB::table('agents_conversation_message')->insertGetId($data);
			$query= DB::table('agents_conversation_message')->select('*');
			$query->leftJoin('agents_users_details', 'agents_users_details.details_id', '=', 'agents_conversation_message.sender_id');
			$query->where(array('agents_conversation_message.messages_id' => $result));
			return $result = $query->first();
		}else{
			$result = DB::table('agents_conversation_message')->where($id)->update($data);
			$query= DB::table('agents_conversation_message')->select('*');
			$query->where($id);
			return $result = $query->first();
		}
	}

	/* get all data any filed using*/
    public function getUserConversationsListByAny($limit,$where=null,$orwhere=null,$normalwhere=null){
			$query1 = DB::table('agents_conversation as m')
			->join('agents_users_details as u',function($join){
			     $join->on('u.details_id','=','m.sender_id')
			     ->orOn('u.details_id','=','m.receiver_id');
			})
			->leftJoin('agents_users as uu','uu.id','=','u.details_id')
			->Join('agents_posts as p','p.post_id','=','m.post_id')
			->where(function($query) use($where,$orwhere){
			    $query->where($where);
			    $query->orWhere($orwhere);
			})
			->where(function($query) use($where,$orwhere){
			    $query->whereRaw(DB::raw(

			           'CASE WHEN m.sender_id = '.$where['m.sender_id']." AND m.sender_role_id = ".$where['m.sender_role_id'].'
			            THEN m.receiver_id = u.details_id
			            WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role_id = '.$where['m.sender_role_id'].'
			            THEN m.sender_id = u.details_id END'

			        ));
			   });
			if($normalwhere != null){
				$query1->where($normalwhere);
			}
			$query1->where('p.is_deleted','0');
			$query1->select('u.details_id as user_id','uu.login_status','uu.updated_at as last_login_time','m.*','u.name','u.photo','p.posttitle','p.details',DB::raw('(CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role_id = '.$where['m.sender_role_id'].' THEN m.receiver_role_id  WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role_id = '.$where['m.sender_role_id'].' THEN m.sender_role_id END) AS agents_users_role_id'),DB::raw('(CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role_id = '.$where['m.sender_role_id'].' THEN "sender"  WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role_id = '.$where['m.sender_role_id'].' THEN "receiver" END) AS is_user'))
		 	->orderBy('m.updated_at','DESC');

		  	$count = $query1->count();
			$result = $query1->take(10)->get();
			$coun = floor($count/10);
	        // if($limit == 0){$prview=0;}else{ $prview=$limit-1;};
	        $next   = $coun==$limit ? 0 : ($count <=10 ? 0 : $limit+1);
	        // $rlimit = $limit*10==0 ? 1 : $limit*10;
	        $llimit = $next*10 == 0 ? $count : $next*10;

		 	$data = array('result' => $result,'count' => $count,'llimit' => $llimit, 'rlimit' => "rlimit",'prview' => "prview", 'next' => $next);

			return $data;
	}

	/* For get user conversation details */
    public function getUserConversationsMessageListByAny($limit,$where=null,$orwhere=null,$mainwhere=null){
			$query1 = DB::table('agents_conversation_message as m')
			->join('agents_users_details as u',function($join){
			     $join->on('u.details_id','=','m.sender_id')
			     ->orOn('u.details_id','=','m.receiver_id');
			})
			->leftJoin('agents_users as uu','uu.id','=','u.details_id')
			->Join('agents_posts as p','p.post_id','=','m.post_id')
			->leftJoin('agents_conversation as cc','cc.conversation_id','=','m.conversation_id')
			->where(function($query) use($where,$orwhere){
			    $query->where($where);
			    $query->orWhere($orwhere);
			})
			->where(function($query) use($where,$orwhere){
			    $query->whereRaw(DB::raw(

			           'CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role = '.$where['m.sender_role'].'
			            THEN m.sender_id = u.details_id
			            WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role = '.$where['m.sender_role'].'
			            THEN m.sender_id = u.details_id END'

			        ));
			   })
			->where($mainwhere)
			->where('p.is_deleted','0')
			->select('u.details_id as user_id','m.*','uu.login_status','uu.updated_at as last_login_time','u.name','u.photo','p.posttitle','p.details','cc.snippet','cc.created_at as cc_created_at','cc.updated_at as cc_updated_at',DB::raw('(CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role = '.$where['m.sender_role'].' THEN m.receiver_role  WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role = '.$where['m.sender_role'].' THEN m.sender_role END) AS agents_users_role_id'))
		 	->orderBy('m.messages_id','DESC');

		  	$count = $query1->count();
			$result = $query1->skip($limit*10)->take(10)->get();
			$coun = floor($count/10);
	        $prview = $limit == 0 ? 0 : $limit-1;
	        $next   = $coun==$limit ? 0 : ($count <= 10 ? 0 : $limit+1);
	        $rlimit = $limit*10==0 ? 1 : $limit*10;
	        $llimit = $next*10 == 0 ? $count : $next*10;

		 	$data = array('result' => $result,'count' => $count,'llimit' => $llimit, 'rlimit' => $rlimit,'prview' => $prview, 'next' => $next);

			return $data;
	}

	/* Get send messages details by any */
    public function getSendedMessageListByAny($limit,$where=null,$orwhere=null){
			$user = Auth::user();
			$query1 = DB::table('agents_conversation as m')
			->join('agents_users_details as u',function($join){
			     $join->on('u.details_id','=','m.sender_id')
			     ->orOn('u.details_id','=','m.receiver_id');
			})
			->leftJoin('agents_users as uu','uu.id','=','u.details_id')
			->Join('agents_posts as p','p.post_id','=','m.post_id')
			->where(function($query) use($where,$orwhere){
			    $query->where($where);
			    $query->orWhere($orwhere);
			})
			->where(function($query) use($where,$orwhere){
			    $query->whereRaw(DB::raw(

			           'CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role_id = '.$where['m.sender_role_id'].'
			            THEN m.receiver_id = u.details_id
			            WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role_id = '.$where['m.sender_role_id'].'
			            THEN m.sender_id = u.details_id END'

			        ));
			   })
			->where('p.is_deleted','0')			->where('u.details_id','<>',$user->id)
			->select('u.details_id as user_id','uu.login_status','uu.updated_at as last_login_time','m.*','u.name','u.photo','p.posttitle','p.details',DB::raw('(CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role_id = '.$where['m.sender_role_id'].' THEN m.receiver_role_id  WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role_id = '.$where['m.sender_role_id'].' THEN m.sender_role_id END) AS agents_users_role_id'),DB::raw('(CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role_id = '.$where['m.sender_role_id'].' THEN "sender"  WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role_id = '.$where['m.sender_role_id'].' THEN "receiver" END) AS is_user'))
		 	->orderByRaw('CASE WHEN m.sender_id = '.$where['m.sender_id'].' AND m.sender_role_id = '.$where['m.sender_role_id'].' THEN m.last_sender_da  WHEN m.receiver_id = '.$where['m.sender_id'].'  AND m.receiver_role_id = '.$where['m.sender_role_id'].' THEN m.last_receiver_da END DESC');

		  	$count = $query1->count();
			$result = $query1->skip($limit*10)->take(10)->get();
			$coun = floor($count/10);
	        $prview = $limit == 0 ? 0 : $limit-1;
	        $next   = $coun==$limit ? 0 : ($count<=10 ? 0 : $limit+1);
	        $rlimit = $limit*10==0 ? 1 : $limit*10;
	        $llimit = $next*10 == 0 ? $count : $next*10;

		 	$data = array('result' => $result,'count' => $count,'llimit' => $llimit, 'rlimit' => $rlimit,'prview' => $prview, 'next' => $next);
			return $data;
	}

	/* For get user read messages list by any */
    public function getUnreadMessageListByAny($normwhere=null){

			$query1 = DB::table('agents_conversation')
			->selectRaw('sum(unread_count) as unreadmessagescount, COUNT(*) as unreadusercount')
			->where($normwhere)
			->where('unread_count','!=','0')
		 	->orderBy('updated_at','DESC')
		 	->groupBy('tags_user_id')
		 	->first();
			return $query1;
	}
}
