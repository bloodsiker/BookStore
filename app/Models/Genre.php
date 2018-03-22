<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $timestamps = false;

    protected $fillable = ['genre', 'slug'];


    public function books()
    {
        return $this->belongsToMany('App\Models\Book', 'books_genres', 'genre_id', 'book_id');
    }
}
