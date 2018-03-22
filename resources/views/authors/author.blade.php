@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="well">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2 ">
                            <img class="center-block img-thumbnail img-responsive" src='{{ $author->photo }}'/>
                        </div>
                        <div class="col-md-7">
                            <h1 class="hidden-xs hidden-sm">{{ $author->author_name }}</h1>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"><b>Дата рождения:</b></div>
                                <div class="col-md-9">{{ $author->date_birth }}</div>
                            </div>
                            @if($author->date_death)
                                <div class="row ">
                                    <div class="col-md-3"><b>Дата смерти:</b></div>
                                    <div class="col-md-9">{{ $author->date_death }}</div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-3"><b>Последняя книга:</b></div>
                                <div class="col-md-9">{{ $lastBook }} год</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><b>Жанры:</b></div>
                                <div class="col-md-9">
                                    @foreach($genres as $genre)
                                        <a href="{{ route('genre', ['slug' => $genre->slug]) }}">{{ $genre->genre }}</a>,
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <h2>Биография:</h2>
                            <p class="">{{ $author->biography }}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="sidebar mb-3">
                                <h5>Книгии автора ({{ count($author->books) }}):</h5>
                                <div>
                                    @foreach($author->books as $book)
                                        <a href="{{ route('book', ['slug' => $book->slug]) }}">{{ $book->title }}</a> ({{ $book->date_published }})
                                        <br>
                                    @endforeach
                                </div>
                            </div>

                            <div class="sidebar">
                                <h5>Соавторы:</h5>
                                <div>
                                    @foreach($partners as $partner)
                                        <a href="{{ route('author', ['slug' => $partner->slug]) }}">{{ $partner->author_name }}</a> ({{ $partner->count }} книги)
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