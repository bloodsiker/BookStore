@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <form action="{{ route('search') }}" method="get" id="find-author" class="form-horizontal form-filter p-3 mt-4">
                    <div class="form-group ui-widget">
                        <small id="author-error" class="form-text"></small>
                        <input type="text" name="author" class="form-control" id="author" placeholder="Автор">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                <form action="{{ route('search') }}" method="get" id="find-title" class="form-horizontal form-filter p-3 mt-4">
                    <div class="form-group">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <span>{{ $error }}</span><br>
                                @endforeach
                            </div>
                        @endif
                        <small id="title-error" class="form-text"></small>
                        <input type="text" name="book_title" class="form-control" id="book-title" placeholder="Название книги">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                <form class="form-horizontal form-filter p-3 mt-4" id="filter">
                    <div class="form-group">
                        <label for="country">Страна</label>
                        <select class="form-control" name="country" id="country" onchange="changeCountry(this)">
                            <option value="all">Все страны</option>
                            @foreach($countryList as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">Город</label> <span class="load_city"></span>
                        <select class="form-control" name="city" id="city" onchange="changeCity(this)">
                            <option value="">Not select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="store">Магазин</label> <span class="load_store"></span>
                        <select class="form-control" name="store" id="store" onchange="changeStore(this)">
                            <option value="">Not select</option>
                        </select>
                    </div>
                    <fieldset class="form-group">
                        <div class="form-check">
                            @foreach($genresList as $genre)
                                <div>
                                    <label class="form-check-label">
                                        <input type="checkbox" name="genre" value="{{ $genre->id }}" onchange="changeGenre(event)" class="form-check-input">
                                        {{ $genre->genre }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="col-sm-9">
                <div class="row" id="list-books">
                    @foreach($booksList as $book)
                        <div class="col-sm-6 col-md-3 mt-4">
                            <div class="card card-inverse card-info">
                                <a href="{{ route('book', ['slug' => $book->slug]) }}">
                                    <img class="card-img-top" src="{{ $book->image }}" alt="{{ $book->title }}">
                                </a>
                                <div class="card-block">
                                    <h4 class="card-title">{{ $book->title }}</h4>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('book', ['slug' => $book->slug]) }}" class="btn btn-info float-right btn-sm">Посмотреть</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
