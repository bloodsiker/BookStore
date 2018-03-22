@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="well">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <h1 class="hidden-xs hidden-sm">Магазин «{{ $store->store_name }}»</h1>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"><b>Страна:</b></div>
                                <div class="col-md-9">{{ $country->country_name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-3"><b>Город:</b></div>
                                <div class="col-md-9">{{ $store->city->city_name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Количество кнги:</b></div>
                                <div class="col-md-9">{{ count($store->books) }}</div>
                            </div>
                            <hr>
                            <h2>Книги:</h2>
                            <div class="row">
                                @foreach($store->books as $book)
                                    <div class="col-sm-6 col-md-3 mt-4">
                                        <div class="card card-inverse card-info">
                                            <a href="{{ route('store.book', ['slug' => $store->slug, 'book_slug' => $book->slug]) }}">
                                                <img class="card-img-top" src="{{ $book->image }}" alt="{{ $book->title }}">
                                            </a>
                                            <div class="card-block">
                                                <h4 class="card-title">{{ $book->title }}</h4>
                                            </div>
                                            <div class="card-footer">
                                                <a href="{{ route('store.book', ['slug' => $store->slug, 'book_slug' => $book->slug]) }}" class="btn btn-info float-right btn-sm">Подробней</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="sidebar mb-3">
                                <strong>Представленные авторы:</strong>
                                <div>
                                    @foreach($authors as $author)
                                        <a href="{{ route('author', ['slug' => $author->slug]) }}">{{ $author->author_name }}</a> - {{ $author->quantity }} книг
                                        <br>
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