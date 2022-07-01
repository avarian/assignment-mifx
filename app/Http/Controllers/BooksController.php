<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        // @TODO implement
        $params = $request->except('_token');

        return BookResource::collection(Book::filter($params)->paginate(15));
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $book = new Book();
        $book->isbn = $request->isbn;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->published_year = $request->published_year;
        $book->save();

        $authors = Author::find($request->authors);

        $book->authors()->attach($authors);

        return new BookResource($book);
    }
}
