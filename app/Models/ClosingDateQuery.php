<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClosingDateQuery extends Model
{
    protected $fillable = ['comments', 'closing_date', 'status'];

    protected $table = 'closingdate_queries';

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }
    public function agent()
    {
        return $this->belongsTo('App\User', 'agent_id');
    }
    public function agentdetails()
    {
        return $this->belongsTo('App\Userdetails', 'agent_id');
    }
    public function buyerorseller()
    {
        return $this->belongsTo('App\User', 'sellerorbuyer_id');
    }
    public function buyerorsellerdetails()
    {
        return $this->belongsTo('App\Userdetails', 'sellerorbuyer_id');
    }
}
