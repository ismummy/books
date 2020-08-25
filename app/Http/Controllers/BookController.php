<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\BookPreload;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $responseHelper;

    public function __construct(ApiResponse $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index()
    {
        return $this->responseHelper->processResponse(null, 'Welcome!!!');
    }

    public function getBooks()
    {
        $books = Book::withCount(['authors', 'comments', 'characters'])->with(['authors'])->orderBy('released', 'DESC')->get();

        return $this->responseHelper->processResponse($books);
    }

    public function preloadBooks(Request $request, BookPreload $preload)
    {
        $numberOfBooks = $request->input('number', 10);

        $preload->loadBooks($numberOfBooks);
        return response()->json(['error' => false, 'message' => 'Completed']);
    }

}
