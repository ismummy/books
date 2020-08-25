<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\BookPreload;
use App\Models\Book;
use App\Models\BookCharacter;
use App\Models\Character;
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

    public function getCharacters(Request $request, $bookId)
    {
        $orderBy = $request->input('orderBy', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter');

        if ($filter) {
            $characters = Character::whereHas('books', function ($q) use ($bookId) {
                return $q->where('books.id', $bookId);
            })->where('gender', $filter)->orderBy($orderBy, $order)->get();
        } else {
            $characters = Character::whereHas('books', function ($q) use ($bookId) {
                return $q->where('books.id', $bookId);
            })->orderBy($orderBy, $order)->get();
        }
        return $this->responseHelper->processResponse($characters);
    }

    public function preloadBooks(Request $request, BookPreload $preload)
    {
        $numberOfBooks = $request->input('number', 10);

        $preload->loadBooks($numberOfBooks);
        return response()->json(['error' => false, 'message' => 'Completed']);
    }

}
