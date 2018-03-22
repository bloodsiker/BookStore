<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'content', 'enabled'];


    public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Models\Author', 'books_authors', 'book_id', 'author_id');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre', 'books_genres', 'book_id', 'genre_id');
    }

    public function stores()
    {
        return $this->belongsToMany('App\Models\Store', 'books_stores', 'book_id', 'store_id');
    }


    /**
     * @return mixed
     */
    public function storesInWithBook()
    {
        return DB::table('books_stores')
            ->join('stores', 'stores.id', 'books_stores.store_id')
            ->select('stores.store_name', 'stores.slug', 'books_stores.price')
            ->where('book_id', $this->id)
            ->get();
    }


    /**
     * @return mixed
     */
    public function countiesInWithBook()
    {
        return DB::table('books_stores')
            ->join('stores', 'stores.id', '=', 'books_stores.store_id')
            ->join('cities', 'cities.id', '=', 'stores.city_id')
            ->join('countries', 'countries.id', '=', 'cities.country_id')
            ->select('countries.country_name', 'countries.slug')
            ->where('book_id', $this->id)
            ->groupBy(['countries.country_name', 'countries.slug'])
            ->get();
    }


    /**
     * @param $bookId
     *
     * @return mixed
     */
    public function bookShopInCity($bookId)
    {
        $sql = "SELECT 
                ANY_VALUE(cities.city_name) as city_name,
                ANY_VALUE(countries.country_name) as country_name,
                SUM(books_stores.quantity) as quantity
                FROM books_stores
                    INNER JOIN stores
                        ON books_stores.store_id = stores.id
                    INNER JOIN cities
                        ON stores.city_id = cities.id
                    INNER JOIN countries
                        ON cities.country_id = countries.id
                WHERE books_stores.book_id = {$bookId}
                GROUP BY cities.city_name";

        return DB::select($sql);
    }
}
