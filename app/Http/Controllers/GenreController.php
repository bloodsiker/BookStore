<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{

    public function findBooksInGenre($slug)
    {
        $genre = Genre::where('slug', $slug)->first();

        $booksList = DB::table('books_stores')
            ->join('books', 'books.id', '=', 'books_stores.book_id')
            ->join('books_genres', 'books_stores.book_id', '=', 'books_genres.book_id')
            ->join('genres', 'genres.id', '=', 'books_genres.genre_id')
            ->select('books.*')
            ->where('genres.slug', $slug)
            ->groupBy('books_stores.book_id')
            ->orderBy('books.id', 'DESC')
            ->get();

        return view('genres.books_in_genre', compact('booksList', 'genre'));
    }
}
