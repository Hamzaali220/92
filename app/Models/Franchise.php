<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Franchise extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected $table = 'agents_franchise';
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('age', function (Builder $builder) {
    //         dd($builder);
    //     });
    // }
}
