@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>Книги из жанра "{{ $genre->genre }}"</h1>
            </div>
            <div class="col-sm-12">
                <div class="row">
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
                                    <a href="{{ route('book', ['slug' => $book->slug]) }}" class="btn btn-info float-right btn-sm">Подробней</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
