<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    public $timestamps = false;

    protected $fillable = ['store_name', 'slug'];


    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id');
    }



    public function books()
    {
        return $this->belongsToMany('App\Models\Book', 'books_stores', 'store_id', 'book_id');
    }


    public function authorInStore($storeId)
    {
        $sql = "SELECT 
                    authors.author_name, 
                    authors.slug,
                    (SELECT COUNT(id) FROM books_authors ba1 WHERE ba1.author_id = books_authors.author_id) as quantity
                FROM books_stores 
                    INNER JOIN books_authors
                        ON books_authors.book_id = books_stores.book_id
                    INNER JOIN authors 
                        ON authors.id = books_authors.author_id
                    WHERE books_stores.store_id = {$storeId}
                    GROUP BY books_authors.author_id
                    ORDER BY authors.author_name";

        return DB::select($sql);
    }
}
