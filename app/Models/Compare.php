<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compare extends Model
{
    protected $table = 'agents_compare';
	protected $primaryKey = "compare_id";

	/* get all data any filed using*/
    public function getDetailsByAny($limit,$where=null){
		$query= DB::table('agents_compare')
				->select('agents_compare.*','agents_users.login_status','agents_users_details.details_id','agents_users_details.name','agents_users_details.photo','agents_users_details.description')
				->join("agents_users_details",DB::raw("FIND_IN_SET(agents_users_details.details_id,agents_compare.compare_item_id)"),">",DB::raw("'0'"))
				->leftjoin("agents_users",'agents_users.id','=','agents_users_details.details_id');
		if($where != null){
			$query->where($where);
		}

		$query->orderBy('agents_compare.created_at','DESC');
		$count = $query->count();
		$result = $query->skip($limit*10)->take(10)->get();

		$coun = floor($count/10);
        $prview = $limit == 0 ? 0 : $limit-1;
        $next   = $coun==$limit ? 0 : ($coun <= 10 ? 0 : $limit+1);
        $rlimit = $limit*10==0 ? 1 : $limit*10;
        $llimit = $next*10 == 0 ? $count : $next*10;

	 	$data = array('result' => $result,'count' => $count,'llimit' => $llimit, 'rlimit' => $rlimit,'prview' => $prview, 'next' => $next);

		return $data;
	}

	/* Compare update insert update */
	public function inserupdate($data=null,$id=null)
	{
		if(empty($id)){
			$result = DB::table('agents_compare')->insertGetId($data);
		}else{
			$result = DB::table('agents_compare')->where($id)->update($data);
		}
		return $result;
	}

	/* get all data any filed using*/
    public function getCompareByAny($where=null){
		$query= DB::table('agents_compare')->select('*');

		if($where != null){
			$query->where($where);
		}
		$query->orderBy('created_at','DESC');
		return $result = $query->get();
	}

	/* get all data any filed using*/
    public function getCompareSingalByAny($where=null){
		$query= DB::table('agents_compare')->select('*');

		if($where != null){
			$query->where($where);
		}
		$query->orderBy('created_at','DESC');
		return $result = $query->first();
	}

	/* get all data any filed using Answers table*/
    public function GetAskedQuestion($where=null,$wherein=null){
		$query= DB::table('agents_shared')->select('agents_shared.shared_id','agents_question.importance','agents_question.question_id','agents_question.question');
		$query->leftJoin('agents_question', 'agents_question.question_id', '=', 'agents_shared.shared_item_id');
		if($wherein != null){
			$query->whereIn( $wherein['colume'] , $wherein['value'] );
		}
		if($where != null){
			$query->where($where);
		}
		$query->orderBy('agents_shared.created_at','DESC');
		$query->groupBy('agents_question.question_id');
		$result = $query->get();
		return $result;
	}

	/* Compare agent details */
	public function checkcompareintableagents($where)
	{
		$queryc = DB::table('agents_compare')
			    ->where( array(
	    					'post_id' 				=> $where['post_id'],
    						'sender_id' 			=> $where['sender_id'],
    						'sender_role' 			=> $where['sender_role'],
    					) )
			    ->whereRaw('FIND_IN_SET('.$where['compare_item_id'].',compare_item_id)')
				->select('agents_compare.*');
		$result = $queryc->first();
		return $result;
	}

	/* get all data any filed using*/
    public function getcomparragenstlist($where=null){
		$query= DB::table('agents_compare')
				->select('agents_compare.*','agents_posts.applied_post','agents_posts.applied_user_id','agents_posts.post_id','agents_posts.agents_user_id','agents_posts.agents_users_role_id','agents_posts.posttitle','agents_users_details.*')
				->leftjoin("agents_users_details",DB::raw("FIND_IN_SET(agents_users_details.details_id,agents_compare.compare_item_id)"),">",DB::raw("'0'"))
				->Join('agents_posts', 'agents_posts.post_id', '=','agents_compare.post_id');
		if($where != null){
			$query->where( array('agents_compare.compare_id' => $where['compare_id']) );
		}
		$count = $query->count();
		$result = $query->get();

	 	$obj=[];
		foreach ($result as $value) {
			$asked_question 	= $where && @$where['asked_question']==1 ? $this->asked_question($value,$where) : array('asked_question' => '');
			$bookmark_agents 	= $where && @$where['bookmark_agents']==1 ? $this->bookmark_agents($value,$where) : array('bookmark_agents' => '');
			$bookmark_answers 	= $where && @$where['bookmark_answers']==1 ? $this->bookmark_answers($value,$where) : array('bookmark_answers' => '');
			$bookmark_messages 	= $where && @$where['bookmark_messages']==1 ? $this->bookmark_messages($value,$where) : array('bookmark_messages' => '');
			$bookmark_proposal 	= $where && @$where['bookmark_proposal']==1 ? $this->bookmark_proposal($value,$where) : array('bookmark_proposal' => '');
			$rating_answers 	= $where && @$where['rating_answers']==1 ? $this->rating_answers($value,$where) : array('rating_answers' => '');
			$rating_messages 	= $where && @$where['rating_messages']==1 ? $this->rating_messages($value,$where) : array('rating_messages' => '');
			$proposals 			= $where && @$where['proposals']==1 ? $this->proposals($value,$where) : array('proposals' => '');
			$documents 			= $where && @$where['documents']==1 ? $this->documents($value,$where) : array('documents' => '');
			$notes_messages 	= $where && @$where['notes_messages']==1 ? $this->notes_messages($value,$where) : array('notes_messages' => '');
			$notes_asked_question = $where && @$where['notes_asked_question']==1 ? $this->notes_asked_question($value,$where) : array('notes_asked_question' => '');
			$notes_answers 		= $where && @$where['notes_answers']==1 ? $this->notes_answers($value,$where) : array('notes_answers' => '');
			$notes_proposal 	= $where && @$where['notes_proposal']==1 ? $this->notes_proposal($value,$where) : array('notes_proposal' => '');
			$notes_agents 		= $where && @$where['notes_agents']==1 ? $this->notes_agents($value,$where) : array('notes_agents' => '');
			$obj[$value->details_id] = (object) array_merge((array) $value
						, (array) $asked_question
						, (array) $bookmark_agents
						, (array) $bookmark_answers
						, (array) $bookmark_messages
						, (array) $bookmark_proposal
						, (array) $rating_answers
						, (array) $rating_messages
						, (array) $proposals
						, (array) $documents
						, (array) $notes_messages
						, (array) $notes_asked_question
						, (array) $notes_answers
						, (array) $notes_proposal
						, (array) $notes_agents
					);
		}

	 	$data = array('result' => $obj,'count' => $count);
		return $data;
	}

	/* For asked questions */
	public function asked_question($value,$where)
	{
		if(isset($where['asked_question_list']) && !empty($where['asked_question_list'])){
			$query= DB::table('agents_question')
					->select('agents_question.question_id','agents_question.question','agents_question.importance');
			$query->where(array(
							'agents_question.add_by' 		=> $value->sender_id,
							'agents_question.add_by_role' 	=> $value->sender_role,
							'agents_question.is_deleted'	=> '0',
						) );
			$query->whereIn( 'agents_question.question_id' , $where['asked_question_list'] );
			$result = $query->get();
			$data=[];
			foreach ($result as $key => $value1) {
				$query= DB::table('agents_answers')
						->select('agents_answers.answers','agents_answers.answers_id');
				$query->where(array(
							'agents_answers.question_id' 	=> $value1->question_id,
							'agents_answers.from_id' 		=> $value->details_id,
							'agents_answers.from_role' 		=> 4,
							'agents_answers.is_deleted' 	=> '0',
							'agents_answers.post_id' 		=> $value->post_id,
						) );
				$answerdata = $query->first();
				$data[$value1->question_id] = (object) array_merge((array) $value1
							, (array) array('answers' => @$answerdata->answers,'answers_id' => @$answerdata->answers_id));
			}
		return array('asked_question' => $data);
		}else{

		return array('asked_question' => '');
		}
	}

	/* For bookmark answer question */
	public function bookmark_answers($value,$where)
	{
		$queryc = DB::table('agents_bookmark')
				->join('agents_question', 'agents_question.question_id', '=', 'agents_bookmark.bookmark_item_parent_id')
				->join('agents_answers', 'agents_answers.answers_id', '=', 'agents_bookmark.bookmark_item_id')
			    ->where( array(
    						'agents_bookmark.sender_id' 	=> $value->sender_id,
    						'agents_bookmark.sender_role' 	=> $value->sender_role,
    						'agents_bookmark.receiver_id' 	=> $value->details_id,
    						'agents_bookmark.receiver_role' => 4,
    						'agents_bookmark.bookmark_type'	=> 4,
    						'agents_answers.post_id'		=> $value->post_id,
    					) )
				->select('agents_bookmark.bookmark_id','agents_question.question_id','agents_question.question','agents_question.importance','agents_answers.answers','agents_answers.answers_id');

		$result = $queryc->get();
		return array('bookmark_answers' => $result);
	}

	/* Book mark agents */
	public function bookmark_agents($value,$where)
	{
		$queryc = DB::table('agents_bookmark')
			    ->where( array(
    						'agents_bookmark.sender_id' 	=> $value->sender_id,
    						'agents_bookmark.sender_role' 	=> $value->sender_role,
    						'agents_bookmark.receiver_id' 	=> $value->details_id,
    						'agents_bookmark.receiver_role' => 4,
    						'agents_bookmark.bookmark_type'	=> 2,
    						'agents_bookmark.bookmark_item_id' 	=> $value->details_id,
    						'agents_bookmark.bookmark_item_parent_id' 	=> $value->post_id,
    					) )
				->select('agents_bookmark.bookmark_id');

		$result = $queryc->first();
		return array('bookmark_agents' => $result);
	}

	/* For bookmark messages */
	public function bookmark_messages($value,$where)
	{
		$query= DB::table('agents_bookmark')
		->leftJoin('agents_conversation_message', 'agents_conversation_message.messages_id', '=', 'agents_bookmark.bookmark_item_id')
		->where(function($query1) use ($value)
      	{
          	$query1->where(array('agents_conversation_message.sender_id' => $value->sender_id,'agents_conversation_message.sender_role' => $value->sender_role))
                ->where(array('agents_conversation_message.receiver_id' => $value->details_id,'agents_conversation_message.receiver_role' => 4));
      	})
      	->orWhere(function($query1) use ($value)
      	{
          	$query1->Where(array('agents_conversation_message.sender_id' => $value->details_id,'agents_conversation_message.sender_role' => 4))
                ->Where(array('agents_conversation_message.receiver_id' => $value->sender_id,'agents_conversation_message.receiver_role' => $value->sender_role));
      	})
		->where( array(
					'agents_bookmark.sender_id' 	=> $value->sender_id,
					'agents_bookmark.sender_role' 	=> $value->sender_role,
					'agents_bookmark.receiver_id' 	=> $value->details_id,
					'agents_bookmark.receiver_role' => 4,
					'agents_conversation_message.post_id' 	=> $value->post_id,
					'agents_bookmark.bookmark_type'	=> 3,
				) )
		->select('agents_conversation_message.*','agents_bookmark.bookmark_id',DB::raw('(CASE WHEN agents_conversation_message.sender_id = '.$value->sender_id.' AND agents_conversation_message.sender_role = '.$value->sender_role.' THEN "right"  WHEN agents_conversation_message.receiver_id = '.$value->sender_id.'  AND agents_conversation_message.receiver_role = '.$value->sender_role.' THEN "left" END) AS is_user'))
		->groupBy('agents_conversation_message.messages_id');
		$result = $query->get();
		return array('bookmark_messages' => $result);
	}

	/* For bookmark proposal */
	public function bookmark_proposal($value,$where)
	{
		$queryc = DB::table('agents_bookmark')
				->join('agents_proposals', 'agents_proposals.proposals_id', '=', 'agents_bookmark.bookmark_item_id')
			    ->where( array(
    						'agents_bookmark.sender_id' 	=> $value->sender_id,
    						'agents_bookmark.sender_role' 	=> $value->sender_role,
    						'agents_bookmark.receiver_id' 	=> $value->details_id,
    						'agents_bookmark.receiver_role' => 4,
    						'agents_bookmark.bookmark_type'	=> 5,
    						'agents_bookmark.bookmark_item_parent_id'	=> $value->post_id,
    					) )
				->select('agents_bookmark.bookmark_id','agents_proposals.proposals_id','agents_proposals.proposals_title','agents_proposals.proposals_attachments');

		$result = $queryc->get();
		return array('bookmark_proposal' => $result);
	}

	/* For rating answer process */
	public function rating_answers($value,$where)
	{
		$queryc = DB::table('agents_rating')
				->join('agents_question', 'agents_question.question_id', '=', 'agents_rating.rating_item_parent_id')
				->join('agents_answers', 'agents_answers.answers_id', '=', 'agents_rating.rating_item_id')
			    ->where( array(
    						'agents_rating.sender_id' 		=> $value->sender_id,
    						'agents_rating.sender_role' 	=> $value->sender_role,
    						'agents_rating.receiver_id' 	=> $value->details_id,
    						'agents_rating.receiver_role' 	=> 4,
    						'agents_rating.rating_type'		=> 1,
    						'agents_answers.post_id'		=> $value->post_id,
    					) )
				->select('agents_rating.rating_id','agents_rating.rating','agents_question.question_id','agents_question.question','agents_question.importance','agents_answers.answers','agents_answers.answers_id');
		$result = $queryc->get();
		return array('rating_answers' => $result);
	}

	/* For rating messages */
	public function rating_messages($value,$where)
	{
		$query= DB::table('agents_rating')
		->leftJoin('agents_conversation_message', 'agents_conversation_message.messages_id', '=', 'agents_rating.rating_item_id')
		->where(function($query1) use ($value)
      	{
          	$query1->where(array('agents_conversation_message.sender_id' => $value->sender_id,'agents_conversation_message.sender_role' => $value->sender_role))
                ->where(array('agents_conversation_message.receiver_id' => $value->details_id,'agents_conversation_message.receiver_role' => 4));
      	})
      	->orWhere(function($query1) use ($value)
      	{
          	$query1->Where(array('agents_conversation_message.sender_id' => $value->details_id,'agents_conversation_message.sender_role' => 4))
                ->Where(array('agents_conversation_message.receiver_id' => $value->sender_id,'agents_conversation_message.receiver_role' => $value->sender_role));
      	})
		->where( array(
					'agents_rating.sender_id' 		=> $value->sender_id,
					'agents_rating.sender_role' 	=> $value->sender_role,
					'agents_rating.receiver_id' 	=> $value->details_id,
					'agents_rating.receiver_role' 	=> 4,
					'agents_conversation_message.post_id' 	=> $value->post_id,
					'agents_rating.rating_type'		=> 2,
				) )
		->select('agents_conversation_message.*','agents_rating.rating_id','agents_rating.rating',DB::raw('(CASE WHEN agents_conversation_message.sender_id = '.$value->sender_id.' AND agents_conversation_message.sender_role = '.$value->sender_role.' THEN "right"  WHEN agents_conversation_message.receiver_id = '.$value->sender_id.'  AND agents_conversation_message.receiver_role = '.$value->sender_role.' THEN "left" END) AS is_user'))
		->groupBy('agents_conversation_message.messages_id');
		$result = $query->get();
		return array('rating_messages' => $result);
	}


	/* For proposals process */
	public function proposals($value,$where)
	{
		$query= DB::table('agents_shared')->select('agents_proposals.proposals_id','agents_proposals.proposals_title','agents_proposals.proposals_attachments');
		$query->leftJoin('agents_proposals', 'agents_proposals.proposals_id', '=', 'agents_shared.shared_item_id');
		$query->where(array(
    						'agents_shared.sender_id' 			=> $value->details_id,
    						'agents_shared.sender_role' 		=> 4,
    						'agents_shared.receiver_id' 		=> $value->sender_id,
    						'agents_shared.receiver_role' 		=> $value->sender_role,
    						'agents_shared.shared_type'			=> 3,
    						'agents_shared.shared_item_type_id'	=> $value->post_id,
    						'agents_proposals.is_deleted'		=> '0',
    					) );
		$result = $query->get();
		return array('proposals' => $result);
	}

	/*For documents process */
	public function documents($value,$where)
	{
		$query= DB::table('agents_shared')->select('agents_upload_share_all.upload_share_id','agents_upload_share_all.attachments');
		$query->leftJoin('agents_upload_share_all', 'agents_upload_share_all.upload_share_id', '=', 'agents_shared.shared_item_id');
		$query->where(array(
    						'agents_shared.sender_id' 			=> $value->details_id,
    						'agents_shared.sender_role' 		=> 4,
    						'agents_shared.receiver_id' 		=> $value->sender_id,
    						'agents_shared.receiver_role' 		=> $value->sender_role,
    						'agents_shared.shared_type'			=> 2,
    						'agents_shared.shared_item_type_id'	=> $value->post_id,
    						'agents_upload_share_all.is_deleted'		=> '0',
    					) );
		$result = $query->get();
		return array('documents' => $result);
	}

	/* For notes messages */
	public function notes_messages($value,$where)
	{
		$query= DB::table('agents_notes')
		->leftJoin('agents_conversation_message', 'agents_conversation_message.messages_id', '=', 'agents_notes.notes_item_id')
		->where(function($query1) use ($value)
      	{
          	$query1->where(array('agents_conversation_message.sender_id' => $value->sender_id,'agents_conversation_message.sender_role' => $value->sender_role))
                ->where(array('agents_conversation_message.receiver_id' => $value->details_id,'agents_conversation_message.receiver_role' => 4));
      	})
      	->orWhere(function($query1) use ($value)
      	{
          	$query1->Where(array('agents_conversation_message.sender_id' => $value->details_id,'agents_conversation_message.sender_role' => 4))
                ->Where(array('agents_conversation_message.receiver_id' => $value->sender_id,'agents_conversation_message.receiver_role' => $value->sender_role));
      	})
		->where( array(
					'agents_notes.sender_id' 	=> $value->sender_id,
					'agents_notes.sender_role' 	=> $value->sender_role,
					'agents_notes.receiver_id' 	=> $value->details_id,
					'agents_notes.receiver_role' => 4,
					'agents_conversation_message.post_id' 	=> $value->post_id,
					'agents_notes.notes_type'	=> 1,
				) )
		->select('agents_conversation_message.*','agents_notes.notes','agents_notes.notes_id',DB::raw('(CASE WHEN agents_conversation_message.sender_id = '.$value->sender_id.' AND agents_conversation_message.sender_role = '.$value->sender_role.' THEN "right"  WHEN agents_conversation_message.receiver_id = '.$value->sender_id.'  AND agents_conversation_message.receiver_role = '.$value->sender_role.' THEN "left" END) AS is_user'))
		->groupBy('agents_conversation_message.messages_id');
		$result = $query->get();
		return array('notes_messages' => $result);
	}

	/* For notes asked question */
	public function notes_asked_question($value,$where)
	{

		$queryc = DB::table('agents_notes')
				->join('agents_question', 'agents_question.question_id', '=', 'agents_notes.notes_item_id')
				->leftjoin('agents_answers', 'agents_answers.question_id', '=', 'agents_question.question_id')
			    ->where( array(
    						'agents_notes.sender_id' 		=> $value->sender_id,
    						'agents_notes.sender_role' 		=> $value->sender_role,
    						'agents_notes.receiver_id' 		=> $value->details_id,
    						'agents_notes.receiver_role' 	=> 4,
    						'agents_notes.notes_type'		=> 2,
    						'agents_notes.notes_item_parent_id'		=> $value->post_id,
    						'agents_answers.post_id'		=> $value->post_id,
    						'agents_answers.from_id'		=> $value->sender_id,
    						'agents_answers.from_role'		=> $value->sender_role,
    						'agents_answers.is_deleted'		=> '0',
    					) )
				->select('agents_notes.notes_id','agents_notes.notes','agents_question.question_id','agents_question.question','agents_question.importance','agents_answers.answers','agents_answers.answers_id');
		$result = $queryc->get();
		return array('notes_asked_question' => $result);

	}

	/* For notes answers */
	public function notes_answers($value,$where)
	{
		$queryc = DB::table('agents_notes')
				->join('agents_question', 'agents_question.question_id', '=', 'agents_notes.notes_item_parent_id')
				->join('agents_answers', 'agents_answers.answers_id', '=', 'agents_notes.notes_item_id')
			    ->where( array(
    						'agents_notes.sender_id' 	=> $value->sender_id,
    						'agents_notes.sender_role' 	=> $value->sender_role,
    						'agents_notes.receiver_id' 	=> $value->details_id,
    						'agents_notes.receiver_role' => 4,
    						'agents_notes.notes_type'	=> 3,
    						'agents_answers.post_id'		=> $value->post_id,
    					) )
				->select('agents_notes.notes_id','agents_notes.notes','agents_question.question_id','agents_question.question','agents_question.importance','agents_answers.answers','agents_answers.answers_id');

		$result = $queryc->get();
		return array('notes_answers' => $result);
	}

	/* For notes proposal */
	public function notes_proposal($value,$where)
	{
		$queryc = DB::table('agents_notes')
				->join('agents_proposals', 'agents_proposals.proposals_id', '=', 'agents_notes.notes_item_id')
			    ->where( array(
    						'agents_notes.sender_id' 	=> $value->sender_id,
    						'agents_notes.sender_role' 	=> $value->sender_role,
    						'agents_notes.receiver_id' 	=> $value->details_id,
    						'agents_notes.receiver_role' => 4,
    						'agents_notes.notes_type'	=> 4,
    						'agents_notes.notes_item_parent_id'	=> $value->post_id,
    					) )
				->select('agents_notes.notes_id','agents_notes.notes','agents_proposals.proposals_id','agents_proposals.proposals_title','agents_proposals.proposals_attachments');

		$result = $queryc->get();
		return array('notes_proposal' => $result);
	}

	/* For notes agents */
	public function notes_agents($value,$where)
	{
		$queryc = DB::table('agents_notes')
			    ->where( array(
    						'agents_notes.sender_id' 	=> $value->sender_id,
    						'agents_notes.sender_role' 	=> $value->sender_role,
    						'agents_notes.receiver_id' 	=> $value->details_id,
    						'agents_notes.receiver_role'=> 4,
    						'agents_notes.notes_item_id'=> $value->details_id,
    						'agents_notes.notes_item_parent_id'=> $value->post_id,
    						'agents_notes.notes_type'	=> 5,
    					) )
				->select('agents_notes.notes_id','agents_notes.notes');

		$result = $queryc->first();
		return array('notes_agents' => $result);
	}

	public function get_agent_rating($agent_ids){
		$compare_items = ($agent_ids != '') ? explode(',', $agent_ids) : NULL;

		$rating_arr = [];
		foreach ($compare_items as $agentid) {
			$avg_rat = DB::table('agents_rating')->where('rating_item_id', $agentid)->avg('rating');
			$rating_arr[$agentid] = $avg_rat;
		}
		return $rating_arr;
	}
}
