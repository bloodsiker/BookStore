<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;

    protected $fillable = ['country_name', 'slug'];

    public function city()
    {
        return $this->hasMany('App\Models\City');
    }
}
