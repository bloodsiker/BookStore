@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="well">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 ">
                            <img class="center-block img-responsive" src='{{ $book->image }}'/>
                        </div>
                        <div class="col-md-6">
                            <h2 class="hidden-xs hidden-sm">{{ $book->title }}</h2>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"><b>Автор(ы):</b></div>
                                <div class="col-md-9">
                                    @foreach($book->authors as $author)
                                        <a href="{{ route('author', ['slug' => $author->slug]) }}">{{ $author->author_name }}</a>
                                        ,
                                    @endforeach
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-3"><b>Жанры(ы):</b></div>
                                <div class="col-md-9">
                                    @foreach($book->genres as $genre)
                                        <a href="{{ route('genre', ['slug' => $genre->slug]) }}">{{ $genre->genre }}</a>
                                        ,
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Год издания:</b></div>
                                <div class="col-md-9">{{ $book->date_published }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Страна:</b></div>
                                <div class="col-md-9">
                                    <a href="{{ route('book.country', ['slug' => $book->country->slug]) }}">{{ $book->country->country_name }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <b>Количество книг:</b> {{ $quantity }}
                                </div>
                            </div>
                            <hr>
                            <h2>Краткое описание</h2>
                            <p class="text-justify">{{ $book->description }}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="sidebar mb-3">
                                <h5>Магазин(ы):</h5>
                                <div>
                                    @foreach($stores as $store)
                                        <a href="{{ route('store', ['slug' => $store->slug]) }}">{{ $store->store_name }}</a> &mdash; {{ $store->price }} грн
                                        <br>
                                    @endforeach
                                </div>
                            </div>

                            <div class="sidebar">
                                <h5>Книга представленна:</h5>
                                <div>
                                    @foreach($countries as $country)
                                        <div>
                                            <span>{{ $country->country_name }}</span>
                                            @foreach($country->city as $city)
                                                <div style="margin-left: 15px">
                                                    - {{ $city['city'] }} ({{ $city['quantity'] }} книг)
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection