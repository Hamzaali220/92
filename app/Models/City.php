<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'agents_city';
    protected $primaryKey = 'city_id';


    /* For state and city */
    public function stateAndCity()
    {
        return $this->belongsTo('App\State', 'state_id', 'state_id');
    }

    /* For city */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
}
