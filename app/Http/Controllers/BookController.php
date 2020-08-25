<?php

namespace App\Http\Controllers;

use App\Helpers\BookPreload;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(['error' => false, 'message' => 'Welcome!!!']);
    }

    public function preloadBooks(Request $request, BookPreload $preload)
    {
        $numberOfBooks = $request->input('number', 10);

        $preload->loadBooks($numberOfBooks);
        return response()->json(['error' => false, 'message' => 'Completed']);
    }

}
