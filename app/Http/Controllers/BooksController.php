<?php

namespace App\Http\Controllers;

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

        return BookResource::collection(Book::paginate(15));
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $book = new Book();

        return new BookResource($book);
    }
}
