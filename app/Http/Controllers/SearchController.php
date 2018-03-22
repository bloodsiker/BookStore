<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\City;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function searchAuthor(Request $request)
    {
//        DB::listen(function($sql) {
//            var_dump($sql);
//        });
        $author = $request->author;
        $result = Author::where('author_name', 'like', '%' . $author . '%')->select('author_name')->get();
        return response()->json($result);
    }


    public function filterAjax(Request $request)
    {

        $response = [];
        $query = DB::table('books_stores')
            ->join('books', 'books.id', '=', 'books_stores.book_id')
            ->join('stores', 'stores.id', '=', 'books_stores.store_id')
            ->join('cities', 'cities.id', '=', 'stores.city_id')
            ->join('countries', 'countries.id', '=', 'cities.country_id')
            ->join('books_genres', 'books_genres.book_id', '=', 'books_stores.book_id')
            ->select('books.title', 'books.slug', 'books.image');


        // Фильтрайия по по старнам
        if($request->action == 'get_city_list'){
            if($request->country_id != 'all'){
                $response['cities'] = City::where('country_id', $request->country_id)->get()->toArray();
                $query->where('countries.id', $request->country_id);
            } else {
                $response['cities'] = [];
            }
        }

        // Фильтрайия по городам
        if($request->action == 'get_store_list'){
            $response['stores'] = Store::where('city_id', $request->city_id)->get()->toArray();
            $query->where('cities.id', $request->city_id);
        }

        // Фильтрайия по магазинам
        if($request->action == 'get_store_books'){
            $query->where('stores.id', $request->store_id);
        }

        //Фильтрация по жанрам
        if($request->action == 'get_genres_books'){
            if(!empty($request->genres)){
                $genres = explode(',', $request->genres);
                $query->whereIn('books_genres.genre_id',  $genres);
            }
        }

        $booksList = $query->groupBy('books_stores.book_id')
            ->orderBy('books.id', 'DESC')
            ->get();

        $response['books'] = $booksList;
        return response()->json($response);
    }


    public function search(Request $request)
    {
        $search = null;

        $query = DB::table('books_stores')
            ->join('books_authors', 'books_authors.book_id', '=', 'books_stores.book_id')
            ->join('authors', 'authors.id', '=', 'books_authors.author_id')
            ->join('books', 'books.id', '=', 'books_stores.book_id')
            ->select('books.*');

        if($request->has('author')){

            $this->validate($request, [
                'author' => 'required|min:3|max:255',
            ]);

            $search = $request->author;

            $query->where('authors.author_name', 'like', '%' . $search . '%');
        }

        if($request->has('book_title')){
            $this->validate($request, [
                'book_title' => 'required|min:3|max:255',
            ]);
            $search = $request->book_title;

            $query->where('books.title', 'like', '%' . $search . '%');
        }

        $booksList = $query->groupBy('books_stores.book_id')
            ->orderBy('books.id', 'DESC')
            ->get();

        return view('search.search', compact('booksList', 'search'));
    }
}
