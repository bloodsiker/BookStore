<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    protected $fillable = ['city_name', 'slug'];


    public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }
}
