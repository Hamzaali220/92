<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Userdetails extends Model
{
    protected $table = 'agents_users_details';
    protected $primaryKey = "details_id";

    public function details()
    {
    }

    public function EditFieldsUserdetailsModel($where = array(), $update = array())
    {
        $result = DB::table('agents_users_details')->where($where)->update($update);
        return $result;
    }
    /*public function securtyQuestion(){
		 $result =DB::table('agents_securty_question')->where('is_deleted','0')->get();
		return $result;
	}*/

    /* get all data any filed using*/
    public function getCertificationsByAny($where = null, $wherein = null)
    {
        $query = DB::table('agents_certifications')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        if ($wherein != null && !empty($wherein)) {
            $certifications_idarray = explode(',', $wherein['certifications_id']);
            $query->whereIn('certifications_id', $certifications_idarray);
        }
        return $result = $query->get();
    }

    /* get all data any filed using*/
    public function getSpecializationByAny($where = null)
    {

        $query = DB::table('agents_users_agent_skills')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        return $result = $query->get();
    }
    /* get all data any filed using*/
    public function getFranchiseByAny($where = null, $records = null)
    {
        $query = DB::table('agents_franchise')->select('*');

        if ($where != null) {
            $query->where($where);
        }
        if (!empty($records)) :
            return $result = $query->first();
        else :
            return $result = $query->get();
        endif;
    }

    /* For get franchisee details */
    public function getFranchiseeList($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        $query = DB::table('agents_franchise as a')->select('*');
        $query->where('a.is_deleted', '0');

        if (!empty($request['search']['value'])) {
            $query->where('a.franchise_name', 'like', "%" . $request['search']['value'] . "%");
        }
        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)
                ->skip($offset);
        }

        $query->orderBy('a.franchise_id', 'DESC');
        $result['result'] =  $query->get();
        return $result;
    }

    /* get specialization details for list */
    public function getSpecializationList($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        $query = DB::table('agents_users_agent_skills as a')->select('*');
        $query->where('a.is_deleted', '0');

        if (!empty($request['search']['value'])) {
            $query->where('a.skill', 'like', "%" . $request['search']['value'] . "%");
        }
        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)
                ->skip($offset);
        }

        $query->orderBy('a.skill', 'DESC');
        $result['result'] =  $query->get();
        return $result;
    }

    /* Get certification details for list */
    public function getCertificationsList($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        $query = DB::table('agents_certifications as a')->select('*');
        $query->where('a.is_deleted', '0');

        if (!empty($request['search']['value'])) {
            $query->where('a.certifications_name', 'like', "%" . $request['search']['value'] . "%");
            $query->where('a.certifications_description', 'like', "%" . $request['search']['value'] . "%");
        }
        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)
                ->skip($offset);
        }

        $query->orderBy('a.certifications_id', 'DESC');
        $result['result'] =  $query->get();
        return $result;
    }

    /* For get agent details for list */
    public function getAgentList($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        //echo '<pre>'; print_r($request); die;
        $query = DB::table('agents_users as a')->select('a.*', 'b.*', 'c.role_name');
        $query->Join('agents_users_details as b', 'b.details_id', '=', 'a.id');
        $query->Join('agents_users_roles as c', 'c.role_id', '=', 'a.agents_users_role_id');
        $query->where('a.is_deleted', '0');

        if (!empty($request['roleId'])) {
            $query->where('a.agents_users_role_id', $request['roleId']);
        }

        if (!empty($request['search']['value'])) {
            $query->where(function ($query1) use ($request) {
                $query1->where('a.email', 'like', "%" . $request['search']['value'] . "%")
                    ->orwhere('b.name', 'like', "%" . $request['search']['value'] . "%")
                    ->orwhere('b.address', 'like', "%" . $request['search']['value'] . "%")
                    ->orwhere('b.phone', 'like', "%" . $request['search']['value'] . "%");
            });
            /*$query->where('a.email', 'like', "%".$request['search']['value']."%");
			$query->orwhere('b.name', 'like', "%".$request['search']['value']."%");
			$query->orwhere('b.address', 'like', "%".$request['search']['value']."%");
			$query->orwhere('b.phone', 'like', "%".$request['search']['value']."%");*/
        }

        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)
                ->skip($offset);
        }

        $query->orderBy('a.id', 'DESC');
        $result['result'] =  $query->get();
        return $result;
    }

    /* Get seller buyer details for list */
    public function getSellerBuyerList($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        $query = DB::table('agents_users as a')->select('a.*', 'b.*', 'c.role_name');
        $query->Join('agents_users_details as b', 'b.details_id', '=', 'a.id');
        $query->Join('agents_users_roles as c', 'c.role_id', '=', 'a.agents_users_role_id');
        $query->where('a.is_deleted', '0');

        if (!empty($request['roleId'])) {
            $query->whereIn('a.agents_users_role_id', $request['roleId']);
        }

        if (!empty($request['search']['value'])) {
            $query->where(function ($query1) use ($request) {
                $query1->where('a.email', 'like', "%" . $request['search']['value'] . "%")
                    ->orwhere('b.name', 'like', "%" . $request['search']['value'] . "%")
                    ->orwhere('b.address', 'like', "%" . $request['search']['value'] . "%")
                    ->orwhere('b.phone', 'like', "%" . $request['search']['value'] . "%")
                    ->orwhere('c.role_name', 'like', "%" . $request['search']['value'] . "%");
            });
            /*$query->where('a.email', 'like', "%".$request['search']['value']."%");
			$query->orwhere('b.name', 'like', "%".$request['search']['value']."%");
			$query->orwhere('b.address', 'like', "%".$request['search']['value']."%");
			$query->orwhere('b.phone', 'like', "%".$request['search']['value']."%");
			$query->orwhere('c.role_name', 'like', "%".$request['search']['value']."%");*/
        }


        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)
                ->skip($offset);
        }

        # dummy column just for managing index of array
        $sort_columns = ['dummy', 'b.name', 'a.email', 'b.address', 'b.phone', 'b.created_at'];
        if ($request['order'][0]['column'] != 0 && $request['order'][0]['dir'] != "") {
            $query->orderBy($sort_columns[$request['order'][0]['column']], $request['order'][0]['dir']);
        } else {
            $query->orderBy('a.id', 'DESC');
        }
        $query->orderBy('a.id', 'DESC');
        $result['result'] =  $query->get();
        return $result;
    }
    public function newSellerBuyerList($request, $limit = NUll, $offset = NULL)
    {

        $result = array();
        $date = date('Y-m-d H:i:s', strtotime('-7 days'));
        $query = DB::table('agents_users as a')->select('a.*', 'b.*', 'c.role_name');
        $query->Join('agents_users_details as b', 'b.details_id', '=', 'a.id');
        $query->Join('agents_users_roles as c', 'c.role_id', '=', 'a.agents_users_role_id');
        $query->where('a.is_deleted', '0');
        $query->where('a.created_at', '>', $date);

        if (!empty($request['search']['value'])) {
            $query->where('a.email', 'like', "%" . $request['search']['value'] . "%");
            $query->orwhere('b.name', 'like', "%" . $request['search']['value'] . "%");
            $query->orwhere('b.address', 'like', "%" . $request['search']['value'] . "%");
            $query->orwhere('b.phone', 'like', "%" . $request['search']['value'] . "%");
            $query->orwhere('c.role_name', 'like', "%" . $request['search']['value'] . "%");
        }
        if (!empty($request['roleId'])) {
            $query->whereIn('a.agents_users_role_id', $request['roleId']);
        }
        $result['num'] =  count($query->get());

        if (!empty($limit)) {
            $query->take($limit)
                ->skip($offset);
        }


        $query->orderBy('a.id', 'DESC');
        $result['result'] =  $query->get();
        return $result;
    }

    public function city()
    {
        return $this->hasOne(City::class, 'city_id', 'city_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'state_id', 'state_id');
    }
}
