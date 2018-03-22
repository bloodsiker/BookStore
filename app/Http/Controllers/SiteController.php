<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index()
    {
        $countryList = Country::all();
        $genresList = Genre::all();

        $booksList = DB::table('books_stores')
            ->join('books', 'books.id', '=', 'books_stores.book_id')
            ->join('stores', 'stores.id', '=', 'books_stores.store_id')
            ->join('countries', 'countries.id', '=', 'books.country_id')
            ->select('books.*', 'countries.country_name')
            ->groupBy('books_stores.book_id')
            ->orderBy('books.id', 'DESC')
            ->get();

        return view('index', compact('countryList', 'genresList', 'booksList'));
    }
}
