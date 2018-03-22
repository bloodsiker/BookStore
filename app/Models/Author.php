<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Author extends Model
{
    public $timestamps = false;

    protected $fillable = ['author_name', 'slug', 'biography', 'date_birth', 'date_death'];


    public function books()
    {
        return $this->belongsToMany('App\Models\Book', 'books_authors', 'author_id', 'book_id');
    }


    /**
     * Находим в которых представленны книги автора
     * @param $authorId
     *
     * @return mixed
     */
    public function genres($authorId)
    {
        return DB::table('books_authors')
            ->join('books', 'books.id', '=', 'books_authors.book_id')
            ->join('books_genres', 'books_genres.book_id', '=', 'books.id')
            ->join('genres', 'genres.id', '=', 'books_genres.genre_id')
            ->select('genres.*')
            ->where('author_id', $authorId)
            ->distinct()
            ->get(['genres.genre']);
    }


    /**
     * Поиск соавторов
     * @param $bookIds
     * @param $authorId
     *
     * @return mixed
     */
    public function partner($bookIds, $authorId)
    {
        $sql = "SELECT 
                distinct (ba1.author_id),
                authors.author_name,
                authors.slug,
                (SELECT COUNT(id) FROM books_authors ba2 WHERE ba1.author_id = ba2.author_id) as count
            FROM books_authors ba1
            INNER JOIN authors
              ON ba1.author_id = authors.id
            WHERE ba1.book_id IN({$bookIds})
            AND ba1.author_id <> {$authorId}";

        return DB::select($sql);
    }

}
