<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

Route::get('/', 'SiteController@index')->name('home');

Route::post('filter-ajax', 'SearchController@filterAjax')->name('filter-ajax');
Route::post('search-author', 'SearchController@searchAuthor')->name('search-author');
Route::get('search', 'SearchController@search')->name('search');

Route::get('book/country/{slug}', 'BookController@bookPublishedCountry')->name('book.country');
Route::get('book/{slug}', 'BookController@find')->name('book');

Route::get('store/{slug}', 'StoreController@findStore')->name('store');
Route::get('store/{slug}/book/{book_slug}', 'StoreController@bookInStore')->name('store.book');

Route::get('author/{slug}', 'AuthorController@findAuthor')->name('author');

Route::get('genre/{slug}', 'GenreController@findBooksInGenre')->name('genre');

