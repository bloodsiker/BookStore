<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{

    public function findStore($slug)
    {
        $store = Store::where('slug', $slug)->first();
        $store->load('books', 'city');

        $country = DB::table('countries')
            ->join('cities', 'cities.country_id', 'countries.id')
            ->select('countries.*')
            ->where('cities.id', $store->city->id)
            ->first();

        $authors = $store->authorInStore($store->id);

        return view('stores.store', compact('store', 'authors', 'country'));
    }


    /**
     * @param $slug
     * @param $book_slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookInStore($slug, $book_slug)
    {
        $store = Store::where('slug', $slug)->first();
        $book = Book::where('slug', $book_slug)->first();
        $book->load('country', 'authors', 'genres', 'stores');

        $stores = $book->storesInWithBook();

        $quantity = DB::table('books_stores')->where('book_id', $book->id)->where('store_id', $store->id)->sum('quantity');

        $countries = $book->countiesInWithBook();

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

        return view('stores.show_book', compact('store', 'book', 'quantity', 'countries', 'stores'));
    }
}
