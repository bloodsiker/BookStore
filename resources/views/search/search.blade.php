@extends('layouts.app')

@section('content')
    <div class="container">
        @if(count($booksList) > 0)
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h3>Результаты поиска по запросу «{{ $search }}»</h3>
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
        @else
            <div class="row justify-content-md-center">
                <div class="col-sm-12 text-center">
                    <h3> По запросу «{{ $search }}» ничего не найдено</h3>
                </div>
                <div class="col-md-6 form-filter mt-5 p-3">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="name@example.com">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                        </div>
                        <div class="form-group">
                            <label for="message">Сообщение</label>
                            <textarea class="form-control" name="message" id="message" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary pull-right">Отправить</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
