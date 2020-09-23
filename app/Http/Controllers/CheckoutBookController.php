<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CheckoutBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * @param  \App\Models\Book  $book
     */
    public function store(Book $book){

        $book->checkout(auth()->user());

    }
}
