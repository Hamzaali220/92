<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shared extends Model
{
    protected $table = 'agents_shared';
    protected $primaryKey = "shared_id";

    /* get all data any filed using*/
    public function getDetailsByAnylimit($limit, $where = null)
    {
        $query = DB::table('agents_shared')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        $count = $query->count();
        $result = $query->skip($limit * 3)->take(3)->get();
        $coun = floor($count / 3);
        $prview = $limit == 0 ? 0 : $limit - 1;
        $next   = $coun == $limit ? 0 : ($count <= 3 ? 0 : $limit + 1);
        $rlimit = $limit * 3 == 0 ? 1 : $limit * 3;
        $llimit = $next * 3 == 0 ? $count : $next * 3;

        $data = array('result' => $result, 'count' => $count, 'llimit' => $llimit, 'rlimit' => $rlimit, 'prview' => $prview, 'next' => $next);

        return $data;
    }

    /* For insert & update */
    public function inserupdate($data = null, $id = null)
    {
        if (empty($id)) {
            $result = DB::table('agents_shared')->insertGetId($data);
        } else {
            $result = DB::table('agents_shared')->where($id)->update($data);
        }
        return $result;
    }

    /* get all data any filed using Answers table*/
    public function getDetailsByAny($where = null)
    {
        $query = DB::table('agents_shared')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        return $result = $query->get();
    }
    /* get all data any filed using Answers table*/
    public function getsinglerowByAny($where = null)
    {
        $query = DB::table('agents_shared')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('created_at', 'DESC');
        return $result = $query->first();
    }
    /* get all data any filed using Answers table*/
    public function getsharedquestionandanswer($where = null, $wherein = null)
    {
        $query = DB::table('agents_shared')->select('agents_shared.*', 'agents_question.*');
        $query->Join('agents_question', 'agents_question.question_id', '=', 'agents_shared.shared_item_id');
        if ($where != null) {
            $query->where($where);
        }
        if ($wherein != null) {
            $query->whereIn($wherein['colume'], [$wherein['value']]);
        }
        $query->orderBy('agents_shared.created_at', 'DESC');
        $result = $query->get();
        return $result;
    }
    /* get all data any filed using Answers table*/
    public function getshareduploadfiles($where = null)
    {
        $query = DB::table('agents_shared')->select('agents_shared.*', 'agents_upload_share_all.*');
        $query->Join('agents_upload_share_all', 'agents_upload_share_all.upload_share_id', '=', 'agents_shared.shared_item_id');
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('agents_shared.created_at', 'DESC');
        $result = $query->get();
        return $result;
    }
    /* get all data any filed using Answers table*/
    public function getsharedProposals($where = null)
    {
        $query = DB::table('agents_shared')->select('agents_shared.*', 'agents_proposals.*');
        $query->Join('agents_proposals', 'agents_proposals.proposals_id', '=', 'agents_shared.shared_item_id');
        if ($where != null) {
            $query->where($where);
        }
        $query->orderBy('agents_shared.created_at', 'DESC');
        $result = $query->get();
        return $result;
    }

    /* GetSharedPropsalUsersAndConnectedUers */
    public function GetSharedPropsalUsersAndConnectedUers($proposal_id, $userid, $user_role, $where = null)
    {
        $query1 = DB::table('agents_users_conections')
            ->join('agents_users_details', function ($join) {
                $join->on('agents_users_details.details_id', '=', 'agents_users_conections.to_id')
                    ->orOn('agents_users_details.details_id', '=', 'agents_users_conections.from_id');
            })
            ->Join('agents_posts', 'agents_posts.post_id', '=', 'agents_users_conections.post_id')
            ->where(function ($query) use ($userid, $user_role) {

                $query->where(function ($query) use ($userid, $user_role) {
                    $query->where(array('agents_users_conections.to_id' => $userid, 'agents_users_conections.to_role' => $user_role));
                })
                    ->orWhere(function ($query) use ($userid, $user_role) {
                        $query->where(array('agents_users_conections.from_id' => $userid, 'agents_users_conections.from_role' => $user_role));
                    });
            })
            ->where(function ($query) use ($userid, $user_role) {
                $query->whereRaw(DB::raw(

                    'CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . '

		                    THEN agents_users_conections.from_id 	= 	agents_users_details.details_id

		                    WHEN agents_users_conections.from_id 	= ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . '

		                    THEN agents_users_conections.to_id 		= 	agents_users_details.details_id END'

                ));
            });
        if (!empty($where)) :
            if ($where['date'] && $where['date'] != '') {
                $dd = explode('-', $where['date']);
                $dd1 = date('Y-m-d', strtotime($dd[0]));
                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query1->where(function ($query) use ($dd1, $dd2) {
                    $query->whereBetween('agents_users_conections.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['address'] && $where['address'] != '') {
                $query1->where(function ($query) use ($where) {
                    $query->where('agents_users_details.address', 'LIKE', "%" . $where['address'] . "%");
                    $query->orWhere('agents_users_details.address2', 'LIKE', "%" . $where['address'] . "%");
                    $query->orWhere('agents_users_details.zip_code', 'LIKE', "%" . $where['address'] . "%");
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {
                $query1->where(function ($query) use ($where) {
                    $query->where('agents_users_details.name', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }
        endif;

        // $query1->where('agents_posts.is_deleted','0');
        // $query1->where('agents_posts.applied_post', "2");
        $query1->select('agents_posts.agents_user_id', 'agents_posts.agents_users_role_id', 'agents_posts.posttitle', 'agents_posts.post_id', 'agents_users_details.name', 'agents_users_details.details_id', DB::raw('(CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . ' THEN agents_users_conections.from_role  WHEN agents_users_conections.from_id = ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . ' THEN agents_users_conections.to_role END) AS details_id_role_id'), 'agents_users_conections.to_id', 'agents_users_conections.to_role', 'agents_users_conections.from_id', 'agents_users_conections.from_role', DB::raw('(CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . ' THEN "to"  WHEN agents_users_conections.from_id = ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . ' THEN "from" END) AS is_user'))
            ->orderBy('agents_users_conections.updated_at', 'DESC');

        $queryunion = $query1;

        $count = $queryunion->count();
        $result = $queryunion->get();
        $obj = [];
        foreach ($result as $value) {

            $post_share_count = $this->sharedatajoin($value, $proposal_id, $userid, $user_role, 3);
            $obj[] = (object) array_merge((array) $value, (array) $post_share_count);
        }
        $result = $obj;
        return array('result' => $result, 'count' => $count);
    }

    /* Share data process */
    public function sharedatajoin($value, $proposal_id, $userid, $roleid, $type)
    {
        $queryc = DB::table('agents_shared')
            ->where(array(
                'agents_shared.shared_item_id'     => $proposal_id,
                'agents_shared.shared_item_type_id' => $value->post_id,
                'agents_shared.sender_id'         => $userid,
                'agents_shared.sender_role'     => $roleid,
                'agents_shared.receiver_id'     => $value->details_id,
                'agents_shared.receiver_role'     => $value->details_id_role_id,
                'agents_shared.shared_type'        => $type,
            ))
            ->select('agents_shared.shared_id');

        $result = $queryc->first();
        $data = array();
        $data['share_file'] = array('result' => $result);
        return $data;
    }

    /* GetSharedPropsalUsersAndConnectedUers */
    public function GetSharedDocumentUsersAndConnectedUers($docs_id, $userid, $user_role, $where = null)
    {
        $query1 = DB::table('agents_users_conections')
            ->join('agents_users_details', function ($join) {
                $join->on('agents_users_details.details_id', '=', 'agents_users_conections.to_id')
                    ->orOn('agents_users_details.details_id', '=', 'agents_users_conections.from_id');
            })
            ->Join('agents_posts', 'agents_posts.post_id', '=', 'agents_users_conections.post_id')
            ->where(function ($query) use ($userid, $user_role) {

                $query->where(function ($query) use ($userid, $user_role) {
                    $query->where(array('agents_users_conections.to_id' => $userid, 'agents_users_conections.to_role' => $user_role));
                })
                    ->orWhere(function ($query) use ($userid, $user_role) {
                        $query->where(array('agents_users_conections.from_id' => $userid, 'agents_users_conections.from_role' => $user_role));
                    });
            })
            ->where(function ($query) use ($userid, $user_role) {
                $query->whereRaw(DB::raw(

                    'CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . '

		                    THEN agents_users_conections.from_id 	= 	agents_users_details.details_id

		                    WHEN agents_users_conections.from_id 	= ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . '

		                    THEN agents_users_conections.to_id 		= 	agents_users_details.details_id END'

                ));
            });

        if (!empty($where)) :
            if ($where['date'] && $where['date'] != '') {
                $dd = explode('-', $where['date']);
                $dd1 = date('Y-m-d', strtotime($dd[0]));
                $dd2 = date('Y-m-d', strtotime($dd[1]));

                $query1->where(function ($query) use ($dd1, $dd2) {
                    $query->whereBetween('agents_users_conections.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['address'] && $where['address'] != '') {
                $query1->where(function ($query) use ($where) {
                    $query->where('agents_users_details.address', 'LIKE', "%" . $where['address'] . "%");
                    $query->orWhere('agents_users_details.address2', 'LIKE', "%" . $where['address'] . "%");
                    $query->orWhere('agents_users_details.zip_code', 'LIKE', "%" . $where['address'] . "%");
                });
            }

            if ($where['keyword'] && $where['keyword'] != '') {
                $query1->where(function ($query) use ($where) {
                    $query->where('agents_users_details.name', 'LIKE', "%" . $where['keyword'] . "%");
                });
            }
        endif;
        $query1->where('agents_posts.is_deleted', '0');
        $query1->where('agents_posts.applied_post', "2");
        $query1->select('agents_posts.agents_user_id', 'agents_posts.agents_users_role_id', 'agents_posts.posttitle', 'agents_posts.post_id', 'agents_users_details.name', 'agents_users_details.details_id', DB::raw('(CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . ' THEN agents_users_conections.from_role  WHEN agents_users_conections.from_id = ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . ' THEN agents_users_conections.to_role END) AS details_id_role_id'), 'agents_users_conections.to_id', 'agents_users_conections.to_role', 'agents_users_conections.from_id', 'agents_users_conections.from_role', DB::raw('(CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . ' THEN "to"  WHEN agents_users_conections.from_id = ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . ' THEN "from" END) AS is_user'))
            ->orderBy('agents_users_conections.updated_at', 'DESC');
        $queryunion = $query1;

        $count = $queryunion->count();
        $result = $queryunion->get();
        $obj = [];
        foreach ($result as $value) {

            $post_share_count = $this->sharedatajoin($value, $docs_id, $userid, $user_role, 2);
            $obj[] = (object) array_merge((array) $value, (array) $post_share_count);
        }
        $result = $obj;
        return array('result' => $result, 'count' => $count);
    }

    /* For Share questions */
    public function GetSharedQuestionUsersAndConnectedUers($question_id, $share_user_type, $userid, $user_role, $where = null)
    {
        $query1 = DB::table('agents_users_conections')
            ->join('agents_users_details', function ($join) {
                $join->on('agents_users_details.details_id', '=', 'agents_users_conections.to_id')
                    ->orOn('agents_users_details.details_id', '=', 'agents_users_conections.from_id');
            })
            ->Join('agents_posts', 'agents_posts.post_id', '=', 'agents_users_conections.post_id')
            ->where(function ($query) use ($userid, $user_role, $share_user_type) {

                $query->where(function ($query) use ($share_user_type, $userid, $user_role) {
                    $query->where(array(
                        'agents_users_conections.to_id' => $userid,
                        'agents_users_conections.to_role' => $user_role,
                        'agents_users_conections.from_role' => $share_user_type
                    ));
                })->orWhere(function ($query) use ($share_user_type, $userid, $user_role) {
                    $query->where(array(
                        'agents_users_conections.from_id' => $userid,
                        'agents_users_conections.from_role' => $user_role,
                        'agents_users_conections.to_role' => $share_user_type
                    ));
                });
            })->where(function ($query) use ($userid, $user_role) {
                $query->whereRaw(DB::raw(

                    'CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . '
		                    THEN agents_users_conections.from_id 	= 	agents_users_details.details_id
		                    WHEN agents_users_conections.from_id 	= ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . '
		                    THEN agents_users_conections.to_id 		= 	agents_users_details.details_id END'
                ));
            });
        if (!empty($where)) :
            if (!empty($where['post_id']) && $where['post_id'] != '') {
                $query1->where('agents_posts.post_id', $where['post_id']);
            }
            if ($where['date'] != '') {
                $dd = explode('-', $where['date']);
                $dd1 = date('Y-m-d', strtotime($dd[0]));
                $dd2 = date('Y-m-d', strtotime($dd[1]));
                $dd2 = date('Y-m-d', strtotime('+1 Day'));
                $query1->where(function ($query) use ($dd1, $dd2) {
                    $query->whereBetween('agents_users_conections.created_at', [$dd1, $dd2]);
                });
            }

            if ($where['address'] != '') {
                //$query->where(function($query) use($where){
                $query1->where('agents_users_details.address', 'LIKE', "%" . (string)$where['address'] . "%");
                $query1->orWhere('agents_users_details.address2', 'LIKE', "%" . (string)$where['address'] . "%");
                $query1->orWhere('agents_users_details.zip_code', 'LIKE', "%" . (string)$where['address'] . "%");
                //});
            }

            if ($where['keyword'] != '') {
                //$query1->where(function($query) use($where){
                $query1->where('agents_users_details.name', 'LIKE', "%" . $where['keyword'] . "%");
                $query1->orWhere('agents_users_details.fname', 'LIKE', "%" . $where['keyword'] . "%");
                $query1->orWhere('agents_users_details.lname', 'LIKE', "%" . $where['keyword'] . "%");
                //});
            }
        endif;


        $query1->where('agents_posts.is_deleted', '0');
        $query1->where('agents_posts.applied_post', "2");
        $query1->select('agents_posts.agents_user_id', 'agents_posts.agents_users_role_id', 'agents_posts.posttitle', 'agents_posts.post_id', 'agents_users_details.name', 'agents_users_details.details_id', DB::raw('(CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . ' THEN agents_users_conections.from_role  WHEN agents_users_conections.from_id = ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . ' THEN agents_users_conections.to_role END) AS details_id_role_id'), 'agents_users_conections.to_id', 'agents_users_conections.to_role', 'agents_users_conections.from_id', 'agents_users_conections.from_role', DB::raw('(CASE WHEN agents_users_conections.to_id = ' . $userid . ' AND agents_users_conections.to_role = ' . $user_role . ' THEN "to"  WHEN agents_users_conections.from_id = ' . $userid . '  AND agents_users_conections.from_role = ' . $user_role . ' THEN "from" END) AS is_user'))
            ->orderBy('agents_users_conections.updated_at', 'DESC')
            ->groupBy('agents_users_details.details_id');
        $queryunion = $query1;

        $count = $queryunion->count();
        $result = $queryunion->get();
        $obj = [];
        foreach ($result as $value) {

            $post_share_count = $this->sharedatajoin($value, $question_id, $userid, $user_role, 1);
            $obj[] = (object) array_merge((array) $value, (array) $post_share_count);
        }
        $result = $obj;
        return array('result' => $result, 'count' => $count);
    }
}
