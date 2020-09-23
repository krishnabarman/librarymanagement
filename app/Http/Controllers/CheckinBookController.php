<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;

class CheckinBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * @param  \App\Models\Book  $book
     */
    public function store(Book $book)
    {
        try {

            $book->checkin(auth()->user());
            
        } catch (Exception $ex) {
            return response([], 404);
        }
    }
}
