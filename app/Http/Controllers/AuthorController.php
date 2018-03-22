<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function findAuthor($slug)
    {
        $author = Author::where('slug', $slug)->first();
        $author->load('books');

        $lastBook = $author->books->max('date_published');

        $genres = $author->genres($author->id);

        $bookIds = $author->books->implode('id', ', ');
        $partners = $author->partner($bookIds, $author->id);

        return view('authors.author', compact('author', 'lastBook', 'genres', 'partners'));
    }
}
