<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function find($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $book->load('country', 'authors', 'genres', 'stores');

        $stores = $book->storesInWithBook();

        $quantity = DB::table('books_stores')->where('book_id', $book->id)->sum('quantity');

        $countries = $book->countriesInWithBook();

        $cities = $book->bookShopInCity($book->id);

        $countries->map(function ($country) use ($cities) {
            $i = 0;
            foreach ($cities as $city){
                if($country->country_name == $city->country_name){
                    $country->city[$i]['city'] = $city->city_name;
                    $country->city[$i]['quantity'] = $city->quantity;
                    $i++;
                }
            }
            return $country;
        });

        return view('books.show_book', compact('book', 'quantity', 'countries', 'stores'));
    }


    /**
     * Книги выпущенные в $slug стране
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookPublishedCountry($slug)
    {
        $country = Country::where('slug', $slug)->first();

        $booksList = DB::table('books_stores')
            ->join('books', 'books.id', '=', 'books_stores.book_id')
            ->join('countries', 'countries.id', '=', 'books.country_id')
            ->select('books.*', 'countries.country_name')
            ->where('countries.slug', $slug)
            ->groupBy('books_stores.book_id')
            ->orderBy('books.id', 'DESC')
            ->get();

        return view('books.books_published_country', compact('booksList', 'country'));
    }
}
